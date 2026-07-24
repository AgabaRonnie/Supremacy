@extends('layouts.layoutMaster')

@section('title', 'Dashboard')

@section('content')

@include('admin.partials.flash')

<div class="row g-4 mb-4">
  <div class="col-12">
    <div class="card">
      <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
          <h5 class="card-title text-primary mb-1">Welcome to Supremacy Studios Admin 🎧</h5>
          <p class="mb-0">Manage artists, music, events, bookings and everything Supremacy Studios from here.</p>
        </div>
        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-primary">
          <i class="bx bx-link-external me-1"></i> View Website
        </a>
      </div>
    </div>
  </div>
</div>

<div class="row g-4 mb-4">
  @foreach ([
    ['Artists', $stats['artists'], 'bx-microphone', route('admin.artists.index')],
    ['Tracks', $stats['tracks'], 'bx-music', route('admin.tracks.index')],
    ['Albums', $stats['albums'], 'bx-album', route('admin.albums.index')],
    ['Merch Items', $stats['products'], 'bx-shopping-bag', route('admin.products.index')],
    ['Upcoming Events', $stats['upcoming_events'], 'bx-calendar-event', route('admin.events.index')],
    ['Pending Bookings', $stats['pending_bookings'], 'bx-calendar-check', route('admin.bookings.index')],
    ['New Demos', $stats['new_demos'], 'bx-envelope', route('admin.demos.index')],
  ] as [$label, $count, $icon, $url])
    <div class="col-6 col-md-4 col-xl-3">
      <a href="{{ $url }}" class="card h-100 text-decoration-none">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3">
            <div class="avatar">
              <span class="avatar-initial rounded bg-label-primary"><i class="bx {{ $icon }}"></i></span>
            </div>
            <div>
              <h4 class="mb-0">{{ $count }}</h4>
              <small class="text-muted">{{ $label }}</small>
            </div>
          </div>
        </div>
      </a>
    </div>
  @endforeach
</div>

<div class="row g-4">
  <div class="col-lg-6">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Latest Studio Bookings</h5>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-primary">All Bookings</a>
      </div>
      <div class="table-responsive">
        <table class="table table-sm">
          <tbody>
            @forelse ($recentBookings as $b)
              <tr>
                <td><strong>{{ $b->name }}</strong><br><small class="text-muted">{{ $b->phone }}</small></td>
                <td>{{ $b->preferred_date->format('d M Y') }}<br><small class="text-muted">{{ $b->session_type }}</small></td>
                <td><span class="badge bg-label-{{ ['pending' => 'warning', 'confirmed' => 'success', 'declined' => 'secondary'][$b->status] ?? 'secondary' }}">{{ ucfirst($b->status) }}</span></td>
              </tr>
            @empty
              <tr><td class="text-center text-muted py-4">No bookings yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card h-100">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Latest Demo Submissions</h5>
        <a href="{{ route('admin.demos.index') }}" class="btn btn-sm btn-outline-primary">All Demos</a>
      </div>
      <div class="table-responsive">
        <table class="table table-sm">
          <tbody>
            @forelse ($recentDemos as $d)
              <tr>
                <td><strong>{{ $d->artist_name ?: $d->name }}</strong><br><small class="text-muted">{{ $d->genre }}</small></td>
                <td>{{ $d->created_at->diffForHumans() }}</td>
                <td><span class="badge bg-label-{{ ['new' => 'danger', 'reviewed' => 'warning', 'contacted' => 'success'][$d->status] ?? 'secondary' }}">{{ ucfirst($d->status) }}</span></td>
              </tr>
            @empty
              <tr><td class="text-center text-muted py-4">No demo submissions yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
