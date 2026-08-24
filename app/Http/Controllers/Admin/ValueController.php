<?php

namespace App\Http\Controllers\Admin;

use App\Models\Value;
use Illuminate\Http\Request;

class ValueController extends ContentCrudController
{
    protected function model(): string
    {
        return Value::class;
    }

    protected function viewPrefix(): string
    {
        return 'admin.values';
    }

    protected function labelSingular(): string
    {
        return 'Value card';
    }

    protected function rules(Request $request): array
    {
        return [
            'icon' => ['nullable', 'in:,database,document,shield,scales,clock,chart,check'],
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'max:2000'],
            'sort' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
