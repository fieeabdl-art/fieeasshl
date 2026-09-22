@extends('admin.layout')

@section('title', 'Edit Admin')

@section('content')
    <div class="mb-6"><a href="{{ route('admin.admins.index') }}" class="text-sm text-stone-500 hover:text-stone-700">&larr; Kembali</a></div>

    <form method="POST" action="{{ route('admin.admins.update', $adminUser) }}" class="mx-auto max-w-2xl space-y-6 rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="mb-1.5 block text-sm font-medium text-stone-700">Nama <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $adminUser->name) }}" required class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
            @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="email" class="mb-1.5 block text-sm font-medium text-stone-700">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" id="email" value="{{ old('email', $adminUser->email) }}" required class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="password" class="mb-1.5 block text-sm font-medium text-stone-700">Password Baru</label>
                <input type="password" name="password" id="password" class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                <p class="mt-1 text-xs text-stone-400">Kosongkan jika tidak ingin mengubah password.</p>
                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-stone-700">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
            </div>
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-medium text-stone-700">Peran <span class="text-red-500">*</span></label>
            <div class="grid gap-3 sm:grid-cols-2">
                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-stone-300 p-3.5 text-sm has-[:checked]:border-[#2C3E35] has-[:checked]:bg-[#2C3E35]/5">
                    <input type="radio" name="role" value="admin" class="mt-0.5" {{ old('role', $adminUser->role) === 'admin' ? 'checked' : '' }}>
                    <span>
                        <span class="block font-medium text-stone-800">Admin</span>
                        <span class="block text-xs text-stone-500">Mengelola konten website (layanan, portofolio, dll).</span>
                    </span>
                </label>
                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-stone-300 p-3.5 text-sm has-[:checked]:border-[#2C3E35] has-[:checked]:bg-[#2C3E35]/5">
                    <input type="radio" name="role" value="super_admin" class="mt-0.5" {{ old('role', $adminUser->role) === 'super_admin' ? 'checked' : '' }}>
                    <span>
                        <span class="block font-medium text-stone-800">Super Admin</span>
                        <span class="block text-xs text-stone-500">Semua akses Admin + dapat menambah/menghapus admin lain.</span>
                    </span>
                </label>
            </div>
            @error('role') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="flex items-center justify-end gap-3 border-t border-stone-100 pt-5">
            <a href="{{ route('admin.admins.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-100">Batal</a>
            <button type="submit" class="rounded-lg bg-[#2C3E35] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#24332c]">Simpan Perubahan</button>
        </div>
    </form>
@endsection
