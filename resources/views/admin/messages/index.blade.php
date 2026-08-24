<x-admin-shell title="Enquiries & checkout intents">
  <div class="card">
    <table class="ad-table">
      <thead><tr><th>Received</th><th>Type</th><th>From</th><th>Interest</th><th>Status</th><th style="width:130px"></th></tr></thead>
      <tbody>
        @forelse($messages as $message)
          <tr>
            <td>{{ $message->created_at->format('d M Y, H:i') }}</td>
            <td><span class="badge {{ $message->type === 'checkout' ? 'feat' : '' }}">{{ $message->type }}</span></td>
            <td><strong>{{ $message->name ?: '—' }}</strong><br><span style="color:#5A6B77;font-size:13px">{{ $message->email }}</span></td>
            <td>{{ $message->package_interest ?: '—' }}<br><span style="color:#5A6B77;font-size:12.5px">{{ $message->billing_mode }}</span></td>
            <td><span class="badge {{ $message->is_read ? 'on' : 'off' }}">{{ $message->is_read ? 'Read' : 'Unread' }}</span></td>
            <td style="text-align:right"><a href="{{ route('admin.messages.show', $message) }}" class="btn-sm btn-ghost">Open</a></td>
          </tr>
        @empty
          <tr><td colspan="6">No messages yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $messages->links() }}
</x-admin-shell>
