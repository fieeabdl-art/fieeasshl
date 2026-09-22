<?php

use App\Models\Admin;
use App\Models\Project;
use App\Models\ProjectStage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = Admin::factory()->create();
    $this->token = $this->admin->createToken('test-device')->plainTextToken;
    Storage::fake('public');
});

test('unauthenticated user cannot access admin projects', function () {
    $this->getJson('/api/admin/projects')->assertStatus(401);
});

test('admin can create project', function () {
    $file = UploadedFile::fake()->create('project.jpg', 100);

    $response = $this->postJson('/api/admin/projects', [
        'name' => 'Modern Minimalist',
        'client' => 'PT Contoh Client',
        'location' => 'Jakarta',
        'category' => 'Interior',
        'start_date' => '2026-09-01',
        'deadline' => '2026-10-30',
        'status' => 'berjalan',
        'progress' => 75,
        'description' => 'High-end interior project',
        'cover_image' => $file,
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertStatus(201)
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.name', 'Modern Minimalist');

    $this->assertDatabaseHas('projects', ['name' => 'Modern Minimalist']);
    $this->assertNotNull(Project::first()->cover_image);
    Storage::disk('public')->assertExists(Project::first()->cover_image);
});

test('admin can list projects', function () {
    Project::factory()->count(3)->create();

    $response = $this->getJson('/api/admin/projects', [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertOk()
        ->assertJsonCount(3, 'data.data');
});

test('admin can get project detail', function () {
    $project = Project::factory()->create();
    ProjectStage::factory()->count(2)->create(['project_id' => $project->id]);

    $response = $this->getJson('/api/admin/projects/'.$project->id, [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertOk()
        ->assertJsonPath('data.id', $project->id)
        ->assertJsonCount(2, 'data.stages');
});

test('admin can update project', function () {
    $project = Project::factory()->create(['name' => 'Old Name', 'progress' => 10]);

    $response = $this->putJson('/api/admin/projects/'.$project->id, [
        'name' => 'New Name',
        'progress' => 50,
        'status' => 'selesai',
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('projects', ['id' => $project->id, 'name' => 'New Name', 'progress' => 50]);
});

test('admin can delete project and its image', function () {
    $project = Project::factory()->create([
        'cover_image' => 'projects/test.jpg',
    ]);
    Storage::disk('public')->put('projects/test.jpg', 'content');

    $this->deleteJson('/api/admin/projects/'.$project->id, [], [
        'Authorization' => 'Bearer '.$this->token,
    ])->assertOk();

    $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    Storage::disk('public')->assertMissing('projects/test.jpg');
});

test('admin can manage project stages', function () {
    $project = Project::factory()->create();

    // Create stage
    $response = $this->postJson("/api/admin/projects/{$project->id}/stages", [
        'name' => 'Survey',
        'status' => 'selesai',
        'sort_order' => 1,
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertStatus(201);
    $stageId = $response->json('data.id');
    $this->assertDatabaseHas('project_stages', ['project_id' => $project->id, 'name' => 'Survey']);

    // List stages
    $this->getJson("/api/admin/projects/{$project->id}/stages", [
        'Authorization' => 'Bearer '.$this->token,
    ])->assertOk()->assertJsonCount(1, 'data');

    // Update stage
    $this->putJson("/api/admin/projects/{$project->id}/stages/{$stageId}", [
        'name' => 'Updated Survey',
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ])->assertOk();
    $this->assertDatabaseHas('project_stages', ['id' => $stageId, 'name' => 'Updated Survey']);

    // Delete stage
    $this->deleteJson("/api/admin/projects/{$project->id}/stages/{$stageId}", [], [
        'Authorization' => 'Bearer '.$this->token,
    ])->assertOk();
    $this->assertDatabaseMissing('project_stages', ['id' => $stageId]);
});

test('project delete cascades to stages', function () {
    $project = Project::factory()->create();
    $stage = ProjectStage::factory()->create(['project_id' => $project->id]);

    $project->delete();

    $this->assertDatabaseMissing('project_stages', ['id' => $stage->id]);
});

test('progress validation', function () {
    $project = Project::factory()->create();

    $this->putJson('/api/admin/projects/'.$project->id, [
        'progress' => 101,
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ])->assertStatus(422);

    $this->putJson('/api/admin/projects/'.$project->id, [
        'progress' => -1,
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ])->assertStatus(422);
});

test('invalid status validation', function () {
    $this->postJson('/api/admin/projects', [
        'name' => 'Test',
        'client' => 'Client',
        'status' => 'invalid-status',
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ])->assertStatus(422);
});
