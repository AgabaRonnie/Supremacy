@extends('layouts.layoutMaster')

@section('title', 'Services')

@section('content')

@include('admin.partials.flash')

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Label Services</h5>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add Service</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Service</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($services as $service)
          <tr>
            <td>{{ $service->sort_order }}</td>
            <td>
              <strong>{{ $service->title }}</strong>
              <div class="text-muted small">{{ Str::limit($service->summary, 80) }}</div>
            </td>
            <td>
              <span class="badge bg-label-{{ $service->is_published ? 'success' : 'secondary' }}">{{ $service->is_published ? 'Published' : 'Hidden' }}</span>
            </td>
            <td>
              <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bx bx-edit-alt"></i></a>
              <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete {{ $service->title }}?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bx bx-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center py-4">No services yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
