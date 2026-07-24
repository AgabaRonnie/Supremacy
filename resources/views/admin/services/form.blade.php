@extends('layouts.layoutMaster')

@section('title', $service->exists ? 'Edit Service' : 'Add Service')

@section('content')

@include('admin.partials.flash')

<form method="POST" enctype="multipart/form-data"
      action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}">
  @csrf
  @if ($service->exists) @method('PUT') @endif

  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">{{ $service->exists ? 'Edit ' . $service->title : 'Add Service' }}</h5></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-12">
              <label class="form-label" for="title">Title *</label>
              <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $service->title) }}" required>
            </div>
            <div class="col-12">
              <label class="form-label" for="summary">Summary</label>
              <input type="text" class="form-control" id="summary" name="summary" value="{{ old('summary', $service->summary) }}">
            </div>
            <div class="col-12">
              <label class="form-label" for="description">Full Description</label>
              <textarea class="form-control" id="description" name="description" rows="6">{{ old('description', $service->description) }}</textarea>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Image & Visibility</h5></div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Image</label>
            @if ($service->image)
              <div class="mb-2"><img src="{{ $service->image_url }}" alt="" class="rounded" style="width:100%;height:90px;object-fit:cover;"></div>
            @endif
            <input type="file" class="form-control mb-1" name="image" accept="image/*">
            <input type="url" class="form-control" name="image_url" placeholder="...or paste an image URL">
          </div>
          <div class="mb-3">
            <label class="form-label" for="sort_order">Sort Order</label>
            <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}">
          </div>
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1"
                   {{ old('is_published', $service->exists ? $service->is_published : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_published">Published</label>
          </div>
          <button type="submit" class="btn btn-primary w-100">{{ $service->exists ? 'Save Changes' : 'Add Service' }}</button>
          <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</form>

@endsection
