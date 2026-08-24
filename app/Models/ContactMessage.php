<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'type', 'name', 'email', 'phone',
        'package_interest', 'billing_mode', 'message', 'is_read',
    ];

    protected $casts = ['is_read' => 'boolean'];
}
