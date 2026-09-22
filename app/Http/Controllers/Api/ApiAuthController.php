<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\AdminActivityLogger;
use App\Services\AdminLoginThrottle;
use Carbon\CarbonInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class ApiAuthController extends Controller
{
    public function __construct(protected AdminLoginThrottle $throttle) {}

    /**
     * Login admin dan berikan token.
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_name' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'device_name.required' => 'Nama perangkat wajib diisi.',
        ]);

        $identifier = $this->throttle->identifierFor($request->email, $request->ip());

        if ($lockedUntil = $this->throttle->lockedUntil($identifier)) {
            return response()->json([
                'message' => $this->lockedMessage($lockedUntil),
            ], 429);
        }

        $admin = Admin::where('email', $request->email)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            $this->throttle->recordFailure($identifier);

            if ($lockedUntil = $this->throttle->lockedUntil($identifier)) {
                return response()->json([
                    'message' => $this->lockedMessage($lockedUntil),
                ], 429);
            }

            $remaining = $this->throttle->remainingAttempts($identifier);

            return response()->json([
                'message' => "Email atau password tidak sesuai. Sisa {$remaining}x percobaan sebelum akun dikunci sementara.",
            ], 401);
        }

        $this->throttle->clear($identifier);

        $token = $admin->createToken($request->device_name)->plainTextToken;

        // Login ke guard admin secara manual supaya AdminActivityLogger bisa ambil user()
        Auth::guard('admin')->login($admin);

        AdminActivityLogger::log(
            action: 'logged_in',
            description: $admin->name.' login via API',
        );

        return response()->json([
            'token' => $token,
            'admin' => [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => $admin->role,
            ],
        ]);
    }

    /**
     * Logout dan hapus token saat ini.
     */
    public function logout(Request $request): JsonResponse
    {
        /** @var PersonalAccessToken $accessToken */
        $accessToken = $request->user()->currentAccessToken();

        if ($accessToken) {
            $accessToken->delete();
        }

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    /**
     * Ambil data admin yang sedang login.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }

    protected function lockedMessage(CarbonInterface $lockedUntil): string
    {
        $minutes = max(1, now()->diffInMinutes($lockedUntil));

        return "Terlalu banyak percobaan gagal. Silakan coba lagi dalam {$minutes} menit.";
    }
}
