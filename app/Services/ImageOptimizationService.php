<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use RuntimeException;

class ImageOptimizationService
{
    /**
     * Supported raster image mime types for WebP conversion.
     */
    protected const RASTER_MIME_TYPES = [
        'image/jpeg',
        'image/jpg',
        'image/pjpeg',
        'image/png',
        'image/x-png',
        'image/webp',
        'image/bmp',
        'image/x-ms-bmp',
        'image/gif',
    ];

    /**
     * Optimize an uploaded file (from controller or Filament) and save as WebP or validated document.
     *
     * @param  UploadedFile|TemporaryUploadedFile|string  $file  Uploaded file or absolute/relative file path
     * @param  string  $directory  Target directory inside the disk (e.g., 'sponsors', 'gallery', 'payment-methods')
     * @param  array  $options  Custom options (disk, is_qris, quality, target_size_kb, allow_pdf)
     * @return string Relative storage path of the stored file
     */
    public function optimizeAndStore(
        UploadedFile|TemporaryUploadedFile|string $file,
        string $directory,
        array $options = []
    ): string {
        $disk = $options['disk'] ?? config('image_optimization.disk', 'public');
        $isQris = (bool) ($options['is_qris'] ?? false);
        $allowPdf = (bool) ($options['allow_pdf'] ?? false);

        // Resolve local file path and size
        [$tempSourcePath, $originalFilename, $fileSize] = $this->resolveFileInfo($file, $disk);

        try {
            // Check max upload size
            $maxUploadBytes = (int) config('image_optimization.max_upload_size_kb', 10240) * 1024;
            if ($fileSize > $maxUploadBytes) {
                throw new InvalidArgumentException(sprintf(
                    'File size (%s MB) exceeds maximum limit of %s MB.',
                    round($fileSize / 1048576, 2),
                    round($maxUploadBytes / 1048576, 2)
                ));
            }

            // Detect actual MIME type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $tempSourcePath);
            finfo_close($finfo);

            // Handle PDF (if explicitly allowed, e.g. for payment proof or submissions)
            if ($allowPdf && $mimeType === 'application/pdf') {
                return $this->storePdfFile($tempSourcePath, $directory, $disk);
            }

            // Handle SVG
            if ($mimeType === 'image/svg+xml' || str_ends_with(strtolower($originalFilename), '.svg')) {
                return $this->handleSvgFile($tempSourcePath, $directory, $disk, $options);
            }

            // Ensure file is an actual supported raster image
            if (! in_array($mimeType, self::RASTER_MIME_TYPES, true)) {
                throw new InvalidArgumentException("File format is not supported or not a valid image (MIME: {$mimeType}).");
            }

            // Process raster image to WebP
            return $this->processRasterToWebP($tempSourcePath, $directory, $disk, $isQris, $options);
        } finally {
            // If the tempSourcePath was a transient copy created by resolveFileInfo, clean it up
            if (isset($options['_is_temporary_copy']) && file_exists($tempSourcePath)) {
                @unlink($tempSourcePath);
            }
        }
    }

    /**
     * Resolve file info from various input types.
     *
     * @return array{0: string, 1: string, 2: int}
     */
    protected function resolveFileInfo(UploadedFile|TemporaryUploadedFile|string $file, string $disk): array
    {
        if ($file instanceof UploadedFile || $file instanceof TemporaryUploadedFile) {
            $path = $file->getRealPath();
            if (! $path || ! file_exists($path)) {
                // If getRealPath is empty, save to temporary file
                $tempPath = tempnam(sys_get_temp_dir(), 'inno_img_');
                file_put_contents($tempPath, $file->get());

                return [$tempPath, $file->getClientOriginalName(), (int) $file->getSize()];
            }

            return [$path, $file->getClientOriginalName(), (int) $file->getSize()];
        }

        if (file_exists($file)) {
            return [$file, basename($file), (int) filesize($file)];
        }

        // Check if file exists on disk
        if (Storage::disk($disk)->exists($file)) {
            $tempPath = tempnam(sys_get_temp_dir(), 'inno_disk_');
            file_put_contents($tempPath, Storage::disk($disk)->get($file));

            return [$tempPath, basename($file), (int) Storage::disk($disk)->size($file)];
        }

        throw new InvalidArgumentException("Source file not found: {$file}");
    }

