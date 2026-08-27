<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TestMail;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
            'mail_driver' => ['nullable', 'in:smtp,log'],
            'mail_host' => ['nullable', 'string', 'max:190'],
            'mail_port' => ['nullable', 'string', 'max:10'],
            'mail_username' => ['nullable', 'string', 'max:190'],
            'mail_password' => ['nullable', 'string', 'max:300'],
            'mail_encryption' => ['nullable', 'in:tls,ssl,,null'],
            'mail_from_address' => ['nullable', 'email', 'max:190'],
            'mail_from_name' => ['nullable', 'string', 'max:190'],
        ]);

        foreach (['color_primary', 'color_deep', 'color_ink', 'color_accent'] as $key) {
            if (isset($data[$key])) {
                $data[$key] = '#' . strtolower(ltrim($data[$key], '#'));
            }
        }

        $data['mail_driver'] ??= 'smtp';

        if ($request->has('mail_driver') && $data['mail_driver'] === 'smtp' && empty($data['mail_host'])) {
            return back()->withInput()->withErrors([
                'mail_host' => 'An SMTP host is required when sending via SMTP.',
            ]);
        }

        if (($data['mail_encryption'] ?? '') === 'null' || ($data['mail_encryption'] ?? '') === '') {
            $data['mail_encryption'] = null;
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

        if ($request->input('action') === 'test') {
            return $this->sendTestEmail($data);
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Site settings saved.');
    }

    private function sendTestEmail(array $mail): RedirectResponse
    {
        $this->applyMailRuntime($mail);
        $to = Auth::user()->email ?: ($mail['mail_from_address'] ?? null);

        if (! $to) {
            return back()
                ->withInput()
                ->withErrors(['mail_host' => 'Add a from address or use an account email to receive the test.']);
        }

        try {
            Mail::to($to)->send(new TestMail((string) Setting::get()->site_name));

            return back()->with('success', 'Test email sent to ' . $to . '. Check your inbox.');
        } catch (\Throwable $e) {
            Log::warning('Test email failed: ' . $e->getMessage(), ['exception' => $e]);

            return back()
                ->withInput()
                ->withErrors(['mail_host' => 'Could not send: ' . $e->getMessage()]);
        }
    }

    private function applyMailRuntime(array $data): void
    {
        $driver = ($data['mail_driver'] ?? '') === 'smtp' ? 'smtp' : 'log';

        config([
            'mail.default' => $driver,
            'mail.mailers.smtp.host' => $data['mail_host'] ?? null,
            'mail.mailers.smtp.port' => (int) ($data['mail_port'] ?? 587),
            'mail.mailers.smtp.username' => $data['mail_username'] ?? null,
            'mail.mailers.smtp.password' => $data['mail_password'] ?? null,
            'mail.mailers.smtp.encryption' => $data['mail_encryption'] ?? null,
            'mail.from.address' => $data['mail_from_address'] ?? config('mail.from.address'),
            'mail.from.name' => $data['mail_from_name'] ?? Setting::get()->site_name,
        ]);
    }

    private function deleteBrandFile(?string $path): void
    {
        if ($path && str_starts_with($path, 'storage/')) {
            Storage::disk('public')->delete(substr($path, strlen('storage/')));
        }
    }
}
