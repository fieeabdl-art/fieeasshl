<?php

use App\Http\Controllers\Api\Admin\AdminHeroSlideController;
use App\Http\Controllers\Api\Admin\AdminPortfolioController;
use App\Http\Controllers\Api\Admin\AdminPortfolioPhaseController;
use App\Http\Controllers\Api\Admin\AdminProjectController;
use App\Http\Controllers\Api\Admin\AdminProjectStageController;
use App\Http\Controllers\Api\Admin\AdminServiceController;
use App\Http\Controllers\Api\Admin\AdminSettingController;
use App\Http\Controllers\Api\Admin\AdminTeamProfileController;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\PublicApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('public')->group(function () {
    Route::get('/init', [PublicApiController::class, 'init']);
    Route::get('/portfolios', [PublicApiController::class, 'portfolios']);
    Route::get('/portfolios/{slug}', [PublicApiController::class, 'portfolioDetail']);
    Route::get('/services', [PublicApiController::class, 'services']);
    Route::get('/team', [PublicApiController::class, 'team']);
    Route::get('/faq', [PublicApiController::class, 'faq']);
});

Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [ApiAuthController::class, 'me']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    Route::prefix('admin')->group(function () {
        // Portfolio
        Route::apiResource('portfolios', AdminPortfolioController::class);
        Route::get('portfolios/{portfolio}/phases', [AdminPortfolioPhaseController::class, 'index']);
        Route::put('portfolios/{portfolio}/phases/{phase}', [AdminPortfolioPhaseController::class, 'update']);
        Route::post('portfolios/{portfolio}/phases/{phase}/images', [AdminPortfolioController::class, 'uploadPhaseImages']);
        Route::delete('portfolios/{portfolio}/phases/{phase}/images/{image}', [AdminPortfolioPhaseController::class, 'destroyImage']);

        // Hero Slides
        Route::apiResource('hero-slides', AdminHeroSlideController::class);
        Route::post('hero-slides/reorder', [AdminHeroSlideController::class, 'reorder']);

        // Services
        Route::apiResource('services', AdminServiceController::class);

        // Team Profiles
        Route::apiResource('team-profiles', AdminTeamProfileController::class);

        // Projects
        Route::apiResource('projects', AdminProjectController::class);
        Route::apiResource('projects.stages', AdminProjectStageController::class);

        // Settings
        Route::get('settings', [AdminSettingController::class, 'show']);
        Route::put('settings', [AdminSettingController::class, 'update']);
    });
});
