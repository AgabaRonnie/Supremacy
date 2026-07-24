@extends('layouts.layoutMaster')

@section('title', $album->exists ? 'Edit Album' : 'Add Album')

@section('content')

@include('admin.partials.flash')

<form method="POST" enctype="multipart/form-data"
      action="{{ $album->exists ? route('admin.albums.update', $album) : route('admin.albums.store') }}">
  @csrf
  @if ($album->exists) @method('PUT') @endif

  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">{{ $album->exists ? 'Edit ' . $album->title : 'Add Album' }}</h5></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="title">Title *</label>
              <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $album->title) }}" required>
            </div>
            @include('admin.partials.artist-select', ['selected' => old('artist_id', $album->artist_id), 'nullable' => false])
            <div class="col-md-6">
              <label class="form-label" for="release_date">Release Date</label>
              <input type="date" class="form-control" id="release_date" name="release_date" value="{{ old('release_date', optional($album->release_date)->format('Y-m-d')) }}">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="price">Price (UGX, blank = not for sale)</label>
              <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $album->price) }}">
            </div>
            <div class="col-12">
              <label class="form-label" for="description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $album->description) }}</textarea>
            </div>
            @include('admin.partials.platform-links', ['links' => old('platform_links', $album->links)])
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
            @if ($album->cover)
              <div class="mb-2"><img src="{{ $album->cover_url }}" alt="" class="rounded" style="width:90px;height:90px;object-fit:cover;"></div>
            @endif
            <input type="file" class="form-control mb-1" name="cover" accept="image/*">
            <input type="url" class="form-control" name="cover_url" placeholder="...or paste an image URL">
          </div>
          <div class="mb-3">
            <label class="form-label" for="sort_order">Sort Order</label>
            <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $album->sort_order ?? 0) }}">
          </div>
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1"
                   {{ old('is_published', $album->exists ? $album->is_published : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_published">Published</label>
          </div>
          <button type="submit" class="btn btn-primary w-100">{{ $album->exists ? 'Save Changes' : 'Add Album' }}</button>
          <a href="{{ route('admin.albums.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</form>

@endsection
