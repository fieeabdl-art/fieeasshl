# Phase 2 Admin CMS — Instalasi ke Project BumiYuji

## 1. Copy file

Dari folder `phase2-admin-cms/`, copy ke root project Anda (`bumiyuji2/`):

```
app/Http/Controllers/Admin/          → app/Http/Controllers/Admin/
app/Http/Middleware/EnsureAdmin.php  → app/Http/Middleware/EnsureAdmin.php
app/Http/Requests/Admin/             → app/Http/Requests/Admin/
routes/admin.php                     → routes/admin.php
resources/views/admin/               → resources/views/admin/
```

**Jangan overwrite** file React/Inertia/Fortify yang sudah ada.

---

## 2. Edit `bootstrap/app.php`

Ganti bagian `withRouting` dan `withMiddleware` agar seperti ini (merge, jangan hapus middleware existing):

```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
    then: function () {
        require __DIR__.'/../routes/admin.php';
    },
)
->withMiddleware(function (Middleware $middleware): void {
    $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

    $middleware->web(append: [
        HandleAppearance::class,
        HandleInertiaRequests::class,
        AddLinkHeadersForPreloadedAssets::class,
        SetTeamUrlDefaults::class,
    ]);

    $middleware->alias([
        'admin' => \App\Http\Middleware\EnsureAdmin::class,
    ]);

    $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('admin.login');
        }
        return route('login');
    });

    $middleware->redirectUsersTo(function (\Illuminate\Http\Request $request) {
        if ($request->is('admin/login') || $request->is('admin/login/*')) {
            return route('admin.dashboard');
        }
        return '/';
    });
})
```

Pastikan `use` di atas file tetap ada (HandleAppearance, dll).

---

## 3. Pastikan `config/auth.php` sudah punya guard admin

Harus ada:

```php
'guards' => [
    'web' => [...],
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
],

'providers' => [
    'users' => [...],
    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
],
```

(Ini sudah dari Phase 1.)

---

## 4. Jalankan perintah

```bash
php artisan db:seed --class=AdminSeeder
php artisan storage:link
php artisan optimize:clear
php artisan route:list --path=admin
```

---

## 5. Login

```
URL:      http://127.0.0.1:8000/admin/login
Email:    admin@bumiyuji.test
Password: password
```

---

## Catatan

- Landing page (`index.blade.php`) masih static. Phase 3 akan menghubungkan data CMS ke landing page.
- Jangan masukkan route admin ke dalam `{current_team}`.
