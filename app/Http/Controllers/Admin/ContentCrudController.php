<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

abstract class ContentCrudController extends Controller
{
    abstract protected function model(): string;

    abstract protected function viewPrefix(): string;

    abstract protected function labelSingular(): string;

    /** @return array<string, mixed> */
    abstract protected function rules(Request $request): array;

    /** Field names managed by checkboxes that must default to false when absent. @return list<string> */
    protected function booleans(): array
    {
        return ['is_active'];
    }

    protected function validatedWithBooleans(Request $request): array
    {
        $data = $request->validate($this->rules($request));

        foreach ($this->booleans() as $field) {
            $data[$field] = $request->boolean($field);
        }

        return $data;
    }

    protected function afterStoreRedirect(): string
    {
        return $this->viewPrefix() . '.index';
    }

    public function index(): View
    {
        $items = $this->model()::query()
            ->orderBy('sort')
            ->orderBy('id')
            ->paginate(50);

        return view($this->viewPrefix() . '.index', [
            'items' => $items,
            'label' => $this->labelPlural(),
            'labelSingular' => $this->labelSingular(),
        ]);
    }

    public function create(): View
    {
        $item = new ($this->model());

        return view($this->viewPrefix() . '.form', [
            'item' => $item,
            'label' => $this->labelPlural(),
            'labelSingular' => $this->labelSingular(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedWithBooleans($request);
        $nextSort = ((int) $this->model()::max('sort')) + 1;
        $data['sort'] = (int) ($data['sort'] ?? $nextSort);

        $this->model()::create($data);

        return redirect()
            ->route($this->afterStoreRedirect())
            ->with('success', $this->labelSingular() . ' created.');
    }

    public function edit(int $id): View
    {
        $item = $this->model()::findOrFail($id);

        return view($this->viewPrefix() . '.form', [
            'item' => $item,
            'label' => $this->labelPlural(),
            'labelSingular' => $this->labelSingular(),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $item = $this->model()::findOrFail($id);
        $data = $this->validatedWithBooleans($request);
        $item->update($data);

        return redirect()
            ->route($this->viewPrefix() . '.index')
            ->with('success', $this->labelSingular() . ' updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $item = $this->model()::findOrFail($id);
        $item->delete();

        return back()->with('success', $this->labelSingular() . ' deleted.');
    }

    public function move(int $id, string $direction): RedirectResponse
    {
        $model = $this->model();
        $item = $model::findOrFail($id);

        $swapWith = $model::query()
            ->where('sort', $direction === 'up' ? '<' : '>', $item->sort)
            ->orderBy('sort', $direction === 'up' ? 'desc' : 'asc')
            ->orderBy('id', $direction === 'up' ? 'desc' : 'asc')
            ->first();

        if ($swapWith) {
            [$item->sort, $swapWith->sort] = [$swapWith->sort, $item->sort];
            $item->save();
            $swapWith->save();
        }

        return back()->with('success', $this->labelSingular() . ' moved.');
    }

    protected function labelPlural(): string
    {
        return str($this->labelSingular())->plural()->toString();
    }
}
