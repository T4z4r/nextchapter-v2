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
        'color_primary', 'color_deep', 'color_ink', 'color_accent',
    ];

    public const COLOR_DEFAULTS = [
        'color_primary' => '#459EDF',
        'color_deep' => '#2C7CB8',
        'color_ink' => '#17242E',
        'color_accent' => '#58CBDD',
    ];

    public static function get(): self
    {
        return Cache::rememberForever('settings', function () {
            return static::query()->firstOrNew();
        });
    }

    public function palette(): string
    {
        $map = [
            '--honey' => $this->color_primary,
            '--brand-blue' => $this->color_primary,
            '--honey-deep' => $this->color_deep,
            '--pine' => $this->color_deep,
            '--ink' => $this->color_ink,
            '--brand-cyan' => $this->color_accent,
        ];

        $rules = [];
        foreach ($map as $var => $value) {
            if ($value) {
                $rules[] = "{$var}:{$value}";
            }
        }

        return $rules ? ':root{' . implode(';', $rules) . '}' : '';
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings'));
        static::deleted(fn () => Cache::forget('settings'));
    }
}
