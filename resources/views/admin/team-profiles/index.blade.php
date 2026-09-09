@extends('admin.layout')

@section('title', 'Our Team')
@section('header_title', 'Our Team')
@section('header_subtitle', 'Kelola anggota tim yang tampil pada landing page BumiYuji.')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">
                Daftar Anggota Team
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Tambahkan dan kelola anggota team BumiYuji.
            </p>
        </div>

        <a
    href="{{ route('admin.team-profiles.create') }}"
    class="inline-flex items-center justify-center rounded-xl bg-[#2c3e35] px-5 py-3 text-sm font-medium text-gray-300 shadow-sm transition hover:bg-[#1f2d27]"
>
    + Tambah Anggota
</a>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation Error --}}
    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4">
            <p class="mb-2 text-sm font-semibold text-red-700">
                Terdapat kesalahan:
            </p>

            <ul class="list-disc space-y-1 pl-5 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Team Table --}}
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Foto
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Nama
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Jabatan
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Urutan
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse ($teamProfiles as $member)

                        <tr class="transition hover:bg-gray-50">

                            {{-- Foto --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($member->image_path)
                                    <img
                                        src="{{ Storage::url($member->image_path) }}"
                                        alt="{{ $member->name }}"
                                        class="h-14 w-14 rounded-xl object-cover"
                                    >
                                @else
                                    <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gray-100 text-xs font-medium text-gray-400">
                                        No Photo
                                    </div>
                                @endif
                            </td>

                            {{-- Nama --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-medium text-gray-900">
                                    {{ $member->name }}
                                </div>

                                <div class="mt-1 text-xs text-gray-400">
                                    ID #{{ $member->id }}
                                </div>
                            </td>

                            {{-- Jabatan --}}
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                {{ $member->position ?: '-' }}
                            </td>

                            {{-- Urutan --}}
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span class="inline-flex min-w-8 items-center justify-center rounded-lg bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600">
                                    {{ $member->sort_order }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                @if ($member->is_published)
                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-500">
                                        Draft
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">

                                    <a
                                        href="{{ route('admin.team-profiles.edit', $member) }}"
                                        class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-medium text-gray-600 transition hover:border-gray-300 hover:bg-gray-50 hover:text-gray-900"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.team-profiles.destroy', $member) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus {{ $member->name }}?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg border border-red-200 px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50"
                                        >
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">

                                <div class="mx-auto max-w-md">

                                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-2xl">
                                        👥
                                    </div>

                                    <h3 class="text-base font-semibold text-gray-900">
                                        Belum ada anggota team
                                    </h3>

                                    <p class="mt-2 text-sm text-gray-500">
                                        Tambahkan anggota team pertama untuk ditampilkan
                                        pada landing page BumiYuji.
                                    </p>

                                    <a
                                        href="{{ route('admin.team-profiles.create') }}"
                                        class="mt-5 inline-flex rounded-xl bg-[#2c3e35] px-5 py-3 text-sm font-medium text-white transition hover:bg-[#1f2d27]"
                                    >
                                        + Tambah Anggota
                                    </a>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        @if ($teamProfiles->isNotEmpty())
            <div class="border-t border-gray-100 bg-gray-50 px-6 py-4">
                <p class="text-xs text-gray-500">
                    Total {{ $teamProfiles->count() }} anggota team
                </p>
            </div>
        @endif

    </div>

</div>
@endsection