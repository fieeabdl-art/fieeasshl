<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AffiliatedDivisionResource;
use App\Http\Resources\Api\FaqResource;
use App\Http\Resources\Api\HeroSlideResource;
use App\Http\Resources\Api\PortfolioDetailResource;
use App\Http\Resources\Api\PortfolioResource;
use App\Http\Resources\Api\ServiceResource;
use App\Http\Resources\Api\SettingResource;
use App\Http\Resources\Api\TeamProfileResource;
use App\Models\AffiliatedDivision;
use App\Models\Faq;
use App\Models\HeroSlide;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicApiController extends Controller
{
    /**
     * Data awal aplikasi (settings & hero slides).
     */
    public function init(): JsonResponse
    {
        $settings = Setting::current();
        $heroSlides = HeroSlide::where('is_active', true)->orderBy('sort_order')->get();
        $divisions = AffiliatedDivision::where('is_published', true)->orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'message' => 'Initialization data retrieved successfully',
            'data' => [
                'settings' => new SettingResource($settings),
                'hero_slides' => HeroSlideResource::collection($heroSlides),
                'affiliated_divisions' => AffiliatedDivisionResource::collection($divisions),
            ],
        ]);
    }

    /**
     * Daftar portfolio dengan pagination dan filter kategori.
     */
    public function portfolios(Request $request): JsonResponse
    {
        $query = Portfolio::where('is_published', true)
            ->orderBy('sort_order');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $portfolios = $query->paginate($request->integer('per_page', 10));

        return response()->json([
            'success' => true,
            'message' => 'Portfolios retrieved successfully',
            'data' => PortfolioResource::collection($portfolios)->response()->getData(true),
        ]);
    }

    /**
     * Detail portfolio berdasarkan slug.
     */
    public function portfolioDetail(string $slug): JsonResponse
    {
        $portfolio = Portfolio::where('slug', $slug)
            ->where('is_published', true)
            ->with(['phases.images'])
            ->first();

        if (! $portfolio) {
            return response()->json([
                'success' => false,
                'message' => 'Portfolio not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Portfolio detail retrieved successfully',
            'data' => new PortfolioDetailResource($portfolio),
        ]);
    }

    /**
     * Daftar layanan (services).
     */
    public function services(): JsonResponse
    {
        $services = Service::where('status', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Services retrieved successfully',
            'data' => ServiceResource::collection($services),
        ]);
    }

    /**
     * Daftar profil tim.
     */
    public function team(): JsonResponse
    {
        $team = TeamProfile::where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Team profiles retrieved successfully',
            'data' => TeamProfileResource::collection($team),
        ]);
    }

    /**
     * Daftar FAQ.
     */
    public function faq(): JsonResponse
    {
        $faqs = Faq::where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'FAQs retrieved successfully',
            'data' => FaqResource::collection($faqs),
        ]);
    }
}
