<?php

namespace App\Models;

class Value extends SortableContent
{
    protected $fillable = ['sort', 'icon', 'title', 'description', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
