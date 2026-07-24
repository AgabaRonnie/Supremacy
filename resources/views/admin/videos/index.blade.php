@extends('layouts.layoutMaster')

@section('title', 'Videos')

@section('content')

@include('admin.partials.flash')

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Videos</h5>
    <a href="{{ route('admin.videos.create') }}" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add Video</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Video</th>
          <th>Artist</th>
          <th>YouTube</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($videos as $video)
          <tr>
            <td>
              <div class="d-flex align-items-center gap-3">
                @if ($video->thumbnail_url)
                  <img src="{{ $video->thumbnail_url }}" alt="" class="rounded" style="width:56px;height:32px;object-fit:cover;">
                @endif
                <strong>{{ $video->title }}</strong>
              </div>
            </td>
            <td>{{ $video->artist->name ?? 'Label' }}</td>
            <td><a href="{{ $video->youtube_url }}" target="_blank" rel="noopener">Open <i class="bx bx-link-external"></i></a></td>
            <td>
              <span class="badge bg-label-{{ $video->is_published ? 'success' : 'secondary' }}">{{ $video->is_published ? 'Published' : 'Hidden' }}</span>
            </td>
            <td>
              <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bx bx-edit-alt"></i></a>
              <form action="{{ route('admin.videos.destroy', $video) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete {{ $video->title }}?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bx bx-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center py-4">No videos yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
