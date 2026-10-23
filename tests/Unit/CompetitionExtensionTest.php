<?php

use App\Models\Competition;
use Carbon\Carbon;
use Tests\TestCase;

uses(TestCase::class);

test('effective registration close at uses extended date when greater than original close date', function () {
    $originalClose = Carbon::now()->addDays(2);
    $extendedClose = Carbon::now()->addDays(5);

    $competition = new Competition([
        'registration_close_at' => $originalClose,
        'extended_registration_close_at' => $extendedClose,
    ]);

    expect($competition->effective_registration_close_at->toDateTimeString())
        ->toBe($extendedClose->toDateTimeString());
});

test('effective registration close at falls back to original close date if extension is older or null', function () {
    $originalClose = Carbon::now()->addDays(5);
    $olderExtension = Carbon::now()->addDays(2);

    $competitionWithNull = new Competition([
        'registration_close_at' => $originalClose,
        'extended_registration_close_at' => null,
    ]);

    $competitionWithOlder = new Competition([
        'registration_close_at' => $originalClose,
        'extended_registration_close_at' => $olderExtension,
    ]);

    expect($competitionWithNull->effective_registration_close_at->toDateTimeString())
        ->toBe($originalClose->toDateTimeString());

    expect($competitionWithOlder->effective_registration_close_at->toDateTimeString())
        ->toBe($originalClose->toDateTimeString());
});

test('isExtended returns true only when extension is active and competition has not ended', function () {
    $activeComp = new Competition([
        'extended_registration_close_at' => Carbon::now()->addDays(3),
        'competition_end_at' => Carbon::now()->addDays(7),
    ]);
    expect($activeComp->isExtended())->toBeTrue();

    $expiredExtensionComp = new Competition([
        'extended_registration_close_at' => Carbon::now()->subHour(),
        'competition_end_at' => Carbon::now()->addDays(7),
    ]);
    expect($expiredExtensionComp->isExtended())->toBeFalse();

    $endedComp = new Competition([
        'extended_registration_close_at' => Carbon::now()->addDays(3),
        'competition_end_at' => Carbon::now()->subDay(),
    ]);
    expect($endedComp->isExtended())->toBeFalse();

    $noExtensionComp = new Competition([
        'extended_registration_close_at' => null,
    ]);
    expect($noExtensionComp->isExtended())->toBeFalse();
});

test('extended status label formats correctly in English', function () {
    $targetDate = Carbon::parse('2026-10-25 23:59:00');

    $competition = new Competition([
        'extended_registration_close_at' => $targetDate,
    ]);

    expect($competition->extended_status_label)->toBe('Extended to Sunday, 25 October 2026');
});

test('automatic status transitions prioritize ended, then extended, then closed', function () {
    // 1. Ended takes top priority
    $ended = new Competition([
        'registration_open_at' => Carbon::now()->subDays(10),
        'registration_close_at' => Carbon::now()->subDays(5),
        'extended_registration_close_at' => Carbon::now()->addDays(2),
        'competition_end_at' => Carbon::now()->subHour(),
        'status' => 'extended',
    ]);
    expect($ended->status)->toBe('completed');
    expect($ended->isRegistrationOpen())->toBeFalse();

    // 2. Active extension returns 'extended' and registration is open
    $extended = new Competition([
        'registration_open_at' => Carbon::now()->subDays(10),
        'registration_close_at' => Carbon::now()->subDays(2),
        'extended_registration_close_at' => Carbon::now()->addDays(3),
        'competition_start_at' => Carbon::now()->addDays(5),
        'competition_end_at' => Carbon::now()->addDays(7),
        'status' => 'registration_closed',
    ]);
    expect($extended->status)->toBe('extended');
    expect($extended->isRegistrationOpen())->toBeTrue();

    // 3. Expired extension automatically closes registration
    $expired = new Competition([
        'registration_open_at' => Carbon::now()->subDays(10),
        'registration_close_at' => Carbon::now()->subDays(5),
        'extended_registration_close_at' => Carbon::now()->subHour(),
        'competition_start_at' => Carbon::now()->addDays(2),
        'competition_end_at' => Carbon::now()->addDays(4),
        'status' => 'extended',
    ]);
    expect($expired->status)->toBe('registration_closed');
    expect($expired->isRegistrationOpen())->toBeFalse();

    // 4. Expired extension with competition already ongoing
    $ongoing = new Competition([
        'registration_open_at' => Carbon::now()->subDays(10),
        'registration_close_at' => Carbon::now()->subDays(5),
        'extended_registration_close_at' => Carbon::now()->subHour(),
        'competition_start_at' => Carbon::now()->subMinute(),
        'competition_end_at' => Carbon::now()->addDays(2),
        'status' => 'extended',
    ]);
    expect($ongoing->status)->toBe('ongoing');
    expect($ongoing->isRegistrationOpen())->toBeFalse();
});
