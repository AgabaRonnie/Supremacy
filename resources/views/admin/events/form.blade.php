@extends('layouts.layoutMaster')

@section('title', $event->exists ? 'Edit Event' : 'Add Event')

@section('content')

@include('admin.partials.flash')

<form method="POST" enctype="multipart/form-data"
      action="{{ $event->exists ? route('admin.events.update', $event) : route('admin.events.store') }}">
  @csrf
  @if ($event->exists) @method('PUT') @endif

  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">{{ $event->exists ? 'Edit ' . $event->title : 'Add Event' }}</h5></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="title">Title *</label>
              <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $event->title) }}" required>
            </div>
            @include('admin.partials.artist-select', ['selected' => old('artist_id', $event->artist_id), 'nullable' => true])
            <div class="col-md-6">
              <label class="form-label" for="starts_at">Date & Time *</label>
              <input type="datetime-local" class="form-control" id="starts_at" name="starts_at"
                     value="{{ old('starts_at', optional($event->starts_at)->format('Y-m-d\TH:i')) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="venue">Venue</label>
              <input type="text" class="form-control" id="venue" name="venue" value="{{ old('venue', $event->venue) }}">
            </div>
            <div class="col-md-3">
              <label class="form-label" for="city">City</label>
              <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $event->city ?? 'Kampala') }}">
            </div>
            <div class="col-md-3">
              <label class="form-label" for="country">Country</label>
              <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $event->country ?? 'Uganda') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="price_info">Price Info</label>
              <input type="text" class="form-control" id="price_info" name="price_info" value="{{ old('price_info', $event->price_info) }}" placeholder="e.g. UGX 20,000 - 50,000 or Free entry">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="ticket_url">Ticket URL</label>
              <input type="url" class="form-control" id="ticket_url" name="ticket_url" value="{{ old('ticket_url', $event->ticket_url) }}">
            </div>
            <div class="col-12">
              <label class="form-label" for="description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $event->description) }}</textarea>
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
            <label class="form-label">Event Image</label>
            @if ($event->image)
              <div class="mb-2"><img src="{{ $event->image_url }}" alt="" class="rounded" style="width:100%;height:90px;object-fit:cover;"></div>
            @endif
            <input type="file" class="form-control mb-1" name="image" accept="image/*">
            <input type="url" class="form-control" name="image_url" placeholder="...or paste an image URL">
          </div>
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1"
                   {{ old('is_published', $event->exists ? $event->is_published : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_published">Published</label>
          </div>
          <button type="submit" class="btn btn-primary w-100">{{ $event->exists ? 'Save Changes' : 'Add Event' }}</button>
          <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</form>

@endsection
