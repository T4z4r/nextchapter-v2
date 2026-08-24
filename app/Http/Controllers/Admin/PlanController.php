<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends ContentCrudController
{
    protected function model(): string
    {
        return Plan::class;
    }

    protected function viewPrefix(): string
    {
        return 'admin.plans';
    }

    protected function labelSingular(): string
    {
        return 'Package';
    }

    protected function rules(Request $request): array
    {
        $slugRule = 'required|alpha_dash|max:80';
        if ($request->isMethod('post')) {
            $slugRule .= '|unique:plans,slug';
        } else {
            $slugRule .= '|unique:plans,slug,' . $request->route('plan');
        }

        return [
            'slug' => ['required', 'alpha_dash', 'max:80'],
            'tier_label' => ['required', 'string', 'max:80'],
            'name' => ['required', 'string', 'max:160'],
            'duration_label' => ['nullable', 'string', 'max:80'],
            'price_ind' => ['required', 'numeric', 'min:0', 'max:9999999'],
            'price_joint' => ['required', 'numeric', 'min:0', 'max:9999999'],
            'sub_ind' => ['nullable', 'string', 'max:400'],
            'sub_joint' => ['nullable', 'string', 'max:400'],
            'features' => ['nullable', 'string', 'max:4000'],
            'badge' => ['nullable', 'string', 'max:60'],
            'cta_label' => ['required', 'string', 'max:80'],
            'sort' => ['nullable', 'integer', 'min:0'],
        ];
    }

    protected function booleans(): array
    {
        return ['is_active', 'featured'];
    }
}
