<?php

namespace App\Models;

class Step extends SortableContent
{
    protected $fillable = [
        'sort', 'num_label', 'title', 'description',
        'bullets', 'footnote', 'style', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function isHighlight(): bool
    {
        return $this->style === 'highlight';
    }
}
