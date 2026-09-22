<?php

use App\Models\Admin;
use App\Models\Portfolio;
use App\Models\PortfolioPhase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = Admin::factory()->create(['name' => 'Admin Test']);
    $this->token = $this->admin->createToken('test-device')->plainTextToken;
    Storage::fake('public');
});

test('api action creates admin activity', function () {
    $portfolio = Portfolio::factory()->create(['title' => 'Project Alpha']);

    // Test update via API
    $response = $this->putJson("/api/admin/portfolios/{$portfolio->id}", [
        'title' => 'Project Updated',
        'category' => 'rumah',
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertOk();

    $this->assertDatabaseHas('admin_activities', [
        'admin_id' => $this->admin->id,
        'action' => 'updated',
        'subject_type' => 'Portfolio',
        'description' => "Memperbarui Portofolio 'Project Updated'",
    ]);
});

test('api phase update creates descriptive admin activity', function () {
    $portfolio = Portfolio::factory()->create(['title' => 'Project Alpha']);
    PortfolioPhase::ensureForPortfolio($portfolio);
    $phase = $portfolio->phases()->first();

    $response = $this->putJson("/api/admin/portfolios/{$portfolio->id}/phases/{$phase->id}", [
        'title' => 'Phase Updated',
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertOk();

    $this->assertDatabaseHas('admin_activities', [
        'admin_id' => $this->admin->id,
        'action' => 'updated',
        'subject_type' => 'PortfolioPhase',
        'description' => "Memperbarui Tahapan Portofolio 'Phase Updated pada Portofolio 'Project Alpha''",
    ]);
});
