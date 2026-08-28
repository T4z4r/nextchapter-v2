<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageVisit extends Model
{
    public const CREATED_AT = null;

    public const UPDATED_AT = null;

    protected $fillable = [
        'path', 'method', 'ip', 'user_agent', 'referer', 'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public static function total(): int
    {
        return static::query()->count();
    }

    public static function todayCount(): int
    {
        return static::query()
            ->where('visited_at', '>=', CarbonImmutable::today())
            ->count();
    }

    public static function uniqueToday(): int
    {
        return static::query()
            ->where('visited_at', '>=', CarbonImmutable::today())
            ->distinct()
            ->count('ip');
    }

    public static function yesterdayCount(): int
    {
        return static::query()
            ->whereBetween('visited_at', [CarbonImmutable::yesterday()->startOfDay(), CarbonImmutable::yesterday()->endOfDay()])
            ->count();
    }

    public static function dailySeries(int $days = 7): array
    {
        $start = CarbonImmutable::today()->subDays($days - 1)->startOfDay();

        $rows = static::query()
            ->where('visited_at', '>=', $start)
            ->selectRaw('DATE(visited_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day');

        $series = [];
        for ($i = 0; $i < $days; $i++) {
            $day = $start->addDays($i);
            $series[$day->toDateString()] = (int) ($rows[$day->toDateString()] ?? 0);
        }

        return $series;
    }

    public static function topPaths(int $limit = 5): array
    {
        return static::query()
            ->where('visited_at', '>=', CarbonImmutable::today()->subDays(30))
            ->select('path')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('path')
            ->orderByDesc('total')
            ->limit($limit)
            ->pluck('total', 'path')
            ->all();
    }

    public static function flushStats(): void
    {
        Cache::forget('visits_total');
        Cache::forget('visits_today');
        Cache::forget('visits_unique_today');
        Cache::forget('visits_series');
    }
}