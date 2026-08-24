<x-admin-shell title="Section headings & copy">
  <div class="card">
    <h2>Editable page sections</h2>
    <p style="color:#5A6B77">Each section of the homepage has its own heading, subheading, buttons and extra fields. List items (steps, tutorials, packages…) are managed in their own menus.</p>
  </div>
  <div class="card">
    <table class="ad-table">
      <thead><tr><th>Section</th><th>Heading</th><th>Status</th><th style="width:110px"></th></tr></thead>
      <tbody>
        @foreach($sections as $section)
          <tr>
            <td><strong>{{ $section->name }}</strong><br><span class="badge">{{ $section->key }}</span></td>
            <td>{{ \Illuminate\Support\Str::limit(strip_tags(str_replace("\n", ' ', (string) ($section->heading ?? ''))), 70) }}</td>
            <td><span class="badge {{ $section->is_active ? 'on' : 'off' }}">{{ $section->is_active ? 'Active' : 'Inactive' }}</span></td>
            <td style="text-align:right"><a href="{{ route('admin.sections.edit', $section) }}" class="btn-sm btn-ghost">Edit</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</x-admin-shell>
