<?php

namespace App\Models;

class Tutorial extends SortableContent
{
    protected $fillable = [
        'sort', 'title', 'description', 'duration', 'image_path', 'video_path', 'is_locked', 'is_active',
    ];

    protected $casts = ['is_locked' => 'boolean', 'is_active' => 'boolean'];

    public function imageUrl(): ?string
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }

    public function videoUrl(): ?string
    {
        return $this->video_path ? asset('storage/' . $this->video_path) : null;
    }
}
