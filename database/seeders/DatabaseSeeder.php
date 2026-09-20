<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserRole;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Prevent filament-shield from recreating the super_admin role during generation
        config(['filament-shield.super_admin.enabled' => false]);

        // Generate all required Shield permissions (permissions only, non-interactive)
        $exitCode = Artisan::call('shield:generate', [
            '--all' => true,
            '--panel' => 'admin',
            '--option' => 'permissions',
        ]);

        if ($exitCode !== 0) {
            throw new \Exception('Shield generation failed: ' . Artisan::output());
        }

        // Clear permission cache
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // Verify required permissions actually exist before syncing
        $requiredPermissions = [
            'view_any_competition',
            'view_competition',
            'create_competition',
            'update_competition',
        ];

        foreach ($requiredPermissions as $perm) {
            if (!Permission::where('name', $perm)->where('guard_name', 'web')->exists()) {
                throw new \Exception("Required permission missing: {$perm} for guard web.");
            }
        }

        // Create required roles
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
        $permissions = Permission::all()->reject(function ($permission) {
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
