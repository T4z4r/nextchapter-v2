<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Faq;
use App\Models\Plan;
use App\Models\PlatformFeature;
use App\Models\Section;
use App\Models\Setting;
use App\Models\Step;
use App\Models\Tutorial;
use App\Models\Value;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class ContentRepository
{
    public function __construct(protected CacheRepository $cache)
    {
    }

    public function homeData(): array
    {
        return [
            'settings' => Setting::get(),
            'header' => Section::findKey('header'),
            'hero' => Section::findKey('hero'),
            'howSection' => Section::findKey('how-it-works'),
            'steps' => Step::active(),
            'platform' => Section::findKey('platform'),
            'features' => PlatformFeature::active(),
            'demo' => Section::findKey('demo'),
            'tutorials' => Tutorial::active(),
            'pricing' => Section::findKey('pricing'),
            'plans' => Plan::active(),
            'addons' => Addon::active(),
            'professionals' => Section::findKey('professionals'),
            'about' => Section::findKey('about'),
            'values' => Value::active(),
            'faqSection' => Section::findKey('faq'),
            'faqs' => Faq::active(),
            'contact' => Section::findKey('contact'),
            'footer' => Section::findKey('footer'),
        ];
    }
}
