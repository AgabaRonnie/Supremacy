@extends('layouts.layoutMaster')

@section('title', $plan->exists ? 'Edit Plan' : 'Add Plan')

@section('content')

@include('admin.partials.flash')

<form method="POST" action="{{ $plan->exists ? route('admin.plans.update', $plan) : route('admin.plans.store') }}">
  @csrf
  @if ($plan->exists) @method('PUT') @endif

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">{{ $plan->exists ? 'Edit ' . $plan->name : 'Add Fan Club Plan' }}</h5></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="name">Plan Name *</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $plan->name) }}" placeholder="e.g. Inner Circle" required>
            </div>
            @include('admin.partials.artist-select', ['selected' => old('artist_id', $plan->artist_id), 'nullable' => false])
            <div class="col-md-6">
              <label class="form-label" for="price">Price (UGX) *</label>
              <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $plan->price) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="interval">Billing Interval *</label>
              <select class="form-select" id="interval" name="interval" required>
                <option value="monthly" {{ old('interval', $plan->interval) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="yearly" {{ old('interval', $plan->interval) === 'yearly' ? 'selected' : '' }}>Yearly</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label" for="perks_text">Perks (one per line)</label>
              <textarea class="form-control" id="perks_text" name="perks_text" rows="5" placeholder="Early access to new releases&#10;Exclusive behind-the-scenes content">{{ old('perks_text', implode("\n", $plan->perks ?? [])) }}</textarea>
            </div>
            <div class="col-12">
              <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                       {{ old('is_active', $plan->exists ? $plan->is_active : true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-primary">{{ $plan->exists ? 'Save Changes' : 'Add Plan' }}</button>
              <a href="{{ route('admin.plans.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

@endsection
