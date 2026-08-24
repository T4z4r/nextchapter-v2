<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

abstract class SortableContent extends Model
{
    protected static function booted(): void
    {
        $model = static::class;

        static::saved(function () use ($model) {
            Cache::forget("site.{$model}");
        });
        static::deleted(function () use ($model) {
            Cache::forget("site.{$model}");
        });
    }

    public static function active()
    {
        return Cache::rememberForever(
            'site.' . static::class,
            fn () => static::query()
                ->where('is_active', true)
                ->orderBy('sort')
                ->orderBy('id')
                ->get()
        );
    }
}
