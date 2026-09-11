<?php

use App\Http\Controllers\Admin\ClientPartnerController;
use App\Http\Controllers\Admin\AffiliatedDivisionController;
use App\Http\Controllers\Admin\WorkflowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Teams\TeamInvitationController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureTeamMembership;
use App\Models\ClientPartner;
use App\Models\AffiliatedDivision;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamProfile;
use App\Models\Testimonial;
use App\Models\Workflow;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Dashboard / Team
|--------------------------------------------------------------------------
*/

Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::get('index', DashboardController::class)
            ->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Team Invitations
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::post(
        'invitations/{invitation}/accept',
        [TeamInvitationController::class, 'accept']
    )->name('invitations.accept');

    Route::delete(
        'invitations/{invitation}',
        [TeamInvitationController::class, 'decline']
    )->name('invitations.decline');
});

/*
|--------------------------------------------------------------------------
| Public Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $setting = Setting::current();

    $social = $setting->social_links ?? [];

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */

    $settings = [
        'site_title' => $setting->site_name ?: 'Bumiyuji Living',

        'logo_url' => $setting->logo ? Storage::url($setting->logo) : null,

        'address' => $setting->contact_address,

        'address_note' => $setting->contact_address_note,

        'secondary_address' => $setting->secondary_address,

        'secondary_address_note' => $setting->secondary_address_note,

        'office_hours' => $setting->office_hours ?: 'Senin - Sabtu: 08:00 - 17:00',

        'maps_url' => $setting->contact_maps_url,

        'wa_number' => $setting->appointment_whatsapp_number
                            ?: $setting->contact_whatsapp
                            ?: '6281311114523',

        'email' => $setting->contact_email,

        'instagram' => $social['instagram'] ?? '',

        'facebook' => $social['facebook'] ?? '',

        'tiktok' => $social['tiktok'] ?? '',

        'youtube' => $social['youtube'] ?? '',

        'hero_title' => $setting->hero_title,

        'hero_subtitle' => $setting->hero_subtitle,

        'about_title' => $setting->about_title,

        'about_text' => $setting->about_description,

        'about_subtext' => '',

        'visi' => $setting->about_vision,

        'misi' => $setting->about_mission,
    ];

    /*
    |--------------------------------------------------------------------------
    | Misi
    |--------------------------------------------------------------------------
    */

    $misiList = array_filter(
        array_map(
            'trim',
            preg_split(
                "/\r\n|\n|\r/",
                (string) $setting->about_mission
            )
        )
    );

    /*
    |--------------------------------------------------------------------------
    | Portfolio
    |--------------------------------------------------------------------------
    */

    $portfolios = Portfolio::query()
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderByDesc('created_at')
        ->with(['phases' => function ($q) {
            $q->orderBy('percentage');
        }, 'phases.images' => function ($q) {
            $q->orderBy('sort_order');
        }])
        ->get()
        ->map(function ($p) {
            return [
                'id' => $p->id,

                'title' => $p->title,

                'category' => $p->category->label(),

                'description' => $p->description,

                'image_url' => $p->image
                    ? Storage::url($p->image)
                    : 'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=600&q=80',

                'phases' => $p->phases->map(function ($phase) {
                    return [
                        'title' => $phase->title,
                        'description' => $phase->description,
                        'percentage' => $phase->percentage,
                        'images' => $phase->images->map(fn ($img) => Storage::url($img->image))->values(),
                    ];
                })->values(),
            ];
        })
        ->all();

    /*
    |--------------------------------------------------------------------------
    | Testimonials
    |--------------------------------------------------------------------------
    */

    $testimonials = Testimonial::query()
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderByDesc('created_at')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Landing Page
    |--------------------------------------------------------------------------
    */

    // team profile
    $team = TeamProfile::query()
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderByDesc('created_at')
        ->get();
    $workflows = Workflow::query()
        ->where('is_published', true)
        ->orderBy('step')
        ->get();

    // client & partner
    $clientPartners = ClientPartner::query()
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderByDesc('created_at')
        ->get();

    // services
    $services = Service::query()
        ->where('status', 1)
        ->orderBy('sort_order')
        ->orderByDesc('created_at')
        ->get();

    // divisi terafiliasi
    $affiliatedDivisions = AffiliatedDivision::query()
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderByDesc('created_at')
        ->get()
        ->map(fn ($d) => [
            'letter' => $d->initial,
            'color' => $d->color,
            'logo' => $d->logo,
            'name' => $d->name,
            'desc' => $d->description,
        ]);

    return view('index', compact(
        'settings',
        'misiList',
        'portfolios',
        'testimonials',
        'setting',
        'team',
        'workflows',
        'clientPartners',
        'services',
        'affiliatedDivisions'
    ));
})->name('home');

/*
|--------------------------------------------------------------------------
| Admin - Workflow
|--------------------------------------------------------------------------
*/

Route::middleware([EnsureAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('workflows', WorkflowController::class)
            ->except(['show']);

        Route::resource('client-partners', ClientPartnerController::class)
            ->except(['show']);

        Route::resource('affiliated-divisions', AffiliatedDivisionController::class)
            ->except(['show']);
    });
/*
|--------------------------------------------------------------------------
| Settings Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/settings.php';