<?php

namespace App\Console\Commands;

use App\Models\Gallery;
use App\Models\MediaPartner;
use App\Models\PaymentMethod;
use App\Models\Registration;
use App\Models\Sponsor;
use App\Services\ImageOptimizationService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MigrateLegacyImagesToWebp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:migrate-webp
                            {--dry-run : Simulate the migration without modifying files or database records}
                            {--delete-originals : Delete old original files after verified conversion and DB update}
                            {--chunk=50 : Number of records to chunk per query}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely migrate existing stored raster images to genuine WebP format and update database references';

    protected ImageOptimizationService $optimizer;

    protected string $disk = 'public';

    protected int $totalScanned = 0;

    protected int $totalConverted = 0;

    protected int $totalSkipped = 0;

    protected int $totalFailed = 0;

    protected int $totalBytesSaved = 0;

    public function __construct(ImageOptimizationService $optimizer)
    {
        parent::__construct();
        $this->optimizer = $optimizer;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $deleteOriginals = (bool) $this->option('delete-originals');
        $chunkSize = (int) $this->option('chunk');

        $this->info('=====================================================');
        $this->info('InnoElectrica 2026 — Legacy Image WebP Migration Tool');
        $this->info('=====================================================');

        if ($dryRun) {
            $this->warn('MODE: DRY-RUN (No files or database records will be modified).');
        } else {
            $this->warn('MODE: LIVE MIGRATION');
            if ($deleteOriginals) {
                $this->warn('WARNING: Original non-WebP files will be deleted after verified conversion.');
            } else {
                $this->info('Original non-WebP files will be retained as backup.');
            }
        }

        $this->newLine();

        // 1. Sponsors
        $this->processModelImages(
            Sponsor::class,
            'logo',
            'Sponsors (logo)',
            $chunkSize,
            $dryRun,
            $deleteOriginals
        );

        // 2. Media Partners
        $this->processModelImages(
            MediaPartner::class,
            'logo',
            'Media Partners (logo)',
            $chunkSize,
            $dryRun,
            $deleteOriginals
        );

        // 3. Galleries
        $this->processModelImages(
            Gallery::class,
            'image',
            'Galleries (image)',
            $chunkSize,
            $dryRun,
            $deleteOriginals
        );

        // 4. Payment Methods QRIS
        $this->processModelImages(
            PaymentMethod::class,
            'qris_image',
            'Payment Methods (qris_image)',
            $chunkSize,
            $dryRun,
            $deleteOriginals,
            ['is_qris' => true]
        );

        // 5. Registrations (Payment Proofs)
        $this->processModelImages(
            Registration::class,
            'proof_of_payment',
            'Registrations (proof_of_payment)',
            $chunkSize,
            $dryRun,
            $deleteOriginals
        );

        // 6. Registrations (Submission Files if raster image)
        $this->processModelImages(
            Registration::class,
            'submission_file_path',
            'Registrations (submission_file_path)',
            $chunkSize,
            $dryRun,
            $deleteOriginals
        );

        $this->newLine();
        $this->info('================ MIGRATION SUMMARY ================');
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Records Scanned', $this->totalScanned],
                ['Skipped (Already WebP / PDF / Missing)', $this->totalSkipped],
                ['Successfully Converted', $this->totalConverted],
                ['Failed Conversions', $this->totalFailed],
                ['Total Storage Saved', round($this->totalBytesSaved / 1024, 2).' KB ('.round($this->totalBytesSaved / 1048576, 2).' MB)'],
            ]
        );

        return $this->totalFailed > 0 ? Command::FAILURE : Command::SUCCESS;
    }

    /**
     * Process image attribute for an Eloquent model.
     *
     * @param  class-string<Model>  $modelClass
     */
    protected function processModelImages(
        string $modelClass,
        string $attribute,
        string $label,
        int $chunkSize,
        bool $dryRun,
        bool $deleteOriginals,
        array $options = []
    ): void {
        $this->line("<comment>Checking {$label}...</comment>");

        $query = $modelClass::query()->whereNotNull($attribute)->where($attribute, '!=', '');
        $count = $query->count();

        if ($count === 0) {
            $this->line("  - No records found for {$label}.");

            return;
        }

        $query->chunkById($chunkSize, function ($records) use ($attribute, $dryRun, $deleteOriginals, $options) {
            foreach ($records as $record) {
                $this->totalScanned++;
                $currentPath = $record->{$attribute};

                if (! $currentPath) {
                    $this->totalSkipped++;

                    continue;
                }

                $ext = strtolower(pathinfo($currentPath, PATHINFO_EXTENSION));

                // If already WebP, skip
                if ($ext === 'webp') {
                    $this->totalSkipped++;

                    continue;
                }

                // If PDF or non-image document, skip
                if (in_array($ext, ['pdf', 'zip', 'rar', 'docx', 'xlsx', 'txt'], true)) {
                    $this->totalSkipped++;

                    continue;
                }

                if (! Storage::disk($this->disk)->exists($currentPath)) {
                    $this->warn("  [MISSING] Record #{$record->getKey()}: file {$currentPath} does not exist in storage.");
                    $this->totalSkipped++;

                    continue;
                }

                // Attempt conversion
                $res = $this->optimizer->optimizeExistingFile($this->disk, $currentPath, $options);

                if (! $res['converted']) {
                    if ($res['reason'] && (str_contains($res['reason'], 'skipped') || str_contains($res['reason'], 'already in WebP'))) {
                        $this->totalSkipped++;
                    } else {
                        $this->error("  [FAILED] Record #{$record->getKey()}: {$res['reason']}");
                        $this->totalFailed++;
                    }

                    continue;
                }

                $newPath = $res['new_path'];
                $saved = $res['original_size'] - $res['new_size'];

                if ($dryRun) {
                    $this->info(sprintf(
                        '  [DRY-RUN] Record #%s: %s (%s KB) -> %s (%s KB) [Saved: %s KB]',
                        $record->getKey(),
                        $currentPath,
                        round($res['original_size'] / 1024, 1),
                        $newPath,
                        round($res['new_size'] / 1024, 1),
                        round($saved / 1024, 1)
                    ));
                    // In dry run, clean up test converted file so no orphan remains
                    if (Storage::disk($this->disk)->exists($newPath)) {
                        Storage::disk($this->disk)->delete($newPath);
                    }
                    $this->totalConverted++;
                    $this->totalBytesSaved += max(0, $saved);
                } else {
                    // LIVE UPDATE: Verify target file exists and is non-empty
                    if (Storage::disk($this->disk)->exists($newPath) && Storage::disk($this->disk)->size($newPath) > 0) {
                        $record->{$attribute} = $newPath;
                        $record->save();

                        $this->info(sprintf(
                            '  [OK] Record #%s: %s -> %s (Saved: %s KB)',
                            $record->getKey(),
                            $currentPath,
                            $newPath,
                            round($saved / 1024, 1)
                        ));

                        $this->totalConverted++;
                        $this->totalBytesSaved += max(0, $saved);

                        // Delete original only if requested and new path differs
                        if ($deleteOriginals && $currentPath !== $newPath && Storage::disk($this->disk)->exists($currentPath)) {
                            Storage::disk($this->disk)->delete($currentPath);
                        }
                    } else {
                        $this->error("  [VERIFICATION FAILED] Record #{$record->getKey()}: Converted file is invalid. Database update aborted.");
                        $this->totalFailed++;
                    }
                }
            }
        });
    }
}
