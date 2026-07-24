@extends('layouts.layoutMaster')

@section('title', 'Events')

@section('content')

@include('admin.partials.flash')

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Events & Shows</h5>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add Event</a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Event</th>
          <th>Artist</th>
          <th>When</th>
          <th>Venue</th>
          <th>Price</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($events as $event)
          <tr class="{{ $event->starts_at->isPast() ? 'text-muted' : '' }}">
            <td><strong>{{ $event->title }}</strong>{!! $event->starts_at->isPast() ? ' <span class="badge bg-label-secondary">Past</span>' : '' !!}</td>
            <td>{{ $event->artist->name ?? 'Label' }}</td>
            <td>{{ $event->starts_at->format('d M Y, g:ia') }}</td>
            <td>{{ $event->venue }}, {{ $event->city }}</td>
            <td>{{ $event->price_info ?: '—' }}</td>
            <td>
              <span class="badge bg-label-{{ $event->is_published ? 'success' : 'secondary' }}">{{ $event->is_published ? 'Published' : 'Hidden' }}</span>
            </td>
            <td>
              <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bx bx-edit-alt"></i></a>
              <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Delete {{ $event->title }}?');">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bx bx-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center py-4">No events yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
