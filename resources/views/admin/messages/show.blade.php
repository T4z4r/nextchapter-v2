<x-admin-shell title="Message from {{ $message->name ?: $message->email ?: '#' . $message->id }}">
  <div class="card">
    <p style="margin:0 0 6px"><span class="badge {{ $message->type === 'checkout' ? 'feat' : '' }}">{{ $message->type }}</span>
       <span class="badge">{{ $message->billing_mode ?: 'n/a' }}</span>
       <span class="badge {{ $message->is_read ? 'on' : 'off' }}">{{ $message->is_read ? 'Read' : 'Unread (now marked)' }}</span></p>
    <p style="margin:12px 0 4px;color:#5A6B77;font-size:13.5px">Received {{ $message->created_at->format('l d F Y, H:i') }}</p>
    <table class="ad-table" style="margin-bottom:18px">
      <tbody>
        <tr><td style="width:140px;color:#5A6B77">Name</td><td>{{ $message->name ?: '—' }}</td></tr>
        <tr><td style="color:#5A6B77">Email</td><td>@if($message->email)<a href="mailto:{{ $message->email }}">{{ $message->email }}</a>@else — @endif</td></tr>
        <tr><td style="color:#5A6B77">Phone</td><td>{{ $message->phone ?: '—' }}</td></tr>
        <tr><td style="color:#5A6B77">Interested in</td><td>{{ $message->package_interest ?: '—' }}</td></tr>
      </tbody>
    </table>
    <div class="msg-body">{{ $message->message }}</div>
    <div style="display:flex;gap:10px;margin-top:18px">
      @if($message->email)
        <a href="mailto:{{ $message->email }}?subject=Re: your Next Chapter enquiry" class="btn btn-primary">Reply by email</a>
      @endif
      <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger">Delete</button>
      </form>
      <a href="{{ route('admin.messages.index') }}" class="btn btn-ghost">← All messages</a>
    </div>
  </div>
</x-admin-shell>
