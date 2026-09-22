<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePortfolioRequest;
use App\Http\Requests\Admin\UpdatePortfolioRequest;
use App\Http\Resources\Api\PortfolioDetailResource;
use App\Http\Resources\Api\PortfolioResource;
use App\Models\Portfolio;
use App\Models\PortfolioPhase;
use App\Models\PortfolioPhaseImage;
use App\Services\AdminActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPortfolioController extends Controller
{
    public function index(): JsonResponse
    {
        $portfolios = Portfolio::query()
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Portfolios retrieved successfully',
            'data' => PortfolioResource::collection($portfolios)->response()->getData(true),
        ]);
    }

    public function store(StorePortfolioRequest $request): JsonResponse
    {
        $data = $request->safe()->except(['image']);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['is_published'] = $request->boolean('is_published', true);
        $data['sort_order'] = $request->integer('sort_order', 0);
        $data['updated_by'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('portfolios', 'public');
        }

        $portfolio = Portfolio::create($data);
        PortfolioPhase::ensureForPortfolio($portfolio);

        return response()->json([
            'success' => true,
            'message' => 'Portfolio created successfully',
            'data' => new PortfolioDetailResource($portfolio->load('phases.images')),
        ], 201);
    }

    public function show(Portfolio $portfolio): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Portfolio retrieved successfully',
            'data' => new PortfolioDetailResource($portfolio->load('phases.images')),
        ]);
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio): JsonResponse
    {
        $data = $request->safe()->except(['image', 'remove_image']);
        $data['is_published'] = $request->boolean('is_published', $portfolio->is_published);
        $data['sort_order'] = $request->integer('sort_order', $portfolio->sort_order);
        $data['updated_by'] = Auth::id();

        if (isset($data['title']) && $portfolio->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $portfolio->id);
        }

        if ($request->boolean('remove_image') && $portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }
            $data['image'] = $request->file('image')->store('portfolios', 'public');
        }

        $portfolio->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Portfolio updated successfully',
            'data' => new PortfolioDetailResource($portfolio->load('phases.images')),
        ]);
    }

    public function destroy(Portfolio $portfolio): JsonResponse
    {
        if ($portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
        }

        // Delete phase images too
        foreach ($portfolio->phases as $phase) {
            foreach ($phase->images as $image) {
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }
            $phase->delete();
        }

        $portfolio->delete();

        return response()->json([
            'success' => true,
            'message' => 'Portfolio deleted successfully',
        ]);
    }

    /**
     * Upload images to a specific phase of a portfolio.
     */
    public function uploadPhaseImages(Request $request, Portfolio $portfolio, PortfolioPhase $phase): JsonResponse
    {
        if ($phase->portfolio_id !== $portfolio->id) {
            return response()->json(['success' => false, 'message' => 'Phase does not belong to this portfolio'], 404);
        }

        $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:15360'],
        ]);

        $nextOrder = ($phase->images()->max('sort_order') ?? -1) + 1;
        $created = [];

        foreach ($request->file('images') as $file) {
            $created[] = PortfolioPhaseImage::create([
                'portfolio_phase_id' => $phase->id,
                'image' => $file->store('portfolio-phases', 'public'),
                'sort_order' => $nextOrder++,
            ]);
        }

        AdminActivityLogger::log(
            action: 'updated',
            description: "Menambahkan foto ke Portofolio '{$portfolio->title}' tahap {$phase->percentage}%",
            subjectType: 'Portfolio',
            subjectId: $portfolio->id
        );

        return response()->json([
            'success' => true,
            'message' => 'Phase images uploaded successfully',
            'data' => $portfolio->load('phases.images'),
        ]);
    }

    protected function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 1;

        while (
            Portfolio::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
