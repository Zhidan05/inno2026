<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['super_admin', 'moderator', 'judge', 'participant'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@innoelectrica.com'],
            [
                'name' => 'Super Admin',
                'phone' => '0000000000',
                'institution' => 'System',
                'password' => Hash::make('password'),
            ]
        );

        if (!$superAdmin->hasRole('super_admin')) {
            $superAdmin->assignRole('super_admin');
        }
    }
}
