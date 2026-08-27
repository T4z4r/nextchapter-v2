<?php

namespace App\Providers;

use App\Models\Addon;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\Plan;
use App\Models\PlatformFeature;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Step;
use App\Models\Tutorial;
use App\Models\Value;
use App\Observers\ContentObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::defaultView('vendor.pagination.admin');

        $this->applyMailConfig();

        foreach ([
            Addon::class,
            ContactMessage::class,
            Faq::class,
            Plan::class,
            PlatformFeature::class,
            Section::class,
            Setting::class,
            Step::class,
            Tutorial::class,
            Value::class,
        ] as $model) {
            $model::observe(ContentObserver::class);
        }
    }

    private function applyMailConfig(): void
    {
        try {
            $setting = Setting::get();

            if ($setting->mailConfigured()) {
                $driver = $setting->mail_driver === 'smtp' ? 'smtp' : 'log';

                $this->app['config']->set([
                    'mail.default' => $driver,
                    'mail.mailers.smtp.host' => $setting->mail_host,
                    'mail.mailers.smtp.port' => (int) $setting->mail_port,
                    'mail.mailers.smtp.username' => $setting->mail_username,
                    'mail.mailers.smtp.password' => $setting->mail_password,
                    'mail.mailers.smtp.encryption' => $setting->mail_encryption,
                ]);

                if ($setting->mail_from_address) {
                    $this->app['config']->set([
                        'mail.from.address' => $setting->mail_from_address,
                        'mail.from.name' => $setting->mail_from_name ?: (string) $setting->site_name,
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // Settings table not available yet (pre-migration) — keep .env defaults.
        }
    }
}
