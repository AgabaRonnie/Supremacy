@extends('layouts.layoutMaster')

@section('title', $video->exists ? 'Edit Video' : 'Add Video')

@section('content')

@include('admin.partials.flash')

<form method="POST" action="{{ $video->exists ? route('admin.videos.update', $video) : route('admin.videos.store') }}">
  @csrf
  @if ($video->exists) @method('PUT') @endif

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">{{ $video->exists ? 'Edit ' . $video->title : 'Add Video' }}</h5></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="title">Title *</label>
              <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $video->title) }}" required>
            </div>
            @include('admin.partials.artist-select', ['selected' => old('artist_id', $video->artist_id), 'nullable' => true])
            <div class="col-12">
              <label class="form-label" for="youtube_url">YouTube URL *</label>
              <input type="url" class="form-control" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $video->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=..." required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="sort_order">Sort Order</label>
              <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $video->sort_order ?? 0) }}">
            </div>
            <div class="col-md-6 d-flex align-items-end">
              <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1"
                       {{ old('is_published', $video->exists ? $video->is_published : true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_published">Published</label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary">{{ $video->exists ? 'Save Changes' : 'Add Video' }}</button>
              <a href="{{ route('admin.videos.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

@endsection
