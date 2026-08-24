<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'site_name', 'logo_path', 'footer_logo_path', 'meta_description',
        'contact_email', 'opening_hours', 'location', 'disclaimer_bar_text',
        'footer_blurb', 'copyright_holder', 'legal_footnote',
    ];

    public static function get(): self
    {
        return Cache::rememberForever('settings', function () {
            return static::query()->firstOrNew();
        });
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings'));
        static::deleted(fn () => Cache::forget('settings'));
    }
}
