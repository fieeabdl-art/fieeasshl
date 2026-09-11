<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliatedDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AffiliatedDivisionController extends Controller
{
    public function index()
    {
        $affiliatedDivisions = AffiliatedDivision::query()
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.affiliated-divisions.index', compact('affiliatedDivisions'));
    }

    public function create()
    {
        return view('admin.affiliated-divisions.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('affiliated-divisions', 'public');
        }

        AffiliatedDivision::create($validated);

        return redirect()
            ->route('admin.affiliated-divisions.index')
            ->with('success', 'Divisi terafiliasi berhasil ditambahkan.');
    }

    public function edit(AffiliatedDivision $affiliatedDivision)
    {
        return view('admin.affiliated-divisions.edit', compact('affiliatedDivision'));
    }

    public function update(Request $request, AffiliatedDivision $affiliatedDivision)
    {
        $validated = $this->validated($request, $affiliatedDivision);

        if ($request->boolean('remove_logo') && $affiliatedDivision->logo) {
            Storage::disk('public')->delete($affiliatedDivision->logo);
            $validated['logo'] = null;
        }

        if ($request->hasFile('logo')) {
            if ($affiliatedDivision->logo) {
                Storage::disk('public')->delete($affiliatedDivision->logo);
            }

            $validated['logo'] = $request->file('logo')->store('affiliated-divisions', 'public');
        }

        $affiliatedDivision->update($validated);

        return redirect()
            ->route('admin.affiliated-divisions.index')
            ->with('success', 'Divisi terafiliasi berhasil diperbarui.');
    }

    public function destroy(AffiliatedDivision $affiliatedDivision)
    {
        if ($affiliatedDivision->logo) {
            Storage::disk('public')->delete($affiliatedDivision->logo);
        }

        $affiliatedDivision->delete();

        return redirect()
            ->route('admin.affiliated-divisions.index')
            ->with('success', 'Divisi terafiliasi berhasil dihapus.');
    }

    /**
     * Validasi input form. Field "initial" & "color" tidak lagi diisi
     * manual lewat form (tidak hardcode per-record); keduanya dihitung
     * otomatis dari nama dan hanya dipakai sebagai fallback ikon
     * lingkaran saat belum ada logo yang diunggah.
     */
    protected function validated(Request $request, ?AffiliatedDivision $affiliatedDivision = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:15360'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
            'remove_logo' => ['nullable', 'boolean'],
        ], [
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus JPG, JPEG, PNG, WebP, atau SVG.',
            'logo.max' => 'Ukuran logo maksimal 15 MB.',
        ]);

        unset($validated['remove_logo']);

        $validated['initial'] = mb_strtoupper(mb_substr(trim($validated['name']), 0, 1)) ?: 'D';
        $validated['color'] = $affiliatedDivision?->color ?? '#2C3E35';
        $validated['is_published'] = $request->boolean('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }
}
