@extends('layouts.front')

@section('title', 'Join ' . $plan->artist->name . "'s " . $plan->name . ' | Supremacy Studios')
@section('description', 'Join ' . $plan->artist->name . "'s fan club — " . $plan->name . '.')

@push('meta')
  <meta name="robots" content="noindex, nofollow">
@endpush

@section('content')

  <section class="ss-page-hero">
    <div class="ss-container">
      <span class="ss-label">{{ $plan->artist->name }} · Fan Club</span>
      <h1 class="ss-page-hero__title" style="font-size: clamp(2rem, 6vw, 4.5rem);">{{ $plan->name }}</h1>
      <p class="ss-lead">UGX {{ number_format($plan->price) }}/{{ $plan->interval }}</p>
    </div>
  </section>

  <section class="ss-section">
    <div class="ss-container">
      <div class="row g-5">
        <div class="col-lg-5 reveal">
          <span class="ss-label">What You Get</span>
          <ul class="as-plan__perks mt-3">
            @foreach ($plan->perks ?? [] as $perk)
              <li style="font-size: 1.05rem;"><i class="bi bi-check2"></i> {{ $perk }}</li>
            @endforeach
          </ul>
          <p class="mt-4"><a href="{{ url('/' . $plan->artist->slug) }}" class="ss-more">Back to {{ $plan->artist->name }} <i class="bi bi-arrow-right"></i></a></p>
        </div>

        <div class="col-lg-7 reveal">
          @if (session('club_success'))
            <div class="ss-alert">{{ session('club_success') }}</div>
          @else
            <form method="POST" action="{{ route('fanclub.subscribe', $plan) }}" class="ss-form">
              @csrf
              @if ($errors->any())
                <div class="ss-alert ss-alert--error">{{ $errors->first() }}</div>
              @endif
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="name">Your Name *</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                  <label for="phone">Phone / WhatsApp *</label>
                  <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                </div>
                <div class="col-md-6">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                </div>
                <div class="col-12">
                  <button type="submit" class="ss-btn ss-btn--solid">Reserve My Spot</button>
                </div>
                <div class="col-12">
                  <p class="small mb-0" style="color: var(--ss-gray);">
                    <i class="bi bi-info-circle me-1"></i>
                    Online payment for memberships launches soon. Reserve your spot now and we'll activate you the moment it's live.
                  </p>
                </div>
              </div>
            </form>
          @endif
        </div>
      </div>
    </div>
  </section>

@endsection
