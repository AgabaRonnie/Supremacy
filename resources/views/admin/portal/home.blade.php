@extends('layouts.layoutMaster')

@section('title', 'My Dashboard')

@section('content')

@include('admin.partials.flash')

@if (!$artist)
  <div class="alert alert-warning">
    Your account is not linked to an artist profile yet. Contact the label to get set up.
  </div>
@else
  <div class="row g-4 mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
          <div class="d-flex align-items-center gap-3">
            <img src="{{ $artist->photo_url }}" alt="{{ $artist->name }}" class="rounded-circle" style="width:56px;height:56px;object-fit:cover;">
            <div>
              <h5 class="mb-1">Welcome back, {{ $artist->name }} 🎤</h5>
              <p class="mb-0 text-muted">This is your portal — everything you add here goes live on your public page.</p>
            </div>
          </div>
          <div class="d-flex gap-2">
            <a href="{{ url('/' . $artist->slug) }}" target="_blank" class="btn btn-primary">
              <i class="bx bx-link-external me-1"></i> View My Page
            </a>
            <a href="{{ route('admin.portal.profile') }}" class="btn btn-outline-primary">
              <i class="bx bx-edit-alt me-1"></i> Edit Profile
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4 mb-4">
    @foreach ([
      ['My Tracks', $stats['tracks'], 'bx-music', route('admin.tracks.index')],
      ['My Albums', $stats['albums'], 'bx-album', route('admin.albums.index')],
      ['My Merch', $stats['products'], 'bx-shopping-bag', route('admin.products.index')],
      ['My Videos', $stats['videos'], 'bx-video', route('admin.videos.index')],
      ['Upcoming Shows', $stats['upcoming_events'], 'bx-calendar-event', route('admin.events.index')],
    ] as [$label, $count, $icon, $url])
      <div class="col-6 col-md-4 col-xl-2">
        <a href="{{ $url }}" class="card h-100 text-decoration-none">
          <div class="card-body">
            <div class="avatar mb-2">
              <span class="avatar-initial rounded bg-label-primary"><i class="bx {{ $icon }}"></i></span>
            </div>
            <h4 class="mb-0">{{ $count }}</h4>
            <small class="text-muted">{{ $label }}</small>
          </div>
        </a>
      </div>
    @endforeach
  </div>

  <div class="card">
    <div class="card-header"><h5 class="mb-0">Quick Tips</h5></div>
    <div class="card-body">
      <ul class="mb-0">
        <li>Your page link is <a href="{{ url('/' . $artist->slug) }}" target="_blank">{{ url('/' . $artist->slug) }}</a> — share it as your official website.</li>
        <li>Anything marked as dummy content can be edited or deleted — this is your space.</li>
        <li>Add streaming links to every track so fans can play your music in one tap.</li>
        <li>No upcoming shows? Add them under <a href="{{ route('admin.events.index') }}">My Shows</a> as soon as they're confirmed.</li>
      </ul>
    </div>
  </div>
@endif

@endsection
