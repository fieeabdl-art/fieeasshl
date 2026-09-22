<?php

use App\Http\Controllers\Admin\AdminActivityController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\PortfolioPhaseController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TeamProfileController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureSuperAdmin;
use App\Http\Middleware\PreventBackHistoryCache;
use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::middleware('guest:admin')->group(function () {
            Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
            Route::post('login', [AuthController::class, 'login'])->name('login.submit');
        });

        Route::middleware([EnsureAdmin::class, PreventBackHistoryCache::class])->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');

            Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
            Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

            // Hero slides (dikelola lewat modal "Atur Gambar" di halaman
            // Settings — tidak ada halaman/redirect terpisah).
            Route::prefix('settings/hero-slides')
                ->name('settings.hero-slides.')
                ->group(function () {
                    Route::post('/', [HeroSlideController::class, 'store'])->name('store');
                    Route::post('reorder', [HeroSlideController::class, 'reorder'])->name('reorder');
                    Route::post('{heroSlide}', [HeroSlideController::class, 'update'])->name('update');
                    Route::delete('{heroSlide}', [HeroSlideController::class, 'destroy'])->name('destroy');
                });

            // Kelola akun admin & penentuan Super Admin — khusus Super Admin.
            Route::middleware(EnsureSuperAdmin::class)->group(function () {
                Route::resource('admins', AdminUserController::class)
                    ->parameters(['admins' => 'adminUser'])
                    ->except(['show']);
            });

            // Notifikasi & riwayat perubahan — bisa dilihat semua admin.
            Route::prefix('activities')
                ->name('activities.')
                ->group(function () {
                    Route::get('/', [AdminActivityController::class, 'index'])->name('index');
                    Route::get('latest', [AdminActivityController::class, 'latest'])->name('latest');
                    Route::post('mark-read', [AdminActivityController::class, 'markRead'])->name('mark-read');
                });

            Route::resource('services', ServiceController::class)->except(['show']);
            Route::resource('portfolios', PortfolioController::class)->except(['show']);
            Route::resource('testimonials', TestimonialController::class)->except(['show']);
            Route::resource('faqs', FaqController::class)->except(['show']);

            Route::prefix('portfolios/{portfolio}/phases')
                ->name('portfolios.phases.')
                ->group(function () {
                    Route::get('/', [PortfolioPhaseController::class, 'index'])->name('index');
                    Route::post('/', [PortfolioPhaseController::class, 'store'])->name('store');
                    Route::get('{phase}/edit', [PortfolioPhaseController::class, 'edit'])->name('edit');
                    Route::put('{phase}', [PortfolioPhaseController::class, 'update'])->name('update');
                    Route::delete('{phase}', [PortfolioPhaseController::class, 'destroy'])->name('destroy');
                    Route::delete('{phase}/images/{image}', [PortfolioPhaseController::class, 'destroyImage'])->name('images.destroy');
                });
            Route::resource('team-profiles', TeamProfileController::class)
                ->names('team-profiles');
        });
    });
