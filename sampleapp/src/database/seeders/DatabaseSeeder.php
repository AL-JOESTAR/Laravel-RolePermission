<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $readOnlyRole = Role::firstOrCreate(['name' => 'read_only']);


        // Ambil ulang semua permissions setelah digenerate
        $allPermissions = Permission::all();

        // Super admin dapat semua permission
        $superAdminRole->syncPermissions($allPermissions);

        // Ambil hanya yang mengandung view dan viewAny
        $readOnlyPermissions = $allPermissions->filter(function ($perm) {
            return str_contains($perm->name, 'view') || str_contains($perm->name, 'viewAny')  || str_contains($perm->name, 'create_test');
        });

        // Read-only hanya dapat view
        $readOnlyRole->syncPermissions($readOnlyPermissions);

        // Buat user super admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );
        $admin->assignRole($superAdminRole);

        // Buat user read only
        $readonly = User::firstOrCreate(
            ['email' => 'readonly@site.com'],
            ['name' => 'Read Only User', 'password' => bcrypt('password')]
        );
        $readonly->assignRole($readOnlyRole);

        $this->call(TestSeeder::class);
    }
   
}
