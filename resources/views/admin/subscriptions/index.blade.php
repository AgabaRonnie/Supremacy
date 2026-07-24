@extends('layouts.layoutMaster')

@section('title', 'Fan Subscriptions')

@section('content')

@include('admin.partials.flash')

@php $isAdmin = auth()->user()->isAdmin(); @endphp

<div class="card">
  <div class="card-header"><h5 class="mb-0">{{ $isAdmin ? 'Fan Club Subscriptions' : 'My Fan Club Subscribers' }}</h5></div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Fan</th>
          <th>Artist</th>
          <th>Plan</th>
          <th>Since</th>
          <th>Status</th>
          @if ($isAdmin)<th>Actions</th>@endif
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($subs as $sub)
          <tr>
            <td><strong>{{ $sub->name }}</strong><br><small class="text-muted">{{ $sub->phone }}</small></td>
            <td>{{ $sub->artist->name }}</td>
            <td>{{ $sub->plan->name }} · UGX {{ number_format($sub->plan->price) }}/{{ $sub->plan->interval }}</td>
            <td>{{ optional($sub->started_at)->format('d M Y') ?: $sub->created_at->format('d M Y') }}</td>
            <td>
              <span class="badge bg-label-{{ ['pending' => 'warning', 'active' => 'success', 'cancelled' => 'secondary'][$sub->status] ?? 'secondary' }}">{{ ucfirst($sub->status) }}</span>
            </td>
            @if ($isAdmin)
              <td>
                @if ($sub->status !== 'active')
                  <form action="{{ route('admin.subscriptions.status', $sub) }}" method="POST" class="d-inline">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="active">
                    <button type="submit" class="btn btn-sm btn-outline-success me-1" title="Activate"><i class="bx bx-check"></i></button>
                  </form>
                @endif
                @if ($sub->status !== 'cancelled')
                  <form action="{{ route('admin.subscriptions.status', $sub) }}" method="POST" class="d-inline">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="btn btn-sm btn-outline-warning me-1" title="Cancel"><i class="bx bx-x"></i></button>
                  </form>
                @endif
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sub->phone) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary me-1" title="WhatsApp"><i class="bx bxl-whatsapp"></i></a>
                <form action="{{ route('admin.subscriptions.destroy', $sub) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Remove this subscription?');">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bx bx-trash"></i></button>
                </form>
              </td>
            @endif
          </tr>
        @empty
          <tr><td colspan="{{ $isAdmin ? 6 : 5 }}" class="text-center py-4">No subscriptions yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