    /**
     * Process raster image, rotate according to EXIF, resize down if exceeding bounds,
     * preserve transparency, optimize quality, and write WebP to storage.
     */
    protected function processRasterToWebP(
        string $sourcePath,
        string $directory,
        string $disk,
        bool $isQris,
        array $options = []
    ): string {
        $fileContents = file_get_contents($sourcePath);
        if ($fileContents === false || strlen($fileContents) === 0) {
            throw new RuntimeException('Failed to read image file data.');
        }

        // Check image header / dimensions using getimagesize
        $imageSize = @getimagesize($sourcePath);
        if ($imageSize === false) {
            throw new InvalidArgumentException('File is not a valid raster image or image data is corrupted.');
        }

        $origWidth = $imageSize[0];
        $origHeight = $imageSize[1];

        // Create GD resource from string
        $image = @imagecreatefromstring($fileContents);
        if (! $image) {
            throw new RuntimeException('Failed to process image with GD library.');
        }

        $tempWebpPath = tempnam(sys_get_temp_dir(), 'inno_webp_');

        try {
            // Handle EXIF orientation (rotates phone photos correctly)
            $image = $this->correctExifOrientation($image, $sourcePath);

            // Re-read dimensions after rotation
            $currentWidth = imagesx($image);
            $currentHeight = imagesy($image);

            // Maximum dimensions constraint (2560x2560)
            $maxDimension = (int) ($options['max_dimension'] ?? config('image_optimization.max_dimension', 2560));

            // Resize down if needed; NEVER upscale smaller images
            if ($currentWidth > $maxDimension || $currentHeight > $maxDimension) {
                $image = $this->resizeImageWithinBounds($image, $currentWidth, $currentHeight, $maxDimension);
            }

            // Preserve alpha channel transparency
            imagepalettetotruecolor($image);
            imagealphablending($image, false);
            imagesavealpha($image, true);

            // Determine quality presets
            $initialQuality = $isQris
                ? (int) ($options['quality'] ?? config('image_optimization.quality.qris', 98))
                : (int) ($options['quality'] ?? config('image_optimization.quality.default', 85));

            $minQuality = $isQris
                ? (int) config('image_optimization.quality.min_qris', 90)
                : (int) config('image_optimization.quality.min', 65);

            $targetSizeBytes = (int) ($options['target_size_kb'] ?? config('image_optimization.target_size_kb', 1024)) * 1024;

            // Progressive quality compression
            $currentQuality = $initialQuality;
            $bestQuality = $currentQuality;
            $converted = false;

            while ($currentQuality >= $minQuality) {
                // Generate WebP into temp file
                $success = imagewebp($image, $tempWebpPath, $currentQuality);
                if (! $success) {
                    throw new RuntimeException('Failed to compress image to WebP.');
                }

                clearstatcache(true, $tempWebpPath);
                $generatedSize = filesize($tempWebpPath);
                $converted = true;

                // For QRIS or if size is within target, stop stepping down
                if ($isQris || $generatedSize <= $targetSizeBytes || $currentQuality <= $minQuality) {
                    break;
                }

                // Step down quality
                $bestQuality = $currentQuality;
                $currentQuality -= 5;
            }

            if (! $converted || ! file_exists($tempWebpPath) || filesize($tempWebpPath) === 0) {
                throw new RuntimeException('Failed to generate a valid WebP file.');
            }

            // Save to final storage
            $uuid = Str::uuid()->toString();
            $targetFilename = rtrim($directory, '/')."/{$uuid}.webp";

            $webpData = file_get_contents($tempWebpPath);
            Storage::disk($disk)->put($targetFilename, $webpData);

            return $targetFilename;
        } finally {
            if (is_resource($image) || (is_object($image) && $image instanceof \GdImage)) {
                imagedestroy($image);
            }
            if (file_exists($tempWebpPath)) {
                @unlink($tempWebpPath);
            }
        }
    }

    /**
     * Correct image orientation based on EXIF data.
     *
     * @param  \GdImage|resource  $image
     * @return \GdImage|resource
     */
    protected function correctExifOrientation($image, string $filePath)
    {
        if (! function_exists('exif_read_data')) {
            return $image;
        }

        $exif = @exif_read_data($filePath);
        if (empty($exif['Orientation'])) {
            return $image;
        }

        $orientation = (int) $exif['Orientation'];
        $rotated = null;

        switch ($orientation) {
            case 3: // 180 rotate
                $rotated = imagerotate($image, 180, 0);
                break;
            case 6: // 90 rotate CW
                $rotated = imagerotate($image, -90, 0);
                break;
            case 8: // 90 rotate CCW
                $rotated = imagerotate($image, 90, 0);
                break;
        }

        if ($rotated) {
            imagedestroy($image);

            return $rotated;
        }

        return $image;
    }

