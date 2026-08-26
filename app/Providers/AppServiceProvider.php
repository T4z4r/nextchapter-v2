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
}
