@extends('layouts.layoutMaster')

@section('title', 'Demo Submissions')

@section('content')

@include('admin.partials.flash')

<div class="card">
  <div class="card-header"><h5 class="mb-0">Demo Submissions</h5></div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Artist</th>
          <th>Contact</th>
          <th>Genre</th>
          <th>Music Links</th>
          <th>Message</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($demos as $demo)
          <tr>
            <td>
              <strong>{{ $demo->artist_name ?: $demo->name }}</strong><br>
              <small class="text-muted">{{ $demo->name }} · {{ $demo->created_at->diffForHumans() }}</small>
            </td>
            <td>{{ $demo->phone }}<br><small class="text-muted">{{ $demo->email }}</small></td>
            <td>{{ $demo->genre }}</td>
            <td style="white-space: normal; max-width: 220px;">
              @foreach (preg_split('/\r\n|\r|\n/', (string) $demo->links) as $link)
                @if (trim($link))
                  <a href="{{ Str::startsWith(trim($link), 'http') ? trim($link) : 'https://' . trim($link) }}" target="_blank" rel="noopener" class="d-block small text-truncate">{{ trim($link) }}</a>
                @endif
              @endforeach
            </td>
            <td style="white-space: normal; max-width: 200px;"><small>{{ Str::limit($demo->message, 80) }}</small></td>
            <td>
              <span class="badge bg-label-{{ ['new' => 'danger', 'reviewed' => 'warning', 'contacted' => 'success'][$demo->status] ?? 'secondary' }}">{{ ucfirst($demo->status) }}</span>
            </td>
            <td>
              @if ($demo->status !== 'reviewed')
                <form action="{{ route('admin.demos.status', $demo) }}" method="POST" class="d-inline">
                  @csrf @method('PUT')
                  <input type="hidden" name="status" value="reviewed">
                  <button type="submit" class="btn btn-sm btn-outline-warning me-1" title="Mark reviewed"><i class="bx bx-show"></i></button>
                </form>
              @endif
              @if ($demo->status !== 'contacted')
                <form action="{{ route('admin.demos.status', $demo) }}" method="POST" class="d-inline">
                  @csrf @method('PUT')
                  <input type="hidden" name="status" value="contacted">
                  <button type="submit" class="btn btn-sm btn-outline-success me-1" title="Mark contacted"><i class="bx bx-phone-call"></i></button>
                </form>
              @endif
              <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $demo->phone) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary me-1" title="WhatsApp"><i class="bx bxl-whatsapp"></i></a>
              <form action="{{ route('admin.demos.destroy', $demo) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Remove this submission?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bx bx-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center py-4">No demo submissions yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
