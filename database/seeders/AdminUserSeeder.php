<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'test@mailinator.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);
        
        // Assign administrator role
        $user->assignRole('Administrator');
        
        // Log info
        $this->command->info('Admin user created successfully.');
    }
}
