<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Admin BumiYuji</title>
    @vite(['resources/css/app.css'])
</head>
<body class="flex min-h-screen items-center justify-center bg-stone-100 antialiased">
    <div class="w-full max-w-md px-4">
        <div class="mb-8 text-center">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-[#2C3E35] text-lg font-bold text-[#C5A880]">BY</div>
            <h1 class="text-2xl font-semibold text-stone-800">Admin BumiYuji</h1>
            <p class="mt-1 text-sm text-stone-500">Masuk untuk mengelola konten website</p>
        </div>

        <div class="rounded-2xl border border-stone-200 bg-white p-8 shadow-sm">
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-stone-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20"
                           placeholder="admin@bumiyuji.test">
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-stone-700">Password</label>
                    <input type="password" name="password" id="password" required autocomplete="current-password"
                           class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20"
                           placeholder="••••••••">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" value="1" {{ old('remember') ? 'checked' : '' }}
                           class="h-4 w-4 rounded border-stone-300 text-[#2C3E35] focus:ring-[#2C3E35]">
                    <label for="remember" class="text-sm text-stone-600">Ingat saya</label>
                </div>
                <button type="submit"
                        class="w-full rounded-lg bg-[#2C3E35] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#24332c] focus:outline-none focus:ring-2 focus:ring-[#2C3E35] focus:ring-offset-2">
                    Masuk
                </button>
            </form>
        </div>
        <p class="mt-6 text-center text-xs text-stone-400">&copy; {{ date('Y') }} BumiYuji Living</p>
    </div>
</body>
</html>
