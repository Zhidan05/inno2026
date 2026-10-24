<?php

use App\Enums\PaymentMethodType;
use App\Enums\UserRole;
use App\Models\Competition;
use App\Models\PaymentMethod;
use App\Models\Registration;
use App\Models\User;
use App\Policies\PaymentMethodPolicy;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Storage::fake('public');

    // Create roles
    Role::firstOrCreate(['name' => UserRole::ADMIN->value, 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => UserRole::PARTICIPANT->value, 'guard_name' => 'web']);

    $this->admin = User::factory()->create();
    $this->admin->assignRole(UserRole::ADMIN->value);

    $this->participant = User::factory()->create();
    $this->participant->assignRole(UserRole::PARTICIPANT->value);
});

test('admin can create multiple payment methods including QRIS and Bank Transfer', function () {
    // 1. Create QRIS method
    $qris = PaymentMethod::create([
        'name' => 'QRIS Utama InnoElectrica',
        'type' => PaymentMethodType::QRIS,
        'instructions' => 'Scan with GoPay or BCA Mobile',
        'is_active' => true,
        'sort_order' => 1,
        'qris_image' => 'payment-methods/dummy-qris.webp',
    ]);

    expect($qris)->toBeInstanceOf(PaymentMethod::class)
        ->and($qris->isQris())->toBeTrue()
        ->and($qris->isBankTransfer())->toBeFalse()
        ->and($qris->qris_image)->toBe('payment-methods/dummy-qris.webp');

    // 2. Create BCA method with leading zero in account number
    $bca = PaymentMethod::create([
        'name' => 'Transfer Bank BCA',
        'type' => PaymentMethodType::BANK_TRANSFER,
        'instructions' => 'Berita: NAMA TIM',
        'is_active' => true,
        'sort_order' => 2,
        'bank_name' => 'BCA',
        'account_number' => '083123456789',
        'account_holder_name' => 'Panitia Inno 2026',
    ]);

    // Account number must remain string with leading zero intact
    expect($bca->account_number)->toBe('083123456789')
        ->and(is_string($bca->account_number))->toBeTrue()
        ->and($bca->isBankTransfer())->toBeTrue();

    // 3. Create BRI method
    $bri = PaymentMethod::create([
        'name' => 'Transfer Bank BRI',
        'type' => PaymentMethodType::BANK_TRANSFER,
        'is_active' => true,
        'sort_order' => 3,
        'bank_name' => 'BRI',
        'account_number' => '00192837465',
        'account_holder_name' => 'InnoElectrica UNRI',
    ]);

    expect(PaymentMethod::count())->toBe(3);
});

test('active scope returns only active payment methods ordered by sort_order', function () {
    PaymentMethod::create([
        'name' => 'Metode Ketiga',
        'type' => PaymentMethodType::BANK_TRANSFER,
        'is_active' => true,
        'sort_order' => 30,
        'bank_name' => 'BNI',
        'account_number' => '333',
        'account_holder_name' => 'Test',
    ]);

    PaymentMethod::create([
        'name' => 'Metode Pertama',
        'type' => PaymentMethodType::BANK_TRANSFER,
        'is_active' => true,
        'sort_order' => 10,
        'bank_name' => 'BCA',
        'account_number' => '111',
        'account_holder_name' => 'Test',
    ]);

    PaymentMethod::create([
        'name' => 'Metode Nonaktif',
        'type' => PaymentMethodType::QRIS,
        'is_active' => false,
        'sort_order' => 5,
        'qris_image' => 'payment-methods/inactive.webp',
    ]);

    $active = PaymentMethod::active()->get();

    expect($active)->toHaveCount(2)
        ->and($active->first()->name)->toBe('Metode Pertama')
        ->and($active->last()->name)->toBe('Metode Ketiga')
        ->and($active->pluck('name'))->not->toContain('Metode Nonaktif');
});

test('policy prevents deleting a payment method that is referenced by existing registrations', function () {
    $competition = Competition::factory()->create([
        'registration_fee' => 50000,
        'status' => 'registration_open',
    ]);

    $method = PaymentMethod::create([
        'name' => 'BCA Panitia',
        'type' => PaymentMethodType::BANK_TRANSFER,
        'is_active' => true,
        'sort_order' => 1,
        'bank_name' => 'BCA',
        'account_number' => '123456',
        'account_holder_name' => 'Inno',
    ]);

    // Create registration referencing this method
    $registration = Registration::create([
        'competition_id' => $competition->id,
        'payment_method_id' => $method->id,
        'user_id' => $this->participant->id,
        'registration_mode' => 'solo',
        'team_name' => 'Solo Participant',
        'status' => 'pending',
    ]);

    // Test policy delete check directly
    $policy = new PaymentMethodPolicy;
    expect($policy->delete($this->admin, $method))->toBeFalse();

    // Verify registration reference is safe
    expect($registration->paymentMethod->id)->toBe($method->id);

    // If unreferenced, delete should be allowed
    $unreferencedMethod = PaymentMethod::create([
        'name' => 'Metode Kosong',
        'type' => PaymentMethodType::BANK_TRANSFER,
        'is_active' => false,
        'sort_order' => 99,
        'bank_name' => 'Mandiri',
        'account_number' => '999',
        'account_holder_name' => 'Test',
    ]);

    expect($policy->delete($this->admin, $unreferencedMethod))->toBeTrue();
});

