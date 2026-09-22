<?php

use App\Models\AffiliatedDivision;
use App\Models\Faq;
use App\Models\HeroSlide;
use App\Models\Portfolio;
use App\Models\PortfolioPhase;
use App\Models\PortfolioPhaseImage;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('init endpoint returns settings and active hero slides and divisions', function () {
    Setting::current()->update(['site_name' => 'Bumiyuji Test']);
    HeroSlide::factory()->create(['is_active' => true]);
    AffiliatedDivision::factory()->create(['is_published' => true]);

    $response = $this->getJson('/api/public/init');

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.settings.site_name', 'Bumiyuji Test')
        ->assertJsonCount(1, 'data.hero_slides');

    $this->assertGreaterThanOrEqual(1, count($response->json('data.affiliated_divisions')));
});

test('portfolios endpoint returns paginated published portfolios', function () {
    Portfolio::factory()->count(15)->create(['is_published' => true]);
    Portfolio::factory()->create(['is_published' => false]);

    $response = $this->getJson('/api/public/portfolios?per_page=10');

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonCount(10, 'data.data')
        ->assertJsonPath('data.meta.total', 15);
});

test('portfolios can be filtered by category', function () {
    Portfolio::factory()->create(['category' => 'rumah', 'is_published' => true]);
    Portfolio::factory()->create(['category' => 'kantor', 'is_published' => true]);

    $response = $this->getJson('/api/public/portfolios?category=rumah');

    $response->assertOk()
        ->assertJsonCount(1, 'data.data')
        ->assertJsonPath('data.data.0.category', 'rumah');
});

test('portfolio detail returns full data with phases and images', function () {
    $portfolio = Portfolio::factory()->create(['slug' => 'test-portfolio', 'is_published' => true]);
    $phase = PortfolioPhase::factory()->create(['portfolio_id' => $portfolio->id]);
    PortfolioPhaseImage::factory()->count(3)->create(['portfolio_phase_id' => $phase->id]);

    $response = $this->getJson('/api/public/portfolios/test-portfolio');

    $response->assertOk()
        ->assertJsonPath('success', true)
        ->assertJsonPath('data.slug', 'test-portfolio')
        ->assertJsonCount(1, 'data.phases')
        ->assertJsonCount(3, 'data.phases.0.images');
});

test('portfolio detail returns 404 for non-existent slug', function () {
    $response = $this->getJson('/api/public/portfolios/non-existent');

    $response->assertStatus(404)
        ->assertJsonPath('success', false);
});

test('portfolio detail works for portfolio without phases', function () {
    Portfolio::factory()->create(['slug' => 'no-phases', 'is_published' => true]);

    $response = $this->getJson('/api/public/portfolios/no-phases');

    $response->assertOk()
        ->assertJsonCount(0, 'data.phases');
});

test('services endpoint returns active services', function () {
    Service::factory()->create(['status' => true]);
    Service::factory()->create(['status' => false]);

    $response = $this->getJson('/api/public/services');

    $response->assertOk()
        ->assertJsonCount(1, 'data');
});

test('team endpoint returns published team profiles', function () {
    TeamProfile::factory()->create(['is_published' => true]);
    TeamProfile::factory()->create(['is_published' => false]);

    $response = $this->getJson('/api/public/team');

    $response->assertOk()
        ->assertJsonCount(1, 'data');
});

test('faq endpoint returns published faqs', function () {
    Faq::factory()->create(['is_published' => true]);
    Faq::factory()->create(['is_published' => false]);

    $response = $this->getJson('/api/public/faq');

    $response->assertOk()
        ->assertJsonCount(1, 'data');
});

test('public endpoints do not require authentication', function () {
    // This is implicitly tested by the above tests not using tokens,
    // but we can explicitly check if a random public route works.
    $this->getJson('/api/public/init')->assertOk();
});
