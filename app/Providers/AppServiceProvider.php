<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\AffiliatedDivision;
use App\Models\ClientPartner;
use App\Models\Faq;
use App\Models\HeroSlide;
use App\Models\Portfolio;
use App\Models\PortfolioPhase;
use App\Models\Project;
use App\Models\ProjectStage;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamProfile;
use App\Models\Testimonial;
use App\Models\Workflow;
use App\Observers\AdminActivityObserver;
use App\Services\AdminActivityLogger;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Model-model yang perubahannya (create/update/delete) otomatis
     * dicatat sebagai aktivitas admin untuk fitur notifikasi & riwayat
     * perubahan.
     */
    protected array $observedModels = [
        Service::class,
        Portfolio::class,
        Testimonial::class,
        Faq::class,
        Workflow::class,
        TeamProfile::class,
        ClientPartner::class,
        AffiliatedDivision::class,
        HeroSlide::class,
        Setting::class,
        Admin::class,
        PortfolioPhase::class,
        Project::class,
        ProjectStage::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->registerActivityObservers();
        $this->shareAdminNotifications();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    protected function registerActivityObservers(): void
    {
        foreach ($this->observedModels as $model) {
            $model::observe(AdminActivityObserver::class);
        }
    }

    /**
     * Supaya badge notifikasi & dropdown di admin.layout bisa dipakai
     * dari view manapun tanpa perlu tiap controller mengirim variabel
     * ini secara manual.
     */
    protected function shareAdminNotifications(): void
    {
        View::composer('admin.layout', function ($view) {
            $admin = Auth::guard('admin')->user();

            $view->with('adminUnreadActivityCount', $admin ? AdminActivityLogger::unreadCountFor($admin) : 0);
        });
    }
}
