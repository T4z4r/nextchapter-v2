<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SectionController extends Controller
{
    public function index(): View
    {
        return view('admin.sections.index', [
            'sections' => Section::query()->orderBy('name')->get(),
        ]);
    }

    public function edit(Section $section): View
    {
        return view('admin.sections.form', ['section' => $section]);
    }

    public function update(Request $request, Section $section): RedirectResponse
    {
        $rules = [
            'eyebrow' => ['nullable', 'string', 'max:160'],
            'heading' => ['nullable', 'string', 'max:500'],
            'subheading' => ['nullable', 'string', 'max:2000'],
            'body' => ['nullable', 'string', 'max:8000'],
            'cta1_label' => ['nullable', 'string', 'max:80'],
            'cta1_url' => ['nullable', 'string', 'max:300'],
            'cta2_label' => ['nullable', 'string', 'max:80'],
            'cta2_url' => ['nullable', 'string', 'max:300'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'data_json' => ['nullable', 'json'],
        ];

        $data = $request->validate($rules);

        if (array_key_exists('data_json', $data)) {
            $decoded = json_decode($data['data_json'], true);
            $data['data'] = $decoded === [] && ! is_array($decoded) ? null : ($decoded ?: null);
            unset($data['data_json']);
        }

        $section->update($data);

        return redirect()
            ->route('admin.sections.edit', $section)
            ->with('success', "Section \"{$section->name}\" updated.");
    }
}
