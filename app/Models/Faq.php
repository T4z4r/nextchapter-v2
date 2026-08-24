<?php

namespace App\Models;

class Faq extends SortableContent
{
    protected $fillable = ['sort', 'question', 'answer', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
