<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tutorial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TutorialController extends ContentCrudController
{
    protected function model(): string
    {
        return Tutorial::class;
    }

    protected function viewPrefix(): string
    {
        return 'admin.tutorials';
    }

    protected function labelSingular(): string
    {
        return 'Tutorial';
    }

    protected function rules(Request $request): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:4000'],
            'duration' => ['nullable', 'string', 'max:12'],
            'sort' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'video' => ['nullable', 'file', 'mimes:mp4,webm,ogg,mov', 'max:20480'],
        ];
    }

    protected function booleans(): array
    {
        return ['is_active', 'is_locked'];
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedWithBooleans($request);
        $nextSort = ((int) $this->model()::max('sort')) + 1;
        $data['sort'] = (int) ($data['sort'] ?? $nextSort);

        $data += $this->uploadedMedia($request);

        $this->model()::create($data);

        return redirect()
            ->route($this->afterStoreRedirect())
            ->with('success', $this->labelSingular() . ' created.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        /** @var Tutorial $item */
        $item = $this->model()::findOrFail($id);
        $data = $this->validatedWithBooleans($request);

        foreach (['image_path' => 'remove_image', 'video_path' => 'remove_video'] as $column => $input) {
            if ($request->boolean($input)) {
                $this->deleteMedia($item->{$column});
                $data[$column] = null;
            }
        }

        foreach ($this->uploadedMedia($request) as $column => $path) {
            if (($data[$column] ?? null) === null) {
                $this->deleteMedia($item->{$column});
                $data[$column] = $path;
            }
        }

        $item->update($data);

        return redirect()
            ->route($this->viewPrefix() . '.index')
            ->with('success', $this->labelSingular() . ' updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $item = $this->model()::findOrFail($id);
        $this->deleteMedia($item->image_path);
        $this->deleteMedia($item->video_path);

        return parent::destroy($id);
    }

    /** @return array<string, string> */
    private function uploadedMedia(Request $request): array
    {
        $paths = [];

        foreach (['image' => 'image_path', 'video' => 'video_path'] as $input => $column) {
            if ($request->hasFile($input) && $request->file($input)->isValid()) {
                $paths[$column] = $request->file($input)->store('tutorials', 'public');
            }
        }

        return $paths;
    }

    private function deleteMedia(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
