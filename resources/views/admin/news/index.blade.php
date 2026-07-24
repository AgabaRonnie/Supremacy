@extends('layouts.layoutMaster')

@section('title', 'News')

@section('content')

@include('admin.partials.flash')

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">News</h5>
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add Story</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Story</th>
          <th>Published</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($posts as $post)
          <tr>
            <td>
              <div class="d-flex align-items-center gap-3">
                <img src="{{ $post->image_url }}" alt="" class="rounded" style="width:56px;height:36px;object-fit:cover;">
                <div>
                  <strong>{{ $post->title }}</strong>
                  <div class="text-muted small">{{ Str::limit($post->excerpt, 60) }}</div>
                </div>
              </div>
            </td>
            <td>{{ optional($post->published_at)->format('d M Y') ?: '—' }}</td>
            <td>
              @if ($post->published_at && $post->published_at->isPast())
                <span class="badge bg-label-success">Live</span>
              @elseif ($post->published_at)
                <span class="badge bg-label-warning">Scheduled</span>
              @else
                <span class="badge bg-label-secondary">Draft</span>
              @endif
            </td>
            <td>
              <a href="{{ route('front.news.show', $post) }}" target="_blank" class="btn btn-sm btn-outline-secondary me-1"><i class="bx bx-link-external"></i></a>
              <a href="{{ route('admin.news.edit', $post) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bx bx-edit-alt"></i></a>
              <form action="{{ route('admin.news.destroy', $post) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete this story?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bx bx-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center py-4">No stories yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
