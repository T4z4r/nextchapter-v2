<?php

namespace App\Models;

class Addon extends SortableContent
{
    protected $fillable = [
        'sort', 'name', 'description',
        'price_ind', 'price_joint', 'price_suffix', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function hasJointVariant(): bool
    {
        return ! is_null($this->price_joint) && (float) $this->price_joint !== (float) $this->price_ind;
    }

    public function formattedInd(): string
    {
        return number_format((float) $this->price_ind, 0);
    }

    public function formattedJoint(): string
    {
        return number_format((float) $this->price_joint, 0);
    }
}
