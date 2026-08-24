<?php

namespace App\Models;

class PlatformFeature extends SortableContent
{
    public const TYPES = ['lead' => 'Lead pillar (USP)', 'feature' => 'Feature pillar', 'pair' => 'Pair card'];
    public const VISUALS = ['none' => 'None', 'scenarios' => 'Split-scenario bars', 'projection' => '15-year projection chart'];

    protected $fillable = [
        'sort', 'type', 'pip', 'tag', 'icon', 'title',
        'description', 'bullets', 'visual', 'kicker', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function bulletList(): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $this->bullets))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
