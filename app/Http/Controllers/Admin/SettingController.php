<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $setting = Setting::current();

        return view('admin.settings.edit', compact('setting'));
    }

    public function update(UpdateSettingRequest $request): RedirectResponse
    {
        $setting = Setting::current();
        $data = $request->safe()->except([
            'logo',
            'remove_logo',
            'hero_image',
            'about_image',
            'remove_hero_image',
            'remove_about_image',
            'social_instagram',
            'social_facebook',
            'social_tiktok',
            'social_youtube',
        ]);

        $social = array_filter([
            'instagram' => $request->input('social_instagram'),
            'facebook' => $request->input('social_facebook'),
            'tiktok' => $request->input('social_tiktok'),
            'youtube' => $request->input('social_youtube'),
        ], fn ($v) => filled($v));

        $data['social_links'] = $social ?: null;

        if ($request->boolean('remove_logo') && $setting->logo) {
            Storage::disk('public')->delete($setting->logo);
            $data['logo'] = null;
        }

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->boolean('remove_hero_image') && $setting->hero_image) {
            Storage::disk('public')->delete($setting->hero_image);
            $data['hero_image'] = null;
        }

        if ($request->hasFile('hero_image')) {
            if ($setting->hero_image) {
                Storage::disk('public')->delete($setting->hero_image);
            }
            $data['hero_image'] = $request->file('hero_image')->store('settings', 'public');
        }

        if ($request->boolean('remove_about_image') && $setting->about_image) {
            Storage::disk('public')->delete($setting->about_image);
            $data['about_image'] = null;
        }

        if ($request->hasFile('about_image')) {
            if ($setting->about_image) {
                Storage::disk('public')->delete($setting->about_image);
            }
            $data['about_image'] = $request->file('about_image')->store('settings', 'public');
        }

        $setting->update($data);

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
