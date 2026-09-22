<?php

use App\Models\Admin;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\TeamProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = Admin::factory()->create();
    $this->token = $this->admin->createToken('test-device')->plainTextToken;
    Storage::fake('public');
});

test('unauthenticated user cannot access admin cms', function () {
    $this->getJson('/api/admin/portfolios')->assertStatus(401);
});

test('admin can list portfolios', function () {
    Portfolio::factory()->count(5)->create();

    $response = $this->getJson('/api/admin/portfolios', [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertOk()
        ->assertJsonCount(5, 'data.data');
});

test('admin can create portfolio with image', function () {
    $file = UploadedFile::fake()->create('portfolio.jpg', 100);

    $response = $this->postJson('/api/admin/portfolios', [
        'title' => 'New Project',
        'category' => 'rumah',
        'description' => 'Cool house',
        'image' => $file,
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertStatus(201);
    $this->assertDatabaseHas('portfolios', ['title' => 'New Project']);
    Storage::disk('public')->assertExists(Str::after($response->json('data.image_url'), '/storage/'));
});

test('admin can update portfolio', function () {
    $portfolio = Portfolio::factory()->create(['title' => 'Old Title']);

    $response = $this->putJson('/api/admin/portfolios/'.$portfolio->id, [
        'title' => 'Updated Title',
        'category' => 'kantor',
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('portfolios', ['id' => $portfolio->id, 'title' => 'Updated Title']);
});

test('admin can delete portfolio', function () {
    $portfolio = Portfolio::factory()->create();

    $this->deleteJson('/api/admin/portfolios/'.$portfolio->id, [], [
        'Authorization' => 'Bearer '.$this->token,
    ])->assertOk();

    $this->assertDatabaseMissing('portfolios', ['id' => $portfolio->id]);
});

test('admin can upload hero slides', function () {
    $files = [
        UploadedFile::fake()->create('hero1.jpg', 100),
        UploadedFile::fake()->create('hero2.jpg', 100),
    ];

    $response = $this->postJson('/api/admin/hero-slides', [
        'images' => $files,
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertStatus(201);
    $this->assertDatabaseCount('hero_slides', 2);
});

test('admin can list and update settings', function () {
    $response = $this->getJson('/api/admin/settings', [
        'Authorization' => 'Bearer '.$this->token,
    ]);
    $response->assertOk();

    $response = $this->putJson('/api/admin/settings', [
        'site_name' => 'Updated CMS Name',
        'hero_title' => 'New Welcome',
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('settings', ['site_name' => 'Updated CMS Name']);
});

test('admin can manage services', function () {
    $service = Service::factory()->create(['description' => 'Old description']);

    $this->getJson('/api/admin/services', [
        'Authorization' => 'Bearer '.$this->token,
    ])->assertOk();

    $this->putJson('/api/admin/services/'.$service->id, [
        'title' => 'Updated Service',
        'description' => 'Updated description',
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ])->assertOk();

    $this->assertDatabaseHas('services', ['title' => 'Updated Service']);
});

test('admin can manage team profiles', function () {
    $team = TeamProfile::factory()->create();

    $this->getJson('/api/admin/team-profiles', [
        'Authorization' => 'Bearer '.$this->token,
    ])->assertOk();

    $this->putJson('/api/admin/team-profiles/'.$team->id, [
        'name' => 'Updated Name',
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ])->assertOk();

    $this->assertDatabaseHas('team_profiles', ['name' => 'Updated Name']);
});
