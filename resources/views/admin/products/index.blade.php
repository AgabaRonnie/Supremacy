@extends('layouts.layoutMaster')

@section('title', 'Merch')

@section('content')

@include('admin.partials.flash')

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Merch</h5>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add Product</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Product</th>
          <th>Artist</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($products as $product)
          <tr>
            <td>
              <div class="d-flex align-items-center gap-3">
                <img src="{{ $product->first_image_url }}" alt="" class="rounded" style="width:40px;height:40px;object-fit:cover;">
                <strong>{{ $product->name }}</strong>
              </div>
            </td>
            <td>{{ $product->artist->name ?? 'Label' }}</td>
            <td>UGX {{ number_format($product->price) }}</td>
            <td>{{ $product->stock ?? '∞' }}</td>
            <td>
              <span class="badge bg-label-{{ $product->is_published ? 'success' : 'secondary' }}">{{ $product->is_published ? 'Published' : 'Hidden' }}</span>
            </td>
            <td>
              <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bx bx-edit-alt"></i></a>
              <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete {{ $product->name }}?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bx bx-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center py-4">No merch yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
