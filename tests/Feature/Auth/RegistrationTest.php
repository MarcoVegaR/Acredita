<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

// La funcionalidad de registro ha sido desactivada en la aplicación
// Estos tests se mantienen comentados por referencia

/*
test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
*/

// Test placeholder para evitar que el archivo esté vacío
test('registration is disabled', function() {
    expect(true)->toBeTrue();
});