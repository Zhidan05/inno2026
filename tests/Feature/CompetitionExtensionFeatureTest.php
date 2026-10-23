<?php

use App\Models\Competition;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    Role::firstOrCreate(['name' => 'participant']);
});

test('extended competition displays extended badge and enabled register button on homepage', function () {
    $competition = Competition::create([
        'name' => 'Solar Boat Challenge',
        'slug' => 'solar-boat-challenge',
        'description' => 'Autonomous solar-powered boat race.',
        'registration_type' => 'team',
        'max_team_members' => 4,
        'registration_fee' => 50000,
        'registration_open_at' => Carbon::now()->subDays(10),
        'registration_close_at' => Carbon::now()->subDay(),
        'extended_registration_close_at' => Carbon::now()->addDays(5)->setTime(23, 59, 0),
        'competition_start_at' => Carbon::now()->addDays(7),
        'competition_end_at' => Carbon::now()->addDays(10),
        'status' => 'registration_closed',
        'submission_type' => 'none',
    ]);

    expect($competition->isExtended())->toBeTrue();
    expect($competition->isRegistrationOpen())->toBeTrue();

    $response = $this->get('/');
    $response->assertOk();
    $response->assertSee('Registration Extended');
    $response->assertSee('Extended to '.$competition->extended_registration_close_at->translatedFormat('l, d F Y'));
    $response->assertSee(route('competition.register', $competition->slug));
});

test('authenticated participant can access registration form when competition is extended', function () {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);
    $user->assignRole('participant');

    $competition = Competition::create([
        'name' => 'Drone Racing Expo',
        'slug' => 'drone-racing-expo',
        'description' => 'Indoor drone fpv racing.',
        'registration_type' => 'individual',
        'max_team_members' => 1,
        'registration_fee' => 0,
        'registration_open_at' => Carbon::now()->subDays(10),
        'registration_close_at' => Carbon::now()->subDays(2),
        'extended_registration_close_at' => Carbon::now()->addDays(3),
        'competition_start_at' => Carbon::now()->addDays(5),
        'competition_end_at' => Carbon::now()->addDays(7),
        'status' => 'registration_closed',
        'submission_type' => 'none',
    ]);

    $response = $this->actingAs($user)->get(route('competition.register', $competition->slug));
    $response->assertOk();
    $response->assertSee($competition->name);

    // Now simulate extension expiration
    $competition->update([
        'extended_registration_close_at' => Carbon::now()->subMinute(),
    ]);
    $competition->refresh();

    expect($competition->isRegistrationOpen())->toBeFalse();

    $expiredResponse = $this->actingAs($user)->get(route('competition.register', $competition->slug));
    $expiredResponse->assertRedirect(route('dashboard'));
    $expiredResponse->assertSessionHas('error', 'Registration for this competition is currently closed.');
});
