<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Create or update admin user
        $user = User::firstOrCreate(
            ['email' => 'test@mailinator.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );
        
        // Assign administrator role (will not duplicate if already assigned)
        $user->assignRole('Administrator');
        
        // Reset cached roles and permissions after assignment
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Log info
        $this->command->info('Admin user created/updated successfully and assigned Administrator role.');
    }
}
