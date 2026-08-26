<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Model;
use App\Models\Setting;

class ContentObserver
{
    public function created(Model $model): void
    {
        ActivityLog::record(
            strtolower(class_basename($model)) . '.created',
            'Created ' . $this->type($model) . ': ' . $this->label($model),
            $model
        );
    }

    public function updated(Model $model): void
    {
        if ($model instanceof Setting && ! $model->wasRecentlyCreated && ! $model->isDirty()) {
            return;
        }

        ActivityLog::record(
            strtolower(class_basename($model)) . '.updated',
            'Updated ' . $this->type($model) . ': ' . $this->label($model),
            $model
        );
    }

    public function deleted(Model $model): void
    {
        ActivityLog::record(
            strtolower(class_basename($model)) . '.deleted',
            'Deleted ' . $this->type($model) . ': ' . $this->label($model),
            $model
        );
    }

    private function type(Model $model): string
    {
        return match (class_basename($model)) {
            'Faq' => 'FAQ',
            'Plan' => 'package',
            'ContactMessage' => match ($model->type ?? '') {
                'checkout_intent' => 'checkout intent',
                default => 'enquiry',
            },
            default => strtolower(trim(preg_replace('/([A-Z])/', ' $1', class_basename($model)))),
        };
    }

    private function label(Model $model): string
    {
        foreach (['name', 'title', 'heading', 'key', 'email'] as $attr) {
            if (isset($model->{$attr}) && filled($model->{$attr})) {
                return str($model->{$attr})->limit(60);
            }
        }

        if ($model instanceof Setting) {
            return 'site settings';
        }

        return '#' . $model->getKey();
    }
}
