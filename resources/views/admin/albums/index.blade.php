@extends('layouts.layoutMaster')

@section('title', 'Albums')

@section('content')

@include('admin.partials.flash')

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Albums</h5>
    <a href="{{ route('admin.albums.create') }}" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add Album</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Album</th>
          <th>Artist</th>
          <th>Released</th>
          <th>Tracks</th>
          <th>Price</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($albums as $album)
          <tr>
            <td>
              <div class="d-flex align-items-center gap-3">
                <img src="{{ $album->cover_url }}" alt="" class="rounded" style="width:40px;height:40px;object-fit:cover;">
                <strong>{{ $album->title }}</strong>
              </div>
            </td>
            <td>{{ $album->artist->name }}</td>
            <td>{{ optional($album->release_date)->format('d M Y') ?: '—' }}</td>
            <td>{{ $album->tracks_count }}</td>
            <td>{{ $album->price ? 'UGX ' . number_format($album->price) : '—' }}</td>
            <td>
              <span class="badge bg-label-{{ $album->is_published ? 'success' : 'secondary' }}">{{ $album->is_published ? 'Published' : 'Hidden' }}</span>
            </td>
            <td>
              <a href="{{ route('admin.albums.edit', $album) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bx bx-edit-alt"></i></a>
              <form action="{{ route('admin.albums.destroy', $album) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete {{ $album->title }}? Its tracks become singles.');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bx bx-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center py-4">No albums yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
