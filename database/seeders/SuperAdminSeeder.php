<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserRole;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            UserRole::ADMIN->value,
            UserRole::MODERATOR->value,
            UserRole::JUDGE->value,
            UserRole::PARTICIPANT->value,
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Sync all non-role permissions to the admin role
        $adminRole = Role::findByName(UserRole::ADMIN->value, 'web');
        $permissions = \Spatie\Permission\Models\Permission::all()->reject(function ($permission) {
            return str_ends_with($permission->name, '_role');
        });
        $adminRole->syncPermissions($permissions);

        // Sync judge permissions
        $judgeRole = Role::findByName(UserRole::JUDGE->value, 'web');
        $judgeRole->syncPermissions([
            'view_any_competition',
            'view_competition',
            'view_any_registration',
            'view_registration',
            'update_registration',
        ]);

        // Ensure default admin user exists
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@innoelectrica.com'],
            [
                'name' => 'Admin',
                'phone' => '0000000000',
                'institution' => 'System',
                'password' => Hash::make('password'),
            ]
        );

        if (!$adminUser->hasRole(UserRole::ADMIN->value)) {
            $adminUser->assignRole(UserRole::ADMIN->value);
        }
    }
}
