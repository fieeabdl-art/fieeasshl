<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TeamProfileResource;
use App\Models\TeamProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminTeamProfileController extends Controller
{
    public function index(): JsonResponse
    {
        $team = TeamProfile::orderBy('sort_order')->orderByDesc('created_at')->get();

        return response()->json([
            'success' => true,
            'message' => 'Team profiles retrieved successfully',
            'data' => TeamProfileResource::collection($team),
        ]);
    }

    public function store(Request $request): JsonResponse
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
            $validated['image_path'] = $request->file('image_path')->store('team', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['updated_by'] = Auth::id();

        $teamProfile = TeamProfile::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Team profile created successfully',
            'data' => new TeamProfileResource($teamProfile),
        ], 201);
    }

    public function show(TeamProfile $teamProfile): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Team profile retrieved successfully',
            'data' => new TeamProfileResource($teamProfile),
        ]);
    }

    public function update(Request $request, TeamProfile $teamProfile): JsonResponse
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
            $validated['image_path'] = $request->file('image_path')->store('team', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published', $teamProfile->is_published);
        $validated['sort_order'] = $validated['sort_order'] ?? $teamProfile->sort_order;
        $validated['updated_by'] = Auth::id();

        $teamProfile->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Team profile updated successfully',
            'data' => new TeamProfileResource($teamProfile),
        ]);
    }

    public function destroy(TeamProfile $teamProfile): JsonResponse
    {
        if ($teamProfile->image_path) {
            Storage::disk('public')->delete($teamProfile->image_path);
        }

        $teamProfile->delete();

        return response()->json([
            'success' => true,
            'message' => 'Team profile deleted successfully',
        ]);
    }
}
