<?php

use App\Models\Admin;
use App\Models\Portfolio;
use App\Models\PortfolioPhase;
use App\Models\PortfolioPhaseImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = Admin::factory()->create();
    $this->token = $this->admin->createToken('test-device')->plainTextToken;
    Storage::fake('public');
});

test('admin can list portfolio phases', function () {
    $portfolio = Portfolio::factory()->create();
    PortfolioPhase::ensureForPortfolio($portfolio);

    $response = $this->getJson("/api/admin/portfolios/{$portfolio->id}/phases", [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertOk()
        ->assertJsonCount(3, 'data'); // 0%, 50%, 100%
});

test('admin can update portfolio phase', function () {
    $portfolio = Portfolio::factory()->create();
    PortfolioPhase::ensureForPortfolio($portfolio);
    $phase = $portfolio->phases()->first();

    $response = $this->putJson("/api/admin/portfolios/{$portfolio->id}/phases/{$phase->id}", [
        'title' => 'Updated Title',
        'description' => 'Updated Description',
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertOk()
        ->assertJsonPath('data.title', 'Updated Title');

    $this->assertDatabaseHas('portfolio_phases', ['id' => $phase->id, 'title' => 'Updated Title']);
});

test('admin can upload phase images', function () {
    $portfolio = Portfolio::factory()->create();
    PortfolioPhase::ensureForPortfolio($portfolio);
    $phase = $portfolio->phases()->first();
    $file = UploadedFile::fake()->create('phase.jpg', 100);

    $response = $this->postJson("/api/admin/portfolios/{$portfolio->id}/phases/{$phase->id}/images", [
        'images' => [$file],
    ], [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('portfolio_phase_images', ['portfolio_phase_id' => $phase->id]);
});

test('admin can delete phase image', function () {
    $portfolio = Portfolio::factory()->create();
    PortfolioPhase::ensureForPortfolio($portfolio);
    $phase = $portfolio->phases()->first();
    $image = PortfolioPhaseImage::create([
        'portfolio_phase_id' => $phase->id,
        'image' => 'phases/test.jpg',
        'sort_order' => 1,
    ]);
    Storage::disk('public')->put('phases/test.jpg', 'content');

    $response = $this->deleteJson("/api/admin/portfolios/{$portfolio->id}/phases/{$phase->id}/images/{$image->id}", [], [
        'Authorization' => 'Bearer '.$this->token,
    ]);

    $response->assertOk();
    $this->assertDatabaseMissing('portfolio_phase_images', ['id' => $image->id]);
    Storage::disk('public')->assertMissing('phases/test.jpg');
});
