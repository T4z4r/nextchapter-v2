<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends ContentCrudController
{
    protected function model(): string
    {
        return Faq::class;
    }

    protected function viewPrefix(): string
    {
        return 'admin.faqs';
    }

    protected function labelSingular(): string
    {
        return 'FAQ';
    }

    protected function rules(Request $request): array
    {
        return [
            'question' => ['required', 'string', 'max:300'],
            'answer' => ['required', 'string', 'max:8000'],
            'sort' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
