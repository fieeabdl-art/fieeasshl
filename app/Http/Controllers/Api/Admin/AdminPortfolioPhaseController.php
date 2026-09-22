<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PortfolioPhaseResource;
use App\Models\Portfolio;
use App\Models\PortfolioPhase;
use App\Models\PortfolioPhaseImage;
use App\Services\AdminActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminPortfolioPhaseController extends Controller
{
    /**
     * List all phases for a portfolio.
     */
    public function index(Portfolio $portfolio): JsonResponse
    {
        PortfolioPhase::ensureForPortfolio($portfolio);

        $phases = $portfolio->phases()->with('images')->get();

        return response()->json([
            'success' => true,
            'message' => 'Portfolio phases retrieved successfully',
            'data' => PortfolioPhaseResource::collection($phases),
        ]);
    }

    /**
     * Update a specific phase title and description.
     */
    public function update(Request $request, Portfolio $portfolio, PortfolioPhase $phase): JsonResponse
    {
        if ($phase->portfolio_id !== $portfolio->id) {
            return response()->json(['success' => false, 'message' => 'Phase not found for this portfolio'], 404);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $phase->update($validated + ['updated_by' => Auth::id()]);

        return response()->json([
            'success' => true,
            'message' => 'Portfolio phase updated successfully',
            'data' => new PortfolioPhaseResource($phase->load('images')),
        ]);
    }

    /**
     * Delete a specific image from a phase.
     */
    public function destroyImage(Portfolio $portfolio, PortfolioPhase $phase, PortfolioPhaseImage $image): JsonResponse
    {
        if ($phase->portfolio_id !== $portfolio->id || $image->portfolio_phase_id !== $phase->id) {
            return response()->json(['success' => false, 'message' => 'Image not found for this phase'], 404);
        }

        Storage::disk('public')->delete($image->image);
        $image->delete();

        AdminActivityLogger::log(
            action: 'updated',
            description: "Menghapus foto dari Portofolio '{$portfolio->title}' tahap {$phase->percentage}%",
            subjectType: 'Portfolio',
            subjectId: $portfolio->id
        );

        return response()->json([
            'success' => true,
            'message' => 'Phase image deleted successfully',
        ]);
    }
}
