<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamProfileController extends Controller
{
    public function index()
    {
        $teamProfiles = TeamProfile::query()
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.team-profiles.index', compact('teamProfiles'));
    }

    public function create()
    {
        return view('admin.team-profiles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request
                ->file('image_path')
                ->store('team', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        TeamProfile::create($validated);

        return redirect()
            ->route('admin.team-profiles.index')
            ->with('success', 'Anggota team berhasil ditambahkan.');
    }

    public function edit(TeamProfile $teamProfile)
    {
        return view('admin.team-profiles.edit', compact('teamProfile'));
    }

    public function update(Request $request, TeamProfile $teamProfile)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_path')) {
            if ($teamProfile->image_path) {
                Storage::disk('public')->delete($teamProfile->image_path);
            }

            $validated['image_path'] = $request
                ->file('image_path')
                ->store('team', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $teamProfile->update($validated);

        return redirect()
            ->route('admin.team-profiles.index')
            ->with('success', 'Data anggota team berhasil diperbarui.');
    }

    public function destroy(TeamProfile $teamProfile)
    {
        if ($teamProfile->image_path) {
            Storage::disk('public')->delete($teamProfile->image_path);
        }

        $teamProfile->delete();

        return redirect()
            ->route('admin.team-profiles.index')
            ->with('success', 'Anggota team berhasil dihapus.');
    }
}
