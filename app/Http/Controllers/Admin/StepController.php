<?php

namespace App\Http\Controllers\Admin;

use App\Models\Step;
use Illuminate\Http\Request;

class StepController extends ContentCrudController
{
    protected function model(): string
    {
        return Step::class;
    }

    protected function viewPrefix(): string
    {
        return 'admin.steps';
    }

    protected function labelSingular(): string
    {
        return 'Step';
    }

    protected function rules(Request $request): array
    {
        return [
            'num_label' => ['required', 'string', 'max:60'],
            'title' => ['required', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:6000'],
            'bullets' => ['nullable', 'string', 'max:3000'],
            'footnote' => ['nullable', 'string', 'max:600'],
            'style' => ['nullable', 'in:normal,highlight'],
            'sort' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
