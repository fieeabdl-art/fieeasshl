<?php

use App\Http\Controllers\Admin\AffiliatedDivisionController;
use App\Http\Controllers\Admin\ClientPartnerController;
use App\Http\Controllers\Admin\WorkflowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Teams\TeamInvitationController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureTeamMembership;
use App\Models\AffiliatedDivision;
use App\Models\ClientPartner;
use App\Models\Faq;
use App\Models\HeroSlide;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamProfile;
use App\Models\Testimonial;
use App\Models\Workflow;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

$landingPage = function () {
    $setting = Setting::current();

    $heroSlides = HeroSlide::query()
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();

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

        'parent_company_name' => $setting->parent_company_name ?: 'PT Arada Integra Indonesia',

        'parent_company_brand' => $setting->parent_company_brand ?: 'Artersia',

        'ecosystem_intro' => $setting->ecosystem_intro
            ?: 'Satu ekosistem, beragam keahlian, terhubung dalam sinergi yang berkelanjutan.',

        'parent_company_logo_url' => $setting->parent_company_logo
            ? Storage::url($setting->parent_company_logo)
            : null,
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
    | FAQ
    |--------------------------------------------------------------------------
    */

    $faqs = Faq::query()
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

    /*
    |--------------------------------------------------------------------------
    | SEO — meta per section
    |--------------------------------------------------------------------------
    | Semua route section (lihat bawah) render view yang SAMA PERSIS, jadi
    | supaya tidak dianggap duplicate content oleh Google, seluruhnya
    | canonical ke "/". Title & description tetap dibuat beda per section
    | untuk konteks share link (WhatsApp/Facebook) dan relevansi on-page.
    */

    $siteName = $settings['site_title'];

    $seoSections = [
        'home' => [
            'title' => $siteName.' — Interior, Arsitektur & Kontraktor Sukabumi',
            'description' => $setting->hero_subtitle
                ?: 'Jasa desain interior, arsitektur, dan kontraktor terpercaya di Sukabumi, Jawa Barat.',
            'path' => '/',
        ],
        'home.tentang' => [
            'title' => 'Tentang Kami — '.$siteName,
            'description' => $setting->about_description
                ? Str::limit(strip_tags($setting->about_description), 155)
                : 'Kenali lebih dekat '.$siteName.', perusahaan interior, arsitektur, dan kontraktor di Sukabumi.',
            'path' => '/tentang-kami',
        ],
        'home.layanan' => [
            'title' => 'Layanan — '.$siteName,
            'description' => 'Layanan desain interior, arsitektur, dan kontraktor dari '.$siteName.' untuk hunian dan komersial Anda.',
            'path' => '/layanan',
        ],
        'home.portofolio' => [
            'title' => 'Portofolio Proyek — '.$siteName,
            'description' => 'Lihat portofolio proyek interior, arsitektur, dan konstruksi yang telah dikerjakan '.$siteName.'.',
            'path' => '/portofolio',
        ],
        'home.testimoni' => [
            'title' => 'Testimoni Klien — '.$siteName,
            'description' => 'Testimoni dan ulasan klien yang puas dengan layanan '.$siteName.'.',
            'path' => '/testimoni',
        ],
        'home.kontak' => [
            'title' => 'Kontak & Konsultasi — '.$siteName,
            'description' => 'Hubungi '.$siteName.' untuk konsultasi gratis proyek interior, arsitektur, dan kontraktor Anda.',
            'path' => '/kontak',
        ],
    ];

    $currentRouteName = Route::currentRouteName() ?? 'home';

    $seo = $seoSections[$currentRouteName] ?? $seoSections['home'];
    $seo['canonical'] = url('/');
    $seo['og_image'] = $settings['logo_url'] ?: asset('images/og-default.jpg');

    /*
    |--------------------------------------------------------------------------
    | JSON-LD — LocalBusiness structured data
    |--------------------------------------------------------------------------
    */

    $sameAs = array_values(array_filter([
        $settings['instagram'] ?? null,
        $settings['facebook'] ?? null,
        $settings['tiktok'] ?? null,
        $settings['youtube'] ?? null,
    ]));

    $jsonLd = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'HomeAndConstructionBusiness',
        'name' => $siteName,
        'image' => $seo['og_image'],
        'url' => url('/'),
        'telephone' => $settings['wa_number'] ?? null,
        'email' => $settings['email'] ?? null,
        'address' => array_filter([
            '@type' => 'PostalAddress',
            'streetAddress' => $settings['address'] ?? null,
            'addressLocality' => 'Sukabumi',
            'addressRegion' => 'Jawa Barat',
            'addressCountry' => 'ID',
        ]),
        'hasMap' => $settings['maps_url'] ?? null,
        'sameAs' => $sameAs ?: null,
    ]);

    return view('index', compact(
        'settings',
        'misiList',
        'portfolios',
        'testimonials',
        'faqs',
        'setting',
        'heroSlides',
        'team',
        'workflows',
        'clientPartners',
        'services',
        'affiliatedDivisions',
        'seo',
        'jsonLd'
    ));
};

/*
|--------------------------------------------------------------------------
| Landing Page — route per section
|--------------------------------------------------------------------------
| Semua route di bawah ini pakai closure ($landingPage) yang sama persis
| (data yang di-load tidak berubah), cuma path/URL-nya beda per section.
| Section mana yang di-scroll ke saat halaman dibuka ditentukan di JS
| lewat window.location.pathname (lihat index.blade.php).
*/

Route::get('/', $landingPage)->name('home');
Route::get('/tentang-kami', $landingPage)->name('home.tentang');
Route::get('/layanan', $landingPage)->name('home.layanan');
Route::get('/portofolio', $landingPage)->name('home.portofolio');
Route::get('/testimoni', $landingPage)->name('home.testimoni');
Route::get('/kontak', $landingPage)->name('home.kontak');

/*
|--------------------------------------------------------------------------
| sitemap.xml — dinamis, otomatis pakai APP_URL
|--------------------------------------------------------------------------
| Cuma daftar "/" karena semua route section canonical ke situ (lihat
| $seo['canonical'] di atas) — mencegah Google index 6 URL yang isinya
| sama sebagai halaman terpisah.
*/

Route::get('/sitemap.xml', function () {
    $xml = view('sitemap', ['urls' => [
        ['loc' => url('/'), 'priority' => '1.0'],
    ]])->render();

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

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
