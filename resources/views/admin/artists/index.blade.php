@extends('layouts.layoutMaster')

@section('title', 'Artists')

@section('content')

@if (session('success'))
  <div class="alert alert-success alert-dismissible" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Artists</h5>
    <a href="{{ route('admin.artists.create') }}" class="btn btn-primary">
      <i class="bx bx-plus me-1"></i> Add Artist
    </a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Artist</th>
          <th>Genre</th>
          <th>Music</th>
          <th>Merch</th>
          <th>Events</th>
          <th>Status</th>
          <th>Public Page</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($artists as $artist)
          <tr>
            <td>{{ $artist->sort_order }}</td>
            <td>
              <div class="d-flex align-items-center">
                <div class="avatar me-3">
                  <img src="{{ $artist->photo_url }}" alt="{{ $artist->name }}" class="rounded-circle" style="width:38px;height:38px;object-fit:cover;">
                </div>
                <div>
                  <strong>{{ $artist->name }}</strong>
                  <div class="text-muted small">/{{ $artist->slug }}</div>
                </div>
              </div>
            </td>
            <td>{{ $artist->genre }}</td>
            <td>{{ $artist->tracks_count }} tracks / {{ $artist->albums_count }} albums</td>
            <td>{{ $artist->products_count }}</td>
            <td>{{ $artist->events_count }}</td>
            <td>
              @if ($artist->is_published)
                <span class="badge bg-label-success">Published</span>
              @else
                <span class="badge bg-label-secondary">Hidden</span>
              @endif
            </td>
            <td>
              <a href="{{ url('/' . $artist->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                <i class="bx bx-link-external me-1"></i> View
              </a>
            </td>
            <td>
              <a href="{{ route('admin.artists.edit', $artist) }}" class="btn btn-sm btn-outline-primary me-1">
                <i class="bx bx-edit-alt"></i>
              </a>
              <form action="{{ route('admin.artists.destroy', $artist) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete {{ $artist->name }}? This removes all their music, merch and events.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bx bx-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9" class="text-center py-4">No artists yet. Add the first one.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