test('participant sees active payment methods and prominent Important Payment Information notice on registration page', function () {
    $competition = Competition::factory()->create([
        'registration_fee' => 75000,
        'registration_type' => 'individual_or_team',
        'registration_open_at' => now()->subDay(),
        'registration_close_at' => now()->addDays(5),
        'status' => 'registration_open',
    ]);

    PaymentMethod::create([
        'name' => 'QRIS Resmi InnoElectrica',
        'type' => PaymentMethodType::QRIS,
        'is_active' => true,
        'sort_order' => 1,
        'qris_image' => 'payment-methods/test.webp',
    ]);

    PaymentMethod::create([
        'name' => 'Transfer Bank BNI Khusus',
        'type' => PaymentMethodType::BANK_TRANSFER,
        'is_active' => true,
        'sort_order' => 2,
        'bank_name' => 'BNI',
        'account_number' => '0987654321',
        'account_holder_name' => 'Bendahara Inno',
    ]);

    PaymentMethod::create([
        'name' => 'Metode Rahasia Nonaktif',
        'type' => PaymentMethodType::BANK_TRANSFER,
        'is_active' => false,
        'sort_order' => 3,
        'bank_name' => 'Bank X',
        'account_number' => '0000',
        'account_holder_name' => 'Nonaktif',
    ]);

    $response = $this->actingAs($this->participant)
        ->get(route('competition.register', $competition->slug));

    $response->assertOk();

    // Prominent note text must be visible
    $response->assertSee('Important Payment Information');
    $response->assertSee('The available QRIS and bank transfer payment methods are static payment methods');
    $response->assertSee('1 × 24 hours');
    $response->assertSee('inno-ieee.sb@unri.ac.id');
    $response->assertSee('@innoelectricaunri');

    // Active methods visible
    $response->assertSee('QRIS Resmi InnoElectrica');
    $response->assertSee('Transfer Bank BNI Khusus');
    $response->assertSee('0987654321');
    $response->assertSee('Copy');

    // Inactive method must NOT be visible
    $response->assertDontSee('Metode Rahasia Nonaktif');
});

test('participant registration saves payment_method_id and converts uploaded receipt to WebP with pending status', function () {
    $competition = Competition::factory()->create([
        'registration_fee' => 50000,
        'registration_type' => 'individual_or_team',
        'registration_open_at' => now()->subDay(),
        'registration_close_at' => now()->addDays(5),
        'status' => 'registration_open',
    ]);

    $method = PaymentMethod::create([
        'name' => 'QRIS Inno',
        'type' => PaymentMethodType::QRIS,
        'is_active' => true,
        'sort_order' => 1,
        'qris_image' => 'payment-methods/dummy.webp',
    ]);

    // Create valid JPG proof image
    $gd = imagecreatetruecolor(300, 200);
    $bg = imagecolorallocate($gd, 40, 80, 120);
    imagefilledrectangle($gd, 0, 0, 300, 200, $bg);
    ob_start();
    imagejpeg($gd, null, 85);
    $jpgBytes = ob_get_clean();
    imagedestroy($gd);

    $receipt = UploadedFile::fake()->createWithContent('transfer_receipt.jpg', $jpgBytes);

    $response = $this->actingAs($this->participant)
        ->post(route('competition.register.store', $competition->slug), [
            'registration_mode' => 'solo',
            'payment_method_id' => $method->id,
            'proof_of_payment' => $receipt,
        ]);

    $response->assertRedirect(route('dashboard'));

    $registration = Registration::where('competition_id', $competition->id)
        ->where('user_id', $this->participant->id)
        ->first();

    expect($registration)->not->toBeNull()
        ->and($registration->status)->toBe('pending')
        ->and($registration->payment_method_id)->toBe($method->id)
        ->and($registration->proof_of_payment)->toEndWith('.webp');

    // File in storage is verified to be genuine WebP
    Storage::disk('public')->assertExists($registration->proof_of_payment);
    $content = Storage::disk('public')->get($registration->proof_of_payment);
    expect(substr($content, 0, 4))->toBe('RIFF');
    expect(substr($content, 8, 4))->toBe('WEBP');
});

test('participant cannot access payment methods management in Filament admin', function () {
    $response = $this->actingAs($this->participant)
        ->get('/admin/payment-methods');

    // Forbidden or redirected
    expect($response->status())->toBeIn([403, 302]);
});
