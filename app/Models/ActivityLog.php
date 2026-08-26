<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'action', 'description', 'subject_type', 'subject_id', 'ip',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $action, string $description, ?Model $subject = null): ?self
    {
        if ($subject instanceof self || request() === null) {
            return null;
        }

        try {
            return static::create([
                'user_id' => auth()->id(),
                'action' => $action,
                'description' => $description,
                'subject_type' => $subject ? class_basename($subject) : null,
                'subject_id' => $subject?->getKey(),
                'ip' => request()?->ip(),
            ]);
        } catch (\Throwable) {
            return null;
        }
    }

    public function verbGroup(): string
    {
        return match (true) {
            str_contains($this->action, 'created') || str_contains($this->action, 'login') => 'created',
            str_contains($this->action, 'deleted') || str_contains($this->action, 'logout') => 'deleted',
            str_contains($this->action, 'updated') || str_contains($this->action, 'media') => 'updated',
            default => 'other',
        };
    }

    public function ago(): string
    {
        return $this->created_at?->diffForHumans(short: true) ?? '';
    }
}
