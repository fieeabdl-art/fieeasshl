<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class HeroSlideController extends Controller
{
    /**
     * Multiple image upload. Each accepted file becomes a new
     * hero_slides row, appended to the bottom of the current order.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:15360'],
        ], [
            'images.required' => 'Pilih minimal satu gambar untuk diunggah.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus JPEG, JPG, PNG, atau WEBP.',
            'images.*.max' => 'Ukuran setiap gambar maksimal 15 MB.',
        ]);

        $nextOrder = ((int) HeroSlide::max('sort_order')) + 1;

        $created = [];

        foreach ($request->file('images') as $file) {
            $slide = HeroSlide::create([
                'image' => $file->store('hero-slides', 'public'),
                'sort_order' => $nextOrder++,
                'is_active' => true,
            ]);

            $created[] = $this->transform($slide);
        }

        return response()->json([
            'message' => 'Gambar Hero berhasil diunggah.',
            'slides' => $created,
        ], 201);
    }

    /**
     * Replace the image file of one existing slide. The record and
     * its sort_order are kept; only the underlying file changes.
     */
    public function update(Request $request, HeroSlide $heroSlide): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:15360'],
        ], [
            'image.required' => 'Pilih gambar pengganti.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPEG, JPG, PNG, atau WEBP.',
            'image.max' => 'Ukuran gambar maksimal 15 MB.',
        ]);

        $oldImage = $heroSlide->image;

        $heroSlide->update([
            'image' => $request->file('image')->store('hero-slides', 'public'),
        ]);

        if ($oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return response()->json([
            'message' => 'Gambar Hero berhasil diganti.',
            'slide' => $this->transform($heroSlide),
        ]);
    }

    /**
     * Delete a slide: remove the database record and its file.
     */
    public function destroy(HeroSlide $heroSlide): JsonResponse
    {
        $image = $heroSlide->image;

        $heroSlide->delete();

        if ($image) {
            Storage::disk('public')->delete($image);
        }

        return response()->json([
            'message' => 'Gambar Hero berhasil dihapus.',
        ]);
    }

    /**
     * Persist a new drag & drop order. Expects: { order: [id, id, ...] }
     * in the new top-to-bottom order.
     */
    public function reorder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order' => ['required', 'array', 'min:1'],
            'order.*' => [
                'integer',
                Rule::exists('hero_slides', 'id'),
            ],
        ], [
            'order.required' => 'Urutan gambar tidak valid.',
        ]);

        foreach ($validated['order'] as $index => $id) {
            HeroSlide::whereKey($id)->update(['sort_order' => $index]);
        }

        return response()->json([
            'message' => 'Urutan gambar Hero berhasil disimpan.',
        ]);
    }

    protected function transform(HeroSlide $slide): array
    {
        return [
            'id' => $slide->id,
            'url' => Storage::url($slide->image),
            'sort_order' => $slide->sort_order,
        ];
    }
}
