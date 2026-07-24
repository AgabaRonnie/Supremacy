@extends('layouts.layoutMaster')

@section('title', 'Tracks')

@section('content')

@include('admin.partials.flash')

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Tracks</h5>
    <a href="{{ route('admin.tracks.create') }}" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add Track</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Track</th>
          <th>Artist</th>
          <th>Album</th>
          <th>Released</th>
          <th>Price</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($tracks as $track)
          <tr>
            <td><strong>{{ $track->title }}</strong></td>
            <td>{{ $track->artist->name }}</td>
            <td>{{ $track->album->title ?? 'Single' }}</td>
            <td>{{ optional($track->release_date)->format('d M Y') ?: '—' }}</td>
            <td>
              @if ($track->is_free)
                <span class="badge bg-label-success">Free</span>
              @else
                {{ $track->price ? 'UGX ' . number_format($track->price) : '—' }}
              @endif
            </td>
            <td>
              <span class="badge bg-label-{{ $track->is_published ? 'success' : 'secondary' }}">{{ $track->is_published ? 'Published' : 'Hidden' }}</span>
            </td>
            <td>
              <a href="{{ route('admin.tracks.edit', $track) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bx bx-edit-alt"></i></a>
              <form action="{{ route('admin.tracks.destroy', $track) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete {{ $track->title }}?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bx bx-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center py-4">No tracks yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
