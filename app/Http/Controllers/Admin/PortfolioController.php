<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PortfolioCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePortfolioRequest;
use App\Http\Requests\Admin\UpdatePortfolioRequest;
use App\Models\Portfolio;
use App\Models\PortfolioPhase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $portfolios = Portfolio::query()
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create(): View
    {
        $categories = PortfolioCategory::cases();

        return view('admin.portfolios.create', compact('categories'));
    }

    public function store(StorePortfolioRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['image']);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = $request->integer('sort_order', 0);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('portfolios', 'public');
        }

        $portfolio = Portfolio::query()->create($data);

        // Every portfolio gets the 3 fixed progress phases (0/50/100)
        // ready to fill in, without forcing changes to the rest of the flow.
        PortfolioPhase::ensureForPortfolio($portfolio);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil ditambahkan.');
    }

    public function edit(Portfolio $portfolio): View
    {
        $categories = PortfolioCategory::cases();
        $portfolio->load('phases.images');
        return view('admin.portfolios.edit', compact('portfolio', 'categories'));

    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'remove_image']);
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = $request->integer('sort_order', 0);

        if ($portfolio->title !== $data['title']) {
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

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        if ($portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil dihapus.');
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
