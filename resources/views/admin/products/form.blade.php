@extends('layouts.layoutMaster')

@section('title', $product->exists ? 'Edit Product' : 'Add Product')

@section('content')

@include('admin.partials.flash')

<form method="POST" enctype="multipart/form-data"
      action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}">
  @csrf
  @if ($product->exists) @method('PUT') @endif

  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">{{ $product->exists ? 'Edit ' . $product->name : 'Add Product' }}</h5></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="name">Name *</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            </div>
            @include('admin.partials.artist-select', ['selected' => old('artist_id', $product->artist_id), 'nullable' => true])
            <div class="col-md-6">
              <label class="form-label" for="price">Price (UGX) *</label>
              <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="stock">Stock (blank = unlimited)</label>
              <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock) }}">
            </div>
            <div class="col-12">
              <label class="form-label" for="description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
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
            <label class="form-label">Product Image</label>
            @if (count($product->images ?? []))
              <div class="mb-2"><img src="{{ $product->first_image_url }}" alt="" class="rounded" style="width:90px;height:90px;object-fit:cover;"></div>
            @endif
            <input type="file" class="form-control mb-1" name="image" accept="image/*">
            <input type="url" class="form-control" name="image_url" placeholder="...or paste an image URL">
          </div>
          <div class="mb-3">
            <label class="form-label" for="sort_order">Sort Order</label>
            <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}">
          </div>
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1"
                   {{ old('is_published', $product->exists ? $product->is_published : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_published">Published</label>
          </div>
          <button type="submit" class="btn btn-primary w-100">{{ $product->exists ? 'Save Changes' : 'Add Product' }}</button>
          <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</form>

@endsection
