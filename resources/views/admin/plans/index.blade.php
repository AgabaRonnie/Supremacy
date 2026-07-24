@extends('layouts.layoutMaster')

@section('title', 'Fan Club Plans')

@section('content')

@include('admin.partials.flash')

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Fan Club Plans</h5>
    <a href="{{ route('admin.plans.create') }}" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add Plan</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Plan</th>
          <th>Artist</th>
          <th>Price</th>
          <th>Perks</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($plans as $plan)
          <tr>
            <td><strong>{{ $plan->name }}</strong></td>
            <td>{{ $plan->artist->name }}</td>
            <td>UGX {{ number_format($plan->price) }}/{{ $plan->interval }}</td>
            <td>{{ count($plan->perks ?? []) }}</td>
            <td>
              <span class="badge bg-label-{{ $plan->is_active ? 'success' : 'secondary' }}">{{ $plan->is_active ? 'Active' : 'Inactive' }}</span>
            </td>
            <td>
              <a href="{{ route('admin.plans.edit', $plan) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bx bx-edit-alt"></i></a>
              <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete {{ $plan->name }}?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bx bx-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center py-4">No fan club plans yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
