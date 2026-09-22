<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Models\HeroSlide;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        $setting = Setting::current();

        $heroSlides = HeroSlide::query()
            ->orderBy('sort_order')
            ->get();

        return view('admin.settings.edit', compact('setting', 'heroSlides'));
    }

    public function update(UpdateSettingRequest $request): RedirectResponse
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

        /*
        |--------------------------------------------------------------------------
        | Social Media
        |--------------------------------------------------------------------------
        */

        $social = array_filter([
            'instagram' => $request->input('social_instagram'),
            'facebook' => $request->input('social_facebook'),
            'tiktok' => $request->input('social_tiktok'),
            'youtube' => $request->input('social_youtube'),
        ], fn ($v) => filled($v));

        $data['social_links'] = $social ?: null;

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        $data['updated_by'] = Auth::guard('admin')->id();

        /*
        |--------------------------------------------------------------------------
        | Logo
        |--------------------------------------------------------------------------
        */

        if ($request->boolean('remove_logo') && $setting->logo) {
            Storage::disk('public')->delete($setting->logo);

            $data['logo'] = null;
        }

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }

            $data['logo'] = $request
                ->file('logo')
                ->store('settings', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Favicon
        |--------------------------------------------------------------------------
        */

        if ($request->boolean('remove_favicon') && $setting->favicon) {
            Storage::disk('public')->delete($setting->favicon);

            $data['favicon'] = null;
        }

        if ($request->hasFile('favicon')) {
            if ($setting->favicon) {
                Storage::disk('public')->delete($setting->favicon);
            }

            $data['favicon'] = $request
                ->file('favicon')
                ->store('settings', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Hero Image
        |--------------------------------------------------------------------------
        */

        if ($request->boolean('remove_hero_image') && $setting->hero_image) {
            Storage::disk('public')->delete($setting->hero_image);

            $data['hero_image'] = null;
        }

        if ($request->hasFile('hero_image')) {
            if ($setting->hero_image) {
                Storage::disk('public')->delete($setting->hero_image);
            }

            $data['hero_image'] = $request
                ->file('hero_image')
                ->store('settings', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | About Image
        |--------------------------------------------------------------------------
        */

        if ($request->boolean('remove_about_image') && $setting->about_image) {
            Storage::disk('public')->delete($setting->about_image);

            $data['about_image'] = null;
        }

        if ($request->hasFile('about_image')) {
            if ($setting->about_image) {
                Storage::disk('public')->delete($setting->about_image);
            }

            $data['about_image'] = $request
                ->file('about_image')
                ->store('settings', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | About Video
        |--------------------------------------------------------------------------
        */

        if ($request->boolean('remove_about_video') && $setting->about_video) {
            Storage::disk('public')->delete($setting->about_video);

            $data['about_video'] = null;
        }

        if ($request->hasFile('about_video')) {
            if ($setting->about_video) {
                Storage::disk('public')->delete($setting->about_video);
            }

            $data['about_video'] = $request
                ->file('about_video')
                ->store('settings/videos', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Parent Company Logo (Corporate Ecosystem)
        |--------------------------------------------------------------------------
        */

        if ($request->boolean('remove_parent_company_logo') && $setting->parent_company_logo) {
            Storage::disk('public')->delete($setting->parent_company_logo);

            $data['parent_company_logo'] = null;
        }

        if ($request->hasFile('parent_company_logo')) {
            if ($setting->parent_company_logo) {
                Storage::disk('public')->delete($setting->parent_company_logo);
            }

            $data['parent_company_logo'] = $request
                ->file('parent_company_logo')
                ->store('settings', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Save
        |--------------------------------------------------------------------------
        */

        $setting->update($data);

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
