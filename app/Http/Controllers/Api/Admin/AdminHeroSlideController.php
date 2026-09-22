<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\HeroSlideResource;
use App\Models\HeroSlide;
use App\Services\AdminActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminHeroSlideController extends Controller
{
    public function index(): JsonResponse
    {
        $slides = HeroSlide::orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'message' => 'Hero slides retrieved successfully',
            'data' => HeroSlideResource::collection($slides),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:15360'],
        ]);

        $nextOrder = ((int) HeroSlide::max('sort_order')) + 1;
        $created = [];

        foreach ($request->file('images') as $file) {
            $slide = HeroSlide::create([
                'image' => $file->store('hero-slides', 'public'),
                'sort_order' => $nextOrder++,
                'is_active' => true,
            ]);

            $created[] = $slide;
        }

        return response()->json([
            'success' => true,
            'message' => 'Hero slides uploaded successfully',
            'data' => HeroSlideResource::collection($created),
        ], 201);
    }

    public function show(HeroSlide $heroSlide): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Hero slide retrieved successfully',
            'data' => new HeroSlideResource($heroSlide),
        ]);
    }

    public function update(Request $request, HeroSlide $heroSlide): JsonResponse
    {
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:15360'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data = $request->only(['is_active', 'sort_order']);

        if ($request->hasFile('image')) {
            if ($heroSlide->image) {
                Storage::disk('public')->delete($heroSlide->image);
            }
            $data['image'] = $request->file('image')->store('hero-slides', 'public');
        }

        $heroSlide->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Hero slide updated successfully',
            'data' => new HeroSlideResource($heroSlide),
        ]);
    }

    public function destroy(HeroSlide $heroSlide): JsonResponse
    {
        if ($heroSlide->image) {
            Storage::disk('public')->delete($heroSlide->image);
        }

        $heroSlide->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hero slide deleted successfully',
        ]);
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'order' => ['required', 'array', 'min:1'],
            'order.*' => ['integer', Rule::exists('hero_slides', 'id')],
        ]);

        foreach ($request->order as $index => $id) {
            HeroSlide::whereKey($id)->update(['sort_order' => $index]);
        }

        AdminActivityLogger::log(
            action: 'updated',
            description: 'Memperbarui urutan Slide Hero',
            subjectType: 'HeroSlide'
        );

        return response()->json([
            'success' => true,
            'message' => 'Hero slides reordered successfully',
        ]);
    }
}
