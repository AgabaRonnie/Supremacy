@extends('layouts.layoutMaster')

@section('title', 'Studio Bookings')

@section('content')

@include('admin.partials.flash')

<div class="card">
  <div class="card-header"><h5 class="mb-0">Studio Booking Requests</h5></div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Client</th>
          <th>Contact</th>
          <th>Requested Slot</th>
          <th>Session</th>
          <th>Message</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($bookings as $booking)
          <tr>
            <td><strong>{{ $booking->name }}</strong><br><small class="text-muted">{{ $booking->created_at->diffForHumans() }}</small></td>
            <td>
              {{ $booking->phone }}<br>
              <small class="text-muted">{{ $booking->email }}</small>
            </td>
            <td>{{ $booking->preferred_date->format('d M Y') }}<br><small class="text-muted">{{ $booking->preferred_time }}</small></td>
            <td>{{ $booking->session_type }}</td>
            <td style="white-space: normal; max-width: 220px;"><small>{{ Str::limit($booking->message, 90) }}</small></td>
            <td>
              <span class="badge bg-label-{{ ['pending' => 'warning', 'confirmed' => 'success', 'declined' => 'secondary'][$booking->status] ?? 'secondary' }}">{{ ucfirst($booking->status) }}</span>
            </td>
            <td>
              @if ($booking->status !== 'confirmed')
                <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="d-inline">
                  @csrf @method('PUT')
                  <input type="hidden" name="status" value="confirmed">
                  <button type="submit" class="btn btn-sm btn-outline-success me-1" title="Confirm"><i class="bx bx-check"></i></button>
                </form>
              @endif
              @if ($booking->status !== 'declined')
                <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="d-inline">
                  @csrf @method('PUT')
                  <input type="hidden" name="status" value="declined">
                  <button type="submit" class="btn btn-sm btn-outline-warning me-1" title="Decline"><i class="bx bx-x"></i></button>
                </form>
              @endif
              <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->phone) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary me-1" title="WhatsApp"><i class="bx bxl-whatsapp"></i></a>
              <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Remove this booking?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bx bx-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center py-4">No booking requests yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
