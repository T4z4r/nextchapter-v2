<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Section extends Model
{
    protected $fillable = [
        'key', 'name', 'eyebrow', 'heading', 'subheading', 'body',
        'cta1_label', 'cta1_url', 'cta2_label', 'cta2_url',
        'video_url', 'data', 'is_active',
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
    ];

    public static function findKey(string $key): ?self
    {
        return Cache::rememberForever(
            "site.section.{$key}",
            fn () => static::query()->where('key', $key)->first()
        );
    }

    public function data(string $field, mixed $default = null): mixed
    {
        return data_get($this->data, $field, $default);
    }

    protected static function booted(): void
    {
        static::saved(fn (self $s) => Cache::forget("site.section.{$s->key}"));
        static::deleted(fn (self $s) => Cache::forget("site.section.{$s->key}"));
    }
}
