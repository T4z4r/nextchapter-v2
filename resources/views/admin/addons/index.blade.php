<x-admin-shell title="Add-ons">
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
      <h2 style="margin:0">Entry-level services &amp; add-ons</h2>
      <a href="{{ route('admin.addons.create') }}" class="btn btn-primary">+ New add-on</a>
    </div>
    <table class="ad-table">
      <thead><tr><th>#</th><th>Name</th><th>Price (ind)</th><th>Price (joint)</th><th>Suffix</th><th>Status</th><th style="width:230px"></th></tr></thead>
      <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->sort }}</td>
            <td><strong>{{ $item->name }}</strong></td>
            <td>£{{ number_format($item->price_ind) }}</td>
            <td>{{ is_null($item->price_joint) ? '—' : '£' . number_format($item->price_joint) }}</td>
            <td>{{ $item->price_suffix }}</td>
            <td><span class="badge {{ $item->is_active ? 'on' : 'off' }}">{{ $item->is_active ? 'Live' : 'Hidden' }}</span></td>
            <td style="text-align:right;white-space:nowrap">
              <form method="POST" action="{{ route('admin.addons.move', ['id' => $item->id, 'direction' => 'up']) }}" style="display:inline">@csrf<button class="btn-sm btn-ghost">↑</button></form>
              <form method="POST" action="{{ route('admin.addons.move', ['id' => $item->id, 'direction' => 'down']) }}" style="display:inline">@csrf<button class="btn-sm btn-ghost">↓</button></form>
              <a href="{{ route('admin.addons.edit', $item->id) }}" class="btn-sm btn-ghost">Edit</a>
              <form method="POST" action="{{ route('admin.addons.destroy', $item->id) }}" style="display:inline" onsubmit="return confirm('Delete this add-on?')">@csrf @method('DELETE')<button class="btn-sm btn-danger">Delete</button></form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7">No add-ons yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $items->links() }}
</x-admin-shell>
