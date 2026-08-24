<?php

namespace App\Http\Controllers\Admin;

use App\Models\Addon;
use Illuminate\Http\Request;

class AddonController extends ContentCrudController
{
    protected function model(): string
    {
        return Addon::class;
    }

    protected function viewPrefix(): string
    {
        return 'admin.addons';
    }

    protected function labelSingular(): string
    {
        return 'Add-on';
    }

    protected function rules(Request $request): array
    {
        return [
            'name' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'max:6000'],
            'price_ind' => ['required', 'numeric', 'min:0', 'max:9999999'],
            'price_joint' => ['nullable', 'numeric', 'min:0', 'max:9999999'],
            'price_suffix' => ['nullable', 'string', 'max:80'],
            'sort' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
