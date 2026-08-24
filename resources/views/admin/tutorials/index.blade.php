<x-admin-shell title="Tutorials">
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px">
      <h2 style="margin:0">Tutorial library cards</h2>
      <a href="{{ route('admin.tutorials.create') }}" class="btn btn-primary">+ New tutorial</a>
    </div>
    <table class="ad-table">
      <thead><tr><th>#</th><th>Title</th><th>Media</th><th>Duration</th><th>Locked</th><th>Status</th><th style="width:290px"></th></tr></thead>
      <tbody>
        @forelse($items as $item)
          <tr>
            <td>{{ $item->sort }}</td>
            <td><strong>{{ $item->title }}</strong></td>
            <td>
              @if($item->image_path)
                <img src="{{ $item->imageUrl() }}" alt="" style="width:58px;height:34px;object-fit:cover;border-radius:5px;display:block">
              @elseif($item->video_path)
                <span class="badge on">Video</span>
              @else
                <span style="color:#8FA3B0">—</span>
              @endif
            </td>
            <td>{{ $item->duration }}</td>
            <td>{{ $item->is_locked ? 'Yes' : 'No' }}</td>
            <td><span class="badge {{ $item->is_active ? 'on' : 'off' }}">{{ $item->is_active ? 'Live' : 'Hidden' }}</span></td>
            <td style="text-align:right;white-space:nowrap">
              <form method="POST" action="{{ route('admin.tutorials.move', ['id' => $item->id, 'direction' => 'up']) }}" style="display:inline">@csrf<button class="btn-sm btn-ghost">↑</button></form>
              <form method="POST" action="{{ route('admin.tutorials.move', ['id' => $item->id, 'direction' => 'down']) }}" style="display:inline">@csrf<button class="btn-sm btn-ghost">↓</button></form>
              <button type="button" class="btn-sm btn-ghost" data-tp-open="{{ $item->id }}">Preview</button>
              <a href="{{ route('admin.tutorials.edit', $item->id) }}" class="btn-sm btn-ghost">Edit</a>
              <form method="POST" action="{{ route('admin.tutorials.destroy', $item->id) }}" style="display:inline" onsubmit="return confirm('Delete this tutorial?')">@csrf @method('DELETE')<button class="btn-sm btn-danger">Delete</button></form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7">No tutorials yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $items->links() }}

  @foreach($items as $item)
    <template data-tp-source="{{ $item->id }}">
      @include('admin.partials.tutorial-card', [
        'index' => $loop->index + 1,
        'title' => $item->title,
        'description' => $item->description,
        'duration' => $item->duration,
        'locked' => $item->is_locked,
      ])
    </template>
  @endforeach

  <div class="tp-modal" id="tpModal" hidden>
    <div class="tp-backdrop" data-tp-close></div>
    <div class="tp-dialog" role="dialog" aria-modal="true" aria-label="Tutorial preview">
      <div class="tp-head">
        <strong>Public site preview</strong>
        <button type="button" class="btn-sm btn-ghost" data-tp-close>Close</button>
      </div>
      <div class="tp-slot" id="tpSlot"></div>
    </div>
  </div>

  <script>
    (function () {
      var modal = document.getElementById('tpModal');
      var slot = document.getElementById('tpSlot');

      function close() {
        modal.hidden = true;
        slot.innerHTML = '';
        document.removeEventListener('keydown', onKey);
      }

      function onKey(e) {
        if (e.key === 'Escape') close();
      }

      document.querySelectorAll('[data-tp-open]').forEach(function (btn) {
        btn.addEventListener('click', function () {
          var tpl = document.querySelector('template[data-tp-source="' + btn.getAttribute('data-tp-open') + '"]');
          if (!tpl) return;
          slot.innerHTML = '';
          slot.appendChild(tpl.content.cloneNode(true));
          modal.hidden = false;
          document.addEventListener('keydown', onKey);
        });
      });

      modal.querySelectorAll('[data-tp-close]').forEach(function (el) {
        el.addEventListener('click', close);
      });
    })();
  </script>
</x-admin-shell>
