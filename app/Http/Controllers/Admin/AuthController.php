<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminActivityLogger;
use App\Services\AdminLoginThrottle;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(protected AdminLoginThrottle $throttle)
    {
        //
    }

    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $identifier = $this->throttle->identifierFor($credentials['email'], $request->ip());

        // Sudah terkunci dari percobaan sebelumnya — tolak sebelum
        // sempat mengecek password sama sekali.
        if ($lockedUntil = $this->throttle->lockedUntil($identifier)) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => $this->lockedMessage($lockedUntil),
                ]);
        }

        $remember = $request->boolean('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $this->throttle->clear($identifier);

            AdminActivityLogger::log(
                action: 'logged_in',
                description: (Auth::guard('admin')->user()?->name ?? 'Admin').' login ke CMS',
            );

            return redirect()->intended(route('admin.dashboard'));
        }

        $this->throttle->recordFailure($identifier);

        // Kalau percobaan barusan yang bikin kena lockout, langsung
        // tampilkan pesan lockout-nya, bukan pesan "salah" biasa.
        if ($lockedUntil = $this->throttle->lockedUntil($identifier)) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => $this->lockedMessage($lockedUntil),
                ]);
        }

        $remaining = $this->throttle->remainingAttempts($identifier);

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => "Email atau password tidak sesuai. Sisa {$remaining}x percobaan sebelum akun dikunci sementara.",
            ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function lockedMessage(CarbonInterface $lockedUntil): string
    {
        $minutes = max(1, now()->diffInMinutes($lockedUntil));

        return "Terlalu banyak percobaan gagal. Silakan coba lagi dalam {$minutes} menit (sekitar pukul {$lockedUntil->translatedFormat('H:i')}).";
    }
}
