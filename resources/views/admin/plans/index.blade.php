<x-admin-shell title="Packages">
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
      <h2 style="margin:0">Pricing packages</h2>
      <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">+ New package</a>
    </div>
    <table class="ad-table">
      <thead><tr><th>#</th><th>Tier</th><th>Name</th><th>Individual</th><th>Joint</th><th>Status</th><th style="width:230px"></th></tr></thead>
      <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->sort }}</td>
            <td>{{ $item->tier_label }}</td>
            <td><strong>{{ $item->name }}</strong> @if($item->featured)<span class="badge feat">{{ $item->badge ?: 'Featured' }}</span>@endif<br><span class="hint" style="color:#5A6B77;font-size:12.5px">/{{ $item->slug }}</span></td>
            <td>£{{ number_format($item->price_ind) }}</td>
            <td>£{{ number_format($item->price_joint) }}</td>
            <td><span class="badge {{ $item->is_active ? 'on' : 'off' }}">{{ $item->is_active ? 'Live' : 'Hidden' }}</span></td>
            <td style="text-align:right;white-space:nowrap">
              <form method="POST" action="{{ route('admin.plans.move', ['id' => $item->id, 'direction' => 'up']) }}" style="display:inline">@csrf<button class="btn-sm btn-ghost">↑</button></form>
              <form method="POST" action="{{ route('admin.plans.move', ['id' => $item->id, 'direction' => 'down']) }}" style="display:inline">@csrf<button class="btn-sm btn-ghost">↓</button></form>
              <a href="{{ route('admin.plans.edit', $item->id) }}" class="btn-sm btn-ghost">Edit</a>
              <form method="POST" action="{{ route('admin.plans.destroy', $item->id) }}" style="display:inline" onsubmit="return confirm('Delete this package?')">@csrf @method('DELETE')<button class="btn-sm btn-danger">Delete</button></form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7">No packages yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $items->links() }}
</x-admin-shell>