    /**
     * Proportionally downscale image so it fits within max dimension bounds.
     *
     * @param  \GdImage|resource  $source
     * @return \GdImage|resource
     */
    protected function resizeImageWithinBounds($source, int $width, int $height, int $maxDimension)
    {
        $ratio = min($maxDimension / $width, $maxDimension / $height);
        $newWidth = (int) max(1, round($width * $ratio));
        $newHeight = (int) max(1, round($height * $ratio));

        $target = imagecreatetruecolor($newWidth, $newHeight);
        imagepalettetotruecolor($target);
        imagealphablending($target, false);
        imagesavealpha($target, true);

        // Fill background with transparent color
        $transparent = imagecolorallocatealpha($target, 0, 0, 0, 127);
        imagefilledrectangle($target, 0, 0, $newWidth, $newHeight, $transparent);

        imagecopyresampled($target, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($source);

        return $target;
    }

    /**
     * Safely store a valid PDF file.
     */
    protected function storePdfFile(string $sourcePath, string $directory, string $disk): string
    {
        $handle = fopen($sourcePath, 'rb');
        $header = fread($handle, 4);
        fclose($handle);

        if ($header !== '%PDF') {
            throw new InvalidArgumentException('Invalid or corrupted PDF file.');
        }

        $uuid = Str::uuid()->toString();
        $targetFilename = rtrim($directory, '/')."/{$uuid}.pdf";

        Storage::disk($disk)->put($targetFilename, file_get_contents($sourcePath));

        return $targetFilename;
    }

    /**
     * Handle SVG uploads safely.
     */
    protected function handleSvgFile(string $sourcePath, string $directory, string $disk, array $options = []): string
    {
        $content = file_get_contents($sourcePath);

        // Check for malicious XML entities or inline scripts
        if (
            stripos($content, '<script') !== false ||
            stripos($content, 'javascript:') !== false ||
            stripos($content, '<!ENTITY') !== false ||
            stripos($content, 'SYSTEM') !== false
        ) {
            throw new InvalidArgumentException('SVG file contains malicious scripts or entities.');
        }

        if (stripos($content, '<svg') === false) {
            throw new InvalidArgumentException('File is not a valid SVG.');
        }

        $uuid = Str::uuid()->toString();
        $targetFilename = rtrim($directory, '/')."/{$uuid}.svg";

        Storage::disk($disk)->put($targetFilename, $content);

        return $targetFilename;
    }

    /**
     * Generate a reusable closure for Filament FileUpload saveUploadedFileUsing.
     */
    public static function filamentUploadHandler(string $directory, array $options = []): \Closure
    {
        return function (TemporaryUploadedFile $file) use ($directory, $options): string {
            /** @var ImageOptimizationService $service */
            $service = app(ImageOptimizationService::class);

            return $service->optimizeAndStore($file, $directory, $options);
        };
    }

    /**
     * Convert an existing file on disk to WebP safely (used by migration command).
     *
     * @return array{converted: bool, old_path: string, new_path: string, original_size: int, new_size: int, reason: ?string}
     */
    public function optimizeExistingFile(string $disk, string $relativePath, array $options = []): array
    {
        $isQris = (bool) ($options['is_qris'] ?? false);

        if (! Storage::disk($disk)->exists($relativePath)) {
            return [
                'converted' => false,
                'old_path' => $relativePath,
                'new_path' => $relativePath,
                'original_size' => 0,
                'new_size' => 0,
                'reason' => 'File not found on disk.',
            ];
        }

        $ext = strtolower(pathinfo($relativePath, PATHINFO_EXTENSION));

        // Skip non-raster or already WebP unless force reprocess requested
        if ($ext === 'pdf') {
            return [
                'converted' => false,
                'old_path' => $relativePath,
                'new_path' => $relativePath,
                'original_size' => Storage::disk($disk)->size($relativePath),
                'new_size' => Storage::disk($disk)->size($relativePath),
                'reason' => 'File is a PDF document (skipped).',
            ];
        }

        if ($ext === 'webp' && empty($options['force'])) {
            return [
                'converted' => false,
                'old_path' => $relativePath,
                'new_path' => $relativePath,
                'original_size' => Storage::disk($disk)->size($relativePath),
                'new_size' => Storage::disk($disk)->size($relativePath),
                'reason' => 'File is already in WebP format.',
            ];
        }

        $tempSource = tempnam(sys_get_temp_dir(), 'inno_mig_orig_');
        file_put_contents($tempSource, Storage::disk($disk)->get($relativePath));

        $originalSize = (int) filesize($tempSource);
        $directory = dirname($relativePath);
        if ($directory === '.') {
            $directory = '';
        }

        try {
            $newPath = $this->processRasterToWebP(
                $tempSource,
                $directory,
                $disk,
                $isQris,
                $options
            );

            $newSize = Storage::disk($disk)->size($newPath);

            return [
                'converted' => true,
                'old_path' => $relativePath,
                'new_path' => $newPath,
                'original_size' => $originalSize,
                'new_size' => $newSize,
                'reason' => null,
            ];
        } catch (\Throwable $e) {
            return [
                'converted' => false,
                'old_path' => $relativePath,
                'new_path' => $relativePath,
                'original_size' => $originalSize,
                'new_size' => 0,
                'reason' => 'Conversion failed: '.$e->getMessage(),
            ];
        } finally {
            if (file_exists($tempSource)) {
                @unlink($tempSource);
            }
        }
    }
}
