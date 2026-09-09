<?php

use App\Models\Admin;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('public homepage displays active services ordered by sort_order', function () {
    Setting::query()->create(['site_name' => 'Bumiyuji Test']);

    $service2 = Service::factory()->create([
        'title' => 'Layanan Kedua',
        'status' => true,
        'sort_order' => 2,
    ]);

    $service1 = Service::factory()->create([
        'title' => 'Layanan Pertama',
        'status' => true,
        'sort_order' => 1,
    ]);

    $inactiveService = Service::factory()->create([
        'title' => 'Layanan Nonaktif',
        'status' => false,
        'sort_order' => 0,
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Layanan Pertama');
    $response->assertSee('Layanan Kedua');
    $response->assertDontSee('Layanan Nonaktif');
});

test('guest is redirected when accessing admin services', function () {
    $this->get(route('admin.services.index'))
        ->assertRedirect(route('admin.login'));
});

test('admin can view services list', function () {
    $admin = Admin::query()->create([
        'name' => 'Admin',
        'email' => 'admin@test.com',
        'password' => 'secret123',
    ]);

    $service = Service::factory()->create(['title' => 'Desain Eksterior']);

    $this->actingAs($admin, 'admin')
        ->get(route('admin.services.index'))
        ->assertOk()
        ->assertSee('Desain Eksterior');
});

test('admin can create a service with image upload', function () {
    Storage::fake('public');

    $admin = Admin::query()->create([
        'name' => 'Admin',
        'email' => 'admin@test.com',
        'password' => 'secret123',
    ]);

    $image = UploadedFile::fake()->create('service.jpg', 100, 'image/jpeg');

    $response = $this->actingAs($admin, 'admin')
        ->post(route('admin.services.store'), [
            'title' => 'Desain Kamar Tidur',
            'description' => 'Solusi kamar tidur nyaman dan mewah.',
            'image' => $image,
            'sort_order' => 5,
            'status' => '1',
        ]);

    $response->assertRedirect(route('admin.services.index'));
    $response->assertSessionHas('success');

    $service = Service::query()->where('title', 'Desain Kamar Tidur')->first();
    expect($service)->not->toBeNull();
    expect($service->slug)->toBe('desain-kamar-tidur');
    expect($service->status)->toBeTrue();
    expect($service->sort_order)->toBe(5);
    expect($service->image)->not->toBeNull();

    Storage::disk('public')->assertExists($service->image);
});

test('admin cannot create service without required title and description', function () {
    $admin = Admin::query()->create([
        'name' => 'Admin',
        'email' => 'admin@test.com',
        'password' => 'secret123',
    ]);

    $response = $this->actingAs($admin, 'admin')
        ->post(route('admin.services.store'), [
            'title' => '',
            'description' => '',
        ]);

    $response->assertSessionHasErrors(['title', 'description']);
});

test('admin can update a service and delete old image', function () {
    Storage::fake('public');

    $admin = Admin::query()->create([
        'name' => 'Admin',
        'email' => 'admin@test.com',
        'password' => 'secret123',
    ]);

    $oldImagePath = UploadedFile::fake()->create('old.jpg', 100, 'image/jpeg')->store('services', 'public');

    $service = Service::factory()->create([
        'title' => 'Desain Cafe',
        'image' => $oldImagePath,
        'status' => true,
        'sort_order' => 1,
    ]);

    $newImage = UploadedFile::fake()->create('new.jpg', 100, 'image/jpeg');

    $response = $this->actingAs($admin, 'admin')
        ->put(route('admin.services.update', $service), [
            'title' => 'Desain Cafe & Resto Modern',
            'description' => 'Deskripsi baru cafe.',
            'image' => $newImage,
            'sort_order' => 10,
            'status' => '0',
        ]);

    $response->assertRedirect(route('admin.services.index'));

    $service->refresh();
    expect($service->title)->toBe('Desain Cafe & Resto Modern');
    expect($service->status)->toBeFalse();
    expect($service->sort_order)->toBe(10);
    Storage::disk('public')->assertMissing($oldImagePath);
    Storage::disk('public')->assertExists($service->image);
});

test('admin can delete a service and its image is removed', function () {
    Storage::fake('public');

    $admin = Admin::query()->create([
        'name' => 'Admin',
        'email' => 'admin@test.com',
        'password' => 'secret123',
    ]);

    $imagePath = UploadedFile::fake()->create('service_to_delete.jpg', 100, 'image/jpeg')->store('services', 'public');

    $service = Service::factory()->create([
        'image' => $imagePath,
    ]);

    $response = $this->actingAs($admin, 'admin')
        ->delete(route('admin.services.destroy', $service));

    $response->assertRedirect(route('admin.services.index'));
    expect(Service::query()->find($service->id))->toBeNull();
    Storage::disk('public')->assertMissing($imagePath);
});
