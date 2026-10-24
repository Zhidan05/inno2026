<?php

namespace Database\Seeders;

use App\Enums\PaymentMethodType;
use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure storage directory exists
        if (! Storage::disk('public')->exists('payment-methods')) {
            Storage::disk('public')->makeDirectory('payment-methods');
        }

        $qrisRelativePath = 'payment-methods/qris-innoelectrica.webp';
        $fullPath = storage_path('app/public/'.$qrisRelativePath);

        // Generate crisp sample QRIS code WebP if not exists
        if (! file_exists($fullPath)) {
            $img = imagecreatetruecolor(500, 500);
            $white = imagecolorallocate($img, 255, 255, 255);
            $black = imagecolorallocate($img, 15, 23, 42);
            $red = imagecolorallocate($img, 220, 38, 38);
            imagefilledrectangle($img, 0, 0, 500, 500, $white);

            // Header banner
            imagefilledrectangle($img, 0, 0, 500, 60, $black);

            // Three corner finder patterns
            $this->drawFinder($img, 40, 90, $black, $white);
            $this->drawFinder($img, 370, 90, $black, $white);
            $this->drawFinder($img, 40, 370, $black, $white);

            // Matrix modules
            mt_srand(2026);
            for ($i = 0; $i < 20; $i++) {
                for ($j = 0; $j < 20; $j++) {
                    $px = 140 + ($i * 11);
                    $py = 140 + ($j * 11);
                    if (mt_rand(0, 1) === 1) {
                        imagefilledrectangle($img, $px, $py, $px + 9, $py + 9, $black);
                    }
                }
            }

            // Central logo square
            imagefilledrectangle($img, 215, 215, 285, 285, $white);
            imagefilledrectangle($img, 225, 225, 275, 275, $red);

            imagewebp($img, $fullPath, 98);
            imagedestroy($img);
        }

        // 2. Create QRIS Method
        PaymentMethod::firstOrCreate(
            ['name' => 'QRIS InnoElectrica'],
            [
                'type' => PaymentMethodType::QRIS,
                'instructions' => 'Pindai kode QRIS menggunakan e-wallet atau mobile banking apa saja (BCA Mobile, Livin, GoPay, OVO, Dana). Pastikan nominal transfer sesuai dengan biaya pendaftaran.',
                'is_active' => true,
                'sort_order' => 1,
                'qris_image' => $qrisRelativePath,
            ]
        );

        // 3. Create Bank BCA Transfer Method
        PaymentMethod::firstOrCreate(
            ['name' => 'Transfer Bank BCA'],
            [
                'type' => PaymentMethodType::BANK_TRANSFER,
                'instructions' => 'Mohon sertakan nama tim atau nama peserta pada berita transfer. Simpan bukti transfer dalam format JPG, PNG, atau PDF untuk diupload.',
                'is_active' => true,
                'sort_order' => 2,
                'bank_name' => 'BCA',
                'account_number' => '08312345678',
                'account_holder_name' => 'Panitia InnoElectrica 2026',
            ]
        );

        // 4. Create Bank Mandiri Transfer Method
        PaymentMethod::firstOrCreate(
            ['name' => 'Transfer Bank Mandiri'],
            [
                'type' => PaymentMethodType::BANK_TRANSFER,
                'instructions' => 'Transfer dapat dilakukan via ATM atau Livin by Mandiri. Pastikan nama rekening tujuan adalah Panitia InnoElectrica.',
                'is_active' => true,
                'sort_order' => 3,
                'bank_name' => 'Mandiri',
                'account_number' => '1080019283746',
                'account_holder_name' => 'InnoElectrica UNRI',
            ]
        );
    }

    private function drawFinder($img, int $x, int $y, int $black, int $white): void
    {
        imagefilledrectangle($img, $x, $y, $x + 90, $y + 90, $black);
        imagefilledrectangle($img, $x + 15, $y + 15, $x + 75, $y + 75, $white);
        imagefilledrectangle($img, $x + 30, $y + 30, $x + 60, $y + 60, $black);
    }
}
