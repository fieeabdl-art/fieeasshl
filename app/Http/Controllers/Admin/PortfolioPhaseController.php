<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioPhase;
use App\Models\PortfolioPhaseImage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PortfolioPhaseController extends Controller
{
    /**
     * List the 3 fixed progress phases for a portfolio.
     * Missing phases (e.g. for a portfolio created before this feature,
     * or a brand new portfolio) are auto-provisioned with empty content.
     */
    public function index(Portfolio $portfolio): View
    {
        $duplicates = PortfolioPhase::ensureForPortfolio($portfolio);

        $portfolio->load(['phases' => function ($q) {
            $q->orderBy('percentage');
        }, 'phases.images' => function ($q) {
            $q->orderBy('sort_order');
        }]);

        return view('admin.portfolio-phases.index', compact('portfolio', 'duplicates'));
    }

    /**
     * Free-form phase creation is not allowed. The 3 phases are provisioned
     * automatically by ensurePhases(). This action is kept only so old
     * links/route names don't hard-break; it always no-ops.
     */
    public function store(Request $request, Portfolio $portfolio): RedirectResponse
    {
        return redirect()
            ->route('admin.portfolios.phases.index', $portfolio)
            ->with('error', 'Tidak diizinkan menambah tahap baru. Progres proyek tetap terdiri dari 3 tahap tetap: 0%, 50%, dan 100%.');
    }

    public function edit(Portfolio $portfolio, PortfolioPhase $phase): View
    {
        $this->authorizePhaseBelongsToPortfolio($portfolio, $phase);

        $phase->load('images');

        return view('admin.portfolio-phases.edit', compact('portfolio', 'phase'));
    }

    /**
     * Admin may only update title, description, and photos.
     * Percentage (and therefore stage identity/order) is locked.
     */
    public function update(Request $request, Portfolio $portfolio, PortfolioPhase $phase): RedirectResponse
    {
        $this->authorizePhaseBelongsToPortfolio($portfolio, $phase);

        $validated = $this->validatePhase($request);

        $phase->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            // percentage & sort_order are intentionally NOT touched here.
        ]);

        $this->storeImages($request, $phase);

        return redirect()
            ->route('admin.portfolios.phases.edit', [$portfolio, $phase])
            ->with('success', 'Tahap progres berhasil diperbarui.');
    }

    /**
     * Deleting one of the 3 fixed phases would break the 0/50/100 structure,
     * so this is disabled. Route kept for compatibility; always no-ops.
     */
    public function destroy(Portfolio $portfolio, PortfolioPhase $phase): RedirectResponse
    {
        return redirect()
            ->route('admin.portfolios.phases.index', $portfolio)
            ->with('error', 'Tahap progres tidak dapat dihapus karena strukturnya tetap (0%, 50%, 100%).');
    }

    /**
     * Delete a single gallery image from a phase (used from the edit page).
     */
    public function destroyImage(Portfolio $portfolio, PortfolioPhase $phase, PortfolioPhaseImage $image): RedirectResponse
    {
        $this->authorizePhaseBelongsToPortfolio($portfolio, $phase);

        if ($image->portfolio_phase_id !== $phase->id) {
            abort(404);
        }

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return redirect()
            ->route('admin.portfolios.phases.edit', [$portfolio, $phase])
            ->with('success', 'Foto galeri berhasil dihapus.');
    }

    protected function authorizePhaseBelongsToPortfolio(Portfolio $portfolio, PortfolioPhase $phase): void
    {
        if ($phase->portfolio_id !== $portfolio->id) {
            abort(404);
        }
    }

    protected function validatePhase(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:15360'],
        ], [
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, jpg, png, atau webp.',
            'images.*.max' => 'Ukuran setiap gambar maksimal 15 MB.',
        ]);
    }

    protected function storeImages(Request $request, PortfolioPhase $phase): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $nextOrder = ($phase->images()->max('sort_order') ?? -1) + 1;

        foreach ($request->file('images') as $file) {
            PortfolioPhaseImage::create([
                'portfolio_phase_id' => $phase->id,
                'image' => $file->store('portfolio-phases', 'public'),
                'sort_order' => $nextOrder++,
            ]);
        }
    }
}
