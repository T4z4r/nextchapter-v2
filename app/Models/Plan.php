<?php

namespace App\Models;

class Plan extends SortableContent
{
    protected $fillable = [
        'sort', 'slug', 'tier_label', 'name', 'duration_label',
        'price_ind', 'price_joint', 'sub_ind', 'sub_joint',
        'features', 'badge', 'featured', 'cta_label', 'is_active',
    ];

    protected $casts = [
        'price_ind' => 'float',
        'price_joint' => 'float',
        'featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Each line may carry an optional joint variant: "individual text|joint text".
     *
     * @return list<array{ind: string, joint: string}>
     */
    public function featureList(): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $this->features))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->map(function ($line) {
                [$ind, $joint] = array_pad(explode('|', $line, 2), 2, null);

                return ['ind' => trim($ind), 'joint' => trim($joint ?? $ind)];
            })
            ->values()
            ->all();
    }

    public function priceFor(string $mode): float
    {
        return $mode === 'joint' ? $this->price_joint : $this->price_ind;
    }
}
