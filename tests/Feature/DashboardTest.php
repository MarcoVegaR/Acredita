<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('authenticated users without Administrator role cannot access dashboard', function () {
    $this->actingAs($user = User::factory()->create());
    
    $this->get('/dashboard')->assertForbidden();
});

test('users with Administrator role can visit the dashboard', function () {
    // Crear rol Administrator si no existe
    if (!Role::where('name', 'Administrator')->exists()) {
        Role::create(['name' => 'Administrator']);
    }
    
    $user = User::factory()->create();
    $user->assignRole('Administrator');
    $this->actingAs($user);

    $this->get('/dashboard')->assertOk();
});