@extends('admin.layout')

@section('title', 'Edit FAQ')

@section('content')
    <div class="mb-6"><a href="{{ route('admin.faqs.index') }}" class="text-sm text-stone-500 hover:text-stone-700">&larr; Kembali</a></div>

    @if ($faq->updated_at)
        <div class="mb-6 rounded-lg border border-stone-200 bg-stone-50 px-4 py-3 text-sm text-stone-600">
            Terakhir diubah oleh <span class="font-medium text-stone-800">{{ optional($faq->updatedBy)->name ?? 'tidak diketahui' }}</span>
            &middot; {{ $faq->updated_at->diffForHumans() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.faqs.update', $faq) }}" class="mx-auto max-w-2xl space-y-6 rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        <div>
            <label for="question" class="mb-1.5 block text-sm font-medium text-stone-700">Pertanyaan <span class="text-red-500">*</span></label>
            <input type="text" name="question" id="question" value="{{ old('question', $faq->question) }}" required class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
            @error('question') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="answer" class="mb-1.5 block text-sm font-medium text-stone-700">Jawaban <span class="text-red-500">*</span></label>
            <textarea name="answer" id="answer" rows="5" required class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">{{ old('answer', $faq->answer) }}</textarea>
            @error('answer') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="sort_order" class="mb-1.5 block text-sm font-medium text-stone-700">Urutan</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $faq->sort_order) }}" min="0" class="w-full rounded-lg border border-stone-300 px-3.5 py-2.5 text-sm shadow-sm focus:border-[#2C3E35] focus:outline-none focus:ring-2 focus:ring-[#2C3E35]/20">
                <p class="mt-1 text-xs text-stone-400">Angka lebih kecil tampil lebih dulu.</p>
            </div>
            <div class="flex items-end pb-1">
                <label class="flex items-center gap-2 text-sm text-stone-700">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $faq->is_published)) class="h-4 w-4 rounded border-stone-300 text-[#2C3E35] focus:ring-[#2C3E35]">
                    Published
                </label>
            </div>
        </div>
        <div class="flex items-center justify-end gap-3 border-t border-stone-100 pt-5">
            <a href="{{ route('admin.faqs.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-100">Batal</a>
            <button type="submit" class="rounded-lg bg-[#2C3E35] px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#24332c]">Simpan Perubahan</button>
        </div>
    </form>
@endsection
