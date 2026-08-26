<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings', [
            'setting' => Setting::get(),
            'colorDefaults' => Setting::COLOR_DEFAULTS,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:120'],
            'logo_path' => ['nullable', 'string', 'max:300'],
            'footer_logo_path' => ['nullable', 'string', 'max:300'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'contact_email' => ['nullable', 'email', 'max:190'],
            'opening_hours' => ['nullable', 'string', 'max:160'],
            'location' => ['nullable', 'string', 'max:160'],
            'disclaimer_bar_text' => ['nullable', 'string', 'max:4000'],
            'footer_blurb' => ['nullable', 'string', 'max:1000'],
            'copyright_holder' => ['nullable', 'string', 'max:190'],
            'legal_footnote' => ['nullable', 'string', 'max:300'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:2048'],
            'footer_logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,svg', 'max:2048'],
            'remove_logo' => ['nullable', 'boolean'],
            'remove_footer_logo' => ['nullable', 'boolean'],
            'color_primary' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'color_deep' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'color_ink' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'color_accent' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
        ]);

        foreach (['color_primary', 'color_deep', 'color_ink', 'color_accent'] as $key) {
            if (isset($data[$key])) {
                $data[$key] = '#' . strtolower(ltrim($data[$key], '#'));
            }
        }

        $setting = Setting::get();

        foreach (['logo_path' => 'remove_logo', 'footer_logo_path' => 'remove_footer_logo'] as $column => $input) {
            if ($request->boolean($input)) {
                $this->deleteBrandFile($setting->{$column});
                $data[$column] = null;
                unset($data[$input]);
            }
        }

        foreach (['logo' => 'logo_path', 'footer_logo' => 'footer_logo_path'] as $input => $column) {
            if ($request->hasFile($input)) {
                $this->deleteBrandFile($setting->{$column});
                $stored = $request->file($input)->store('brand', 'public');
                $data[$column] = 'storage/' . $stored;
            }
        }

        unset($data['logo'], $data['footer_logo'], $data['remove_logo'], $data['remove_footer_logo']);

        $setting->fill($data)->save();
        Cache::forget('settings');

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Site settings saved.');
    }

    private function deleteBrandFile(?string $path): void
    {
        if ($path && str_starts_with($path, 'storage/')) {
            Storage::disk('public')->delete(substr($path, strlen('storage/')));
        }
    }
}
