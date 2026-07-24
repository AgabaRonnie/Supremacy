@extends('layouts.layoutMaster')

@section('title', 'Site Settings')

@section('content')

@include('admin.partials.flash')

<form method="POST" action="{{ route('admin.settings.update') }}">
  @csrf
  @method('PUT')

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Site Settings</h5></div>
        <div class="card-body">
          <div class="row g-3">
            @foreach ($fields as $key => [$label, $type])
              <div class="col-md-6">
                <label class="form-label" for="{{ $key }}">{{ $label }}</label>
                <input type="{{ $type }}" class="form-control" id="{{ $key }}" name="{{ $key }}" value="{{ old($key, $values[$key]) }}">
              </div>
            @endforeach
            <div class="col-12">
              <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

@endsection
