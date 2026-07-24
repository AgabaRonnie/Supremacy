@extends('layouts.layoutMaster')

@section('title', $track->exists ? 'Edit Track' : 'Add Track')

@section('content')

@include('admin.partials.flash')

<form method="POST" enctype="multipart/form-data"
      action="{{ $track->exists ? route('admin.tracks.update', $track) : route('admin.tracks.store') }}">
  @csrf
  @if ($track->exists) @method('PUT') @endif

  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">{{ $track->exists ? 'Edit ' . $track->title : 'Add Track' }}</h5></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="title">Title *</label>
              <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $track->title) }}" required>
            </div>
            @include('admin.partials.artist-select', ['selected' => old('artist_id', $track->artist_id), 'nullable' => false])
            <div class="col-md-6">
              <label class="form-label" for="album_id">Album (blank = single)</label>
              <select class="form-select" id="album_id" name="album_id">
                <option value="">— Single —</option>
                @foreach ($albums as $a)
                  <option value="{{ $a->id }}" data-artist="{{ $a->artist_id }}" {{ (string) old('album_id', $track->album_id) === (string) $a->id ? 'selected' : '' }}>{{ $a->title }}</option>
                @endforeach
              </select>
              <small class="text-muted">The album must belong to the same artist.</small>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="release_date">Release Date</label>
              <input type="date" class="form-control" id="release_date" name="release_date" value="{{ old('release_date', optional($track->release_date)->format('Y-m-d')) }}">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="price">Price (UGX)</label>
              <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $track->price) }}">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="preview_audio">Preview Audio URL</label>
              <input type="url" class="form-control" id="preview_audio" name="preview_audio" value="{{ old('preview_audio', $track->preview_audio) }}" placeholder="Link to a short preview clip">
            </div>
            @include('admin.partials.platform-links', ['links' => old('platform_links', $track->links)])
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Cover & Visibility</h5></div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Cover Art</label>
            @if ($track->cover)
              <div class="mb-2"><img src="{{ $track->cover_url }}" alt="" class="rounded" style="width:90px;height:90px;object-fit:cover;"></div>
            @endif
            <input type="file" class="form-control mb-1" name="cover" accept="image/*">
            <input type="url" class="form-control" name="cover_url" placeholder="...or paste an image URL">
          </div>
          <div class="mb-3">
            <label class="form-label" for="sort_order">Sort Order</label>
            <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $track->sort_order ?? 0) }}">
          </div>
          <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" id="is_free" name="is_free" value="1"
                   {{ old('is_free', $track->is_free) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_free">Free download / stream</label>
          </div>
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1"
                   {{ old('is_published', $track->exists ? $track->is_published : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_published">Published</label>
          </div>
          <button type="submit" class="btn btn-primary w-100">{{ $track->exists ? 'Save Changes' : 'Add Track' }}</button>
          <a href="{{ route('admin.tracks.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</form>

@endsection
