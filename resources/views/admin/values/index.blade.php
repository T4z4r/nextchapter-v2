<x-admin-shell title="About values">
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
      <h2 style="margin:0">Value cards in the About section</h2>
      <a href="{{ route('admin.values.create') }}" class="btn btn-primary">+ New value card</a>
    </div>
    <table class="ad-table">
      <thead><tr><th>#</th><th>Title</th><th>Description</th><th>Status</th><th style="width:230px"></th></tr></thead>
      <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->sort }}</td>
            <td><strong>{{ $item->title }}</strong></td>
            <td>{{ \Illuminate\Support\Str::limit($item->description, 70) }}</td>
            <td><span class="badge {{ $item->is_active ? 'on' : 'off' }}">{{ $item->is_active ? 'Live' : 'Hidden' }}</span></td>
            <td style="text-align:right;white-space:nowrap">
              <form method="POST" action="{{ route('admin.values.move', ['id' => $item->id, 'direction' => 'up']) }}" style="display:inline">@csrf<button class="btn-sm btn-ghost">↑</button></form>
              <form method="POST" action="{{ route('admin.values.move', ['id' => $item->id, 'direction' => 'down']) }}" style="display:inline">@csrf<button class="btn-sm btn-ghost">↓</button></form>
              <a href="{{ route('admin.values.edit', $item->id) }}" class="btn-sm btn-ghost">Edit</a>
              <form method="POST" action="{{ route('admin.values.destroy', $item->id) }}" style="display:inline" onsubmit="return confirm('Delete this value card?')">@csrf @method('DELETE')<button class="btn-sm btn-danger">Delete</button></form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5">No value cards yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $items->links() }}
</x-admin-shell>
