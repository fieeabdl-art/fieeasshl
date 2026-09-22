<?php

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('admin can login via api', function () {
    $admin = Admin::factory()->create([
        'email' => 'admin@example.com',
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'admin@example.com',
        'password' => 'password123',
        'device_name' => 'test-device',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'token',
            'admin' => ['id', 'name', 'email', 'role'],
        ]);
});

test('admin login fails with wrong password', function () {
    Admin::factory()->create([
        'email' => 'admin@example.com',
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'admin@example.com',
        'password' => 'wrong-password',
        'device_name' => 'test-device',
    ]);

    $response->assertStatus(401)
        ->assertJsonPath('message', 'Email atau password tidak sesuai. Sisa 4x percobaan sebelum akun dikunci sementara.');
});

test('admin login throttles after multiple failures', function () {
    Admin::factory()->create([
        'email' => 'admin@example.com',
        'password' => Hash::make('password123'),
    ]);

    for ($i = 0; $i < 5; $i++) {
        $this->postJson('/api/login', [
            'email' => 'admin@example.com',
            'password' => 'wrong-password',
            'device_name' => 'test-device',
        ]);
    }

    $response = $this->postJson('/api/login', [
        'email' => 'admin@example.com',
        'password' => 'wrong-password',
        'device_name' => 'test-device',
    ]);

    $response->assertStatus(429);
});

test('admin can get current user info', function () {
    $admin = Admin::factory()->create();
    $token = $admin->createToken('test-device')->plainTextToken;

    $response = $this->getJson('/api/me', [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertOk()
        ->assertJsonPath('email', $admin->email);
});

test('admin can logout', function () {
    $admin = Admin::factory()->create();
    $token = $admin->createToken('test-device')->plainTextToken;

    $response = $this->postJson('/api/logout', [], [
        'Authorization' => 'Bearer '.$token,
    ]);

    $response->assertOk()
        ->assertJsonPath('message', 'Logged out successfully');

    $this->assertCount(0, $admin->tokens);
});
