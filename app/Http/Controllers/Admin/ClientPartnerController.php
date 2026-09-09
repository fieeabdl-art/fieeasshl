<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClientPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ClientPartnerController extends Controller
{
    public function index()
    {
        $clientPartners = ClientPartner::query()
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.client-partners.index', compact('clientPartners'));
    }

    public function create()
    {
        return view('admin.client-partners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
            'type' => ['required', Rule::in(['client', 'partner'])],
            'description' => ['nullable', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ], [
            'logo.max' => 'Ukuran logo maksimal 15 MB.',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('client-partners', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        ClientPartner::create($validated);

        return redirect()
            ->route('admin.client-partners.index')
            ->with('success', 'Klien/Mitra berhasil ditambahkan.');
    }

    public function edit(ClientPartner $clientPartner)
    {
        return view('admin.client-partners.edit', compact('clientPartner'));
    }

    public function update(Request $request, ClientPartner $clientPartner)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
            'type' => ['required', Rule::in(['client', 'partner'])],
            'description' => ['nullable', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
            'remove_logo' => ['nullable', 'boolean'],
        ], [
            'logo.max' => 'Ukuran logo maksimal 15 MB.',
        ]);

        if ($request->boolean('remove_logo') && $clientPartner->logo) {
            Storage::disk('public')->delete($clientPartner->logo);
            $validated['logo'] = null;
        }

        if ($request->hasFile('logo')) {
            if ($clientPartner->logo) {
                Storage::disk('public')->delete($clientPartner->logo);
            }

            $validated['logo'] = $request->file('logo')->store('client-partners', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $clientPartner->update($validated);

        return redirect()
            ->route('admin.client-partners.index')
            ->with('success', 'Data klien/mitra berhasil diperbarui.');
    }

    public function destroy(ClientPartner $clientPartner)
    {
        if ($clientPartner->logo) {
            Storage::disk('public')->delete($clientPartner->logo);
        }

        $clientPartner->delete();

        return redirect()
            ->route('admin.client-partners.index')
            ->with('success', 'Klien/Mitra berhasil dihapus.');
    }
}
