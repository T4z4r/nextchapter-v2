<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings', [
            'setting' => Setting::get(),
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
        ]);

        Setting::get()->fill($data)->save();
        Cache::forget('settings');

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Site settings saved.');
    }
}
