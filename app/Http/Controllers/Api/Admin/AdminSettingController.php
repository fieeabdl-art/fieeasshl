<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Http\Resources\Api\SettingResource;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    public function show(): JsonResponse
    {
        $setting = Setting::current();

        return response()->json([
            'success' => true,
            'message' => 'Settings retrieved successfully',
            'data' => new SettingResource($setting),
        ]);
    }

    public function update(UpdateSettingRequest $request): JsonResponse
    {
        $setting = Setting::current();

        $data = $request->safe()->except([
            'logo',
            'favicon',
            'remove_logo',
            'remove_favicon',
            'hero_image',
            'about_image',
            'remove_hero_image',
            'remove_about_image',
            'about_video',
            'remove_about_video',
            'parent_company_logo',
            'remove_parent_company_logo',
            'social_instagram',
            'social_facebook',
            'social_tiktok',
            'social_youtube',
        ]);

        // Social Media
        $social = array_filter([
            'instagram' => $request->input('social_instagram'),
            'facebook' => $request->input('social_facebook'),
            'tiktok' => $request->input('social_tiktok'),
            'youtube' => $request->input('social_youtube'),
        ], fn ($v) => filled($v));

        $data['social_links'] = $social ?: null;
        $data['updated_by'] = Auth::id();

        // Image & Video Processing
        $this->processFile($request, $setting, $data, 'logo', 'settings');
        $this->processFile($request, $setting, $data, 'favicon', 'settings');
        $this->processFile($request, $setting, $data, 'hero_image', 'settings');
        $this->processFile($request, $setting, $data, 'about_image', 'settings');
        $this->processFile($request, $setting, $data, 'about_video', 'settings/videos');
        $this->processFile($request, $setting, $data, 'parent_company_logo', 'settings');

        $setting->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully',
            'data' => new SettingResource($setting),
        ]);
    }

    protected function processFile($request, $setting, &$data, string $field, string $path): void
    {
        $removeField = 'remove_'.$field;

        if ($request->boolean($removeField) && $setting->{$field}) {
            Storage::disk('public')->delete($setting->{$field});
            $data[$field] = null;
        }

        if ($request->hasFile($field)) {
            if ($setting->{$field}) {
                Storage::disk('public')->delete($setting->{$field});
            }

            $data[$field] = $request->file($field)->store($path, 'public');
        }
    }
}
