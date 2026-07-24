@extends('layouts.layoutMaster')

@section('title', 'Orders')

@section('content')

@include('admin.partials.flash')

@php $isAdmin = auth()->user()->isAdmin(); @endphp

<div class="card">
  <div class="card-header"><h5 class="mb-0">{{ $isAdmin ? 'Orders' : 'Orders For My Items' }}</h5></div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Reference</th>
          <th>Customer</th>
          <th>Items</th>
          <th>Total</th>
          <th>Status</th>
          @if ($isAdmin)<th>Actions</th>@endif
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($orders as $order)
          <tr>
            <td><strong>{{ $order->reference }}</strong><br><small class="text-muted">{{ $order->created_at->format('d M Y, g:ia') }}</small></td>
            <td>{{ $order->name }}<br><small class="text-muted">{{ $order->phone }}</small></td>
            <td style="white-space: normal; max-width: 260px;">
              @foreach ($order->items as $item)
                <small class="d-block">{{ $item->title }} ×{{ $item->quantity }}</small>
              @endforeach
            </td>
            <td>{{ $order->currency }} {{ number_format($order->total) }}</td>
            <td>
              <span class="badge bg-label-{{ ['pending' => 'warning', 'paid' => 'info', 'fulfilled' => 'success', 'cancelled' => 'secondary'][$order->status] ?? 'secondary' }}">{{ ucfirst($order->status) }}</span>
            </td>
            @if ($isAdmin)
              <td>
                @foreach (['paid' => ['bx-check-circle', 'info', 'Mark paid'], 'fulfilled' => ['bx-package', 'success', 'Mark fulfilled'], 'cancelled' => ['bx-x-circle', 'warning', 'Cancel']] as $status => [$icon, $color, $label])
                  @if ($order->status !== $status)
                    <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="d-inline">
                      @csrf @method('PUT')
                      <input type="hidden" name="status" value="{{ $status }}">
                      <button type="submit" class="btn btn-sm btn-outline-{{ $color }} me-1" title="{{ $label }}"><i class="bx {{ $icon }}"></i></button>
                    </form>
                  @endif
                @endforeach
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary me-1" title="WhatsApp customer"><i class="bx bxl-whatsapp"></i></a>
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Remove order {{ $order->reference }}?');">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bx bx-trash"></i></button>
                </form>
              </td>
            @endif
          </tr>
        @empty
          <tr><td colspan="{{ $isAdmin ? 6 : 5 }}" class="text-center py-4">No orders yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
