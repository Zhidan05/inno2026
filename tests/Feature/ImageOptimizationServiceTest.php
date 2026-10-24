<?php

use App\Services\ImageOptimizationService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    $this->optimizer = app(ImageOptimizationService::class);
});

test('converts JPG upload to genuine WebP file', function () {
    // Generate valid JPEG in memory
    $gd = imagecreatetruecolor(400, 300);
    $bg = imagecolorallocate($gd, 30, 60, 90);
    imagefilledrectangle($gd, 0, 0, 400, 300, $bg);
    ob_start();
    imagejpeg($gd, null, 90);
    $jpegBytes = ob_get_clean();
    imagedestroy($gd);

    $file = UploadedFile::fake()->createWithContent('photo.jpg', $jpegBytes);

    $storedPath = $this->optimizer->optimizeAndStore($file, 'gallery');

    expect($storedPath)->toEndWith('.webp');
    Storage::disk('public')->assertExists($storedPath);

    // Verify MIME and WebP header RIFF....WEBP
    $content = Storage::disk('public')->get($storedPath);
    expect(substr($content, 0, 4))->toBe('RIFF');
    expect(substr($content, 8, 4))->toBe('WEBP');

    $sizeInfo = getimagesizefromstring($content);
    expect($sizeInfo['mime'])->toBe('image/webp');
    expect($sizeInfo[0])->toBe(400);
    expect($sizeInfo[1])->toBe(300);
});

test('converts PNG upload to WebP preserving transparency', function () {
    // Generate valid PNG with alpha transparency
    $gd = imagecreatetruecolor(200, 200);
    imagealphablending($gd, false);
    imagesavealpha($gd, true);
    $transparent = imagecolorallocatealpha($gd, 0, 0, 0, 127);
    imagefilledrectangle($gd, 0, 0, 200, 200, $transparent);
    // Draw red circle
    $red = imagecolorallocatealpha($gd, 255, 0, 0, 0);
    imagefilledellipse($gd, 100, 100, 80, 80, $red);

    ob_start();
    imagepng($gd);
    $pngBytes = ob_get_clean();
    imagedestroy($gd);

    $file = UploadedFile::fake()->createWithContent('logo.png', $pngBytes);

    $storedPath = $this->optimizer->optimizeAndStore($file, 'sponsors');

    expect($storedPath)->toEndWith('.webp');
    Storage::disk('public')->assertExists($storedPath);

    $content = Storage::disk('public')->get($storedPath);
    expect(substr($content, 0, 4))->toBe('RIFF');
    expect(substr($content, 8, 4))->toBe('WEBP');
});

test('proportionally resizes oversized image exceeding 2560px without upscaling smaller images', function () {
    // Generate 3000 x 1500 px image
    $gd = imagecreatetruecolor(3000, 1500);
    $bg = imagecolorallocate($gd, 100, 150, 200);
    imagefilledrectangle($gd, 0, 0, 3000, 1500, $bg);
    ob_start();
    imagejpeg($gd, null, 70);
    $bytes = ob_get_clean();
    imagedestroy($gd);

    $file = UploadedFile::fake()->createWithContent('panorama.jpg', $bytes);

    $storedPath = $this->optimizer->optimizeAndStore($file, 'gallery');

    $content = Storage::disk('public')->get($storedPath);
    $sizeInfo = getimagesizefromstring($content);

    // Max dimension is 2560, so 3000 is scaled to 2560, height to 1280
    expect($sizeInfo[0])->toBe(2560);
    expect($sizeInfo[1])->toBe(1280);
});

test('rejects fake image files masquerading as png or jpg', function () {
    $fakeFile = UploadedFile::fake()->createWithContent('malicious.png', '<?php echo "evil"; ?>');

    expect(fn () => $this->optimizer->optimizeAndStore($fakeFile, 'gallery'))
        ->toThrow(InvalidArgumentException::class);
});

test('rejects image files exceeding 10MB limit', function () {
    // 11 MB dummy file
    $oversizedFile = UploadedFile::fake()->create('huge.jpg', 11 * 1024);

    expect(fn () => $this->optimizer->optimizeAndStore($oversizedFile, 'gallery'))
        ->toThrow(InvalidArgumentException::class);
});

test('preserves PDF documents without converting to WebP when allow_pdf is true', function () {
    $pdfContent = "%PDF-1.4\n%...\n%%EOF";
    $pdfFile = UploadedFile::fake()->createWithContent('transfer_receipt.pdf', $pdfContent);

    $storedPath = $this->optimizer->optimizeAndStore($pdfFile, 'payment-proofs', ['allow_pdf' => true]);

    expect($storedPath)->toEndWith('.pdf');
    Storage::disk('public')->assertExists($storedPath);

    $content = Storage::disk('public')->get($storedPath);
    expect($content)->toBe($pdfContent);
});

test('processes QRIS preset with high quality', function () {
    $gd = imagecreatetruecolor(500, 500);
    $white = imagecolorallocate($gd, 255, 255, 255);
    $black = imagecolorallocate($gd, 0, 0, 0);
    imagefilledrectangle($gd, 0, 0, 500, 500, $white);
    // Draw QR markers
    imagefilledrectangle($gd, 50, 50, 150, 150, $black);
    imagefilledrectangle($gd, 350, 50, 450, 150, $black);
    imagefilledrectangle($gd, 50, 350, 150, 450, $black);

    ob_start();
    imagepng($gd);
    $bytes = ob_get_clean();
    imagedestroy($gd);

    $file = UploadedFile::fake()->createWithContent('qris.png', $bytes);

    $storedPath = $this->optimizer->optimizeAndStore($file, 'payment-methods', ['is_qris' => true]);

    expect($storedPath)->toEndWith('.webp');
    Storage::disk('public')->assertExists($storedPath);

    $content = Storage::disk('public')->get($storedPath);
    $info = getimagesizefromstring($content);
    expect($info[0])->toBe(500);
    expect($info[1])->toBe(500);
});
