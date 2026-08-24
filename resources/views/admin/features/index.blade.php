<x-admin-shell title="Platform features">
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
      <h2 style="margin:0">Cards in the dark “Balance Point platform” band</h2>
      <a href="{{ route('admin.features.create') }}" class="btn btn-primary">+ New feature</a>
    </div>
    <table class="ad-table">
      <thead><tr><th>#</th><th>Type</th><th>Tag</th><th>Title</th><th>Status</th><th style="width:230px"></th></tr></thead>
      <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->sort }}</td>
            <td><span class="badge">{{ ['lead' => 'Lead pillar', 'feature' => 'Feature pillar', 'pair' => 'Pair card'][$item->type] ?? $item->type }}</span></td>
            <td>{{ $item->pip }} {{ $item->tag }}</td>
            <td><strong>{{ \Illuminate\Support\Str::limit($item->title, 46) }}</strong></td>
            <td><span class="badge {{ $item->is_active ? 'on' : 'off' }}">{{ $item->is_active ? 'Live' : 'Hidden' }}</span></td>
            <td style="text-align:right;white-space:nowrap">
              <form method="POST" action="{{ route('admin.features.move', ['id' => $item->id, 'direction' => 'up']) }}" style="display:inline">@csrf<button class="btn-sm btn-ghost">↑</button></form>
              <form method="POST" action="{{ route('admin.features.move', ['id' => $item->id, 'direction' => 'down']) }}" style="display:inline">@csrf<button class="btn-sm btn-ghost">↓</button></form>
              <a href="{{ route('admin.features.edit', $item->id) }}" class="btn-sm btn-ghost">Edit</a>
              <form method="POST" action="{{ route('admin.features.destroy', $item->id) }}" style="display:inline" onsubmit="return confirm('Delete this feature?')">@csrf @method('DELETE')<button class="btn-sm btn-danger">Delete</button></form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6">No features yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $items->links() }}
</x-admin-shell>
