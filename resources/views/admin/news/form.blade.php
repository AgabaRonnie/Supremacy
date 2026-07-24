@extends('layouts.layoutMaster')

@section('title', $post->exists ? 'Edit Story' : 'Add Story')

@section('content')

@include('admin.partials.flash')

<form method="POST" enctype="multipart/form-data"
      action="{{ $post->exists ? route('admin.news.update', $post) : route('admin.news.store') }}">
  @csrf
  @if ($post->exists) @method('PUT') @endif

  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">{{ $post->exists ? 'Edit Story' : 'Add Story' }}</h5></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label" for="title">Title *</label>
              <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}" required>
            </div>
            <div class="col-12">
              <label class="form-label" for="excerpt">Excerpt</label>
              <input type="text" class="form-control" id="excerpt" name="excerpt" value="{{ old('excerpt', $post->excerpt) }}" placeholder="One-line summary shown in cards and link previews">
            </div>
            <div class="col-12">
              <label class="form-label" for="body">Body</label>
              <textarea class="form-control" id="body" name="body" rows="10">{{ old('body', $post->body) }}</textarea>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Image & Publishing</h5></div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Cover Image</label>
            @if ($post->image)
              <div class="mb-2"><img src="{{ $post->image_url }}" alt="" class="rounded" style="width:100%;height:90px;object-fit:cover;"></div>
            @endif
            <input type="file" class="form-control mb-1" name="image" accept="image/*">
            <input type="url" class="form-control" name="image_url" placeholder="...or paste an image URL">
          </div>
          <div class="mb-3">
            <label class="form-label" for="published_at">Publish Date (blank = draft)</label>
            <input type="datetime-local" class="form-control" id="published_at" name="published_at"
                   value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}">
          </div>
          <button type="submit" class="btn btn-primary w-100">{{ $post->exists ? 'Save Changes' : 'Add Story' }}</button>
          <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</form>

@endsection
