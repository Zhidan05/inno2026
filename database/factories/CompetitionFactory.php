<?php

namespace Database\Factories;

use App\Models\Competition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Competition>
 */
class CompetitionFactory extends Factory
{
    protected $model = Competition::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true).' Competition';

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numerify('####'),
            'description' => fake()->paragraph(),
            'registration_type' => 'individual_or_team',
            'max_team_members' => 3,
            'registration_fee' => 50000,
            'registration_open_at' => now()->subDays(2),
            'registration_close_at' => now()->addDays(10),
            'competition_start_at' => now()->addDays(15),
            'competition_end_at' => now()->addDays(20),
            'location' => 'Main Auditorium',
            'status' => 'registration_open',
            'submission_type' => 'file',
        ];
    }
}
