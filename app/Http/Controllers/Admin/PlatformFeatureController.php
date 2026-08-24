<?php

namespace App\Http\Controllers\Admin;

use App\Models\PlatformFeature;
use Illuminate\Http\Request;

class PlatformFeatureController extends ContentCrudController
{
    protected function model(): string
    {
        return PlatformFeature::class;
    }

    protected function viewPrefix(): string
    {
        return 'admin.features';
    }

    protected function labelSingular(): string
    {
        return 'Platform feature';
    }

    protected function rules(Request $request): array
    {
        return [
            'type' => ['required', 'in:lead,feature,pair'],
            'pip' => ['nullable', 'string', 'max:60'],
            'tag' => ['nullable', 'string', 'max:120'],
            'icon' => ['nullable', 'in:,database,document,shield,scales,clock,chart,check'],
            'title' => ['required', 'string', 'max:250'],
            'description' => ['nullable', 'string', 'max:6000'],
            'bullets' => ['nullable', 'string', 'max:3000'],
            'visual' => ['nullable', 'in:none,scenarios,projection'],
            'kicker' => ['nullable', 'string', 'max:200'],
            'sort' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
