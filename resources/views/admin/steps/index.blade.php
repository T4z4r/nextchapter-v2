<x-admin-shell title="How-it-works steps">
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
      <h2 style="margin:0">Steps shown in the “How it works” grid</h2>
      <a href="{{ route('admin.steps.create') }}" class="btn btn-primary">+ New step</a>
    </div>
    <table class="ad-table">
      <thead><tr><th>#</th><th>Label</th><th>Title</th><th>Style</th><th>Status</th><th style="width:230px"></th></tr></thead>
      <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->sort }}</td>
            <td><span class="badge">{{ $item->num_label }}</span></td>
            <td><strong>{{ $item->title }}</strong></td>
            <td>{{ $item->isHighlight() ? 'Highlighted' : 'Normal' }}</td>
            <td><span class="badge {{ $item->is_active ? 'on' : 'off' }}">{{ $item->is_active ? 'Live' : 'Hidden' }}</span></td>
            <td style="text-align:right;white-space:nowrap">
              <form method="POST" action="{{ route('admin.steps.move', ['id' => $item->id, 'direction' => 'up']) }}" style="display:inline">@csrf<button class="btn-sm btn-ghost" title="Move up">↑</button></form>
              <form method="POST" action="{{ route('admin.steps.move', ['id' => $item->id, 'direction' => 'down']) }}" style="display:inline">@csrf<button class="btn-sm btn-ghost" title="Move down">↓</button></form>
              <a href="{{ route('admin.steps.edit', $item->id) }}" class="btn-sm btn-ghost">Edit</a>
              <form method="POST" action="{{ route('admin.steps.destroy', $item->id) }}" style="display:inline" onsubmit="return confirm('Delete this step?')">@csrf @method('DELETE')<button class="btn-sm btn-danger">Delete</button></form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6">No steps yet — create the first one.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $items->links() }}
</x-admin-shell>
