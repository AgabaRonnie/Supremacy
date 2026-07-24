@extends('layouts.front')

@section('title', 'Checkout — ' . $title . ' | Supremacy Studios')
@section('description', 'Complete your order from Supremacy Studios.')

@push('meta')
  <meta name="robots" content="noindex, nofollow">
@endpush

@section('content')

  <section class="ss-page-hero">
    <div class="ss-container">
      <span class="ss-label">Checkout</span>
      <h1 class="ss-page-hero__title" style="font-size: clamp(2rem, 5.5vw, 4rem);">Almost Yours</h1>
    </div>
  </section>

  <section class="ss-section">
    <div class="ss-container">
      <div class="row g-5">
        <div class="col-lg-5 reveal">
          <div class="as-album">
            <div class="as-album__cover" style="max-width: 320px;">
              <img src="{{ $image }}" alt="{{ $title }}">
            </div>
            <h3 class="as-album__title mt-3">{{ $title }}</h3>
            <p class="as-album__meta">
              {{ ucfirst($type) }} · UGX {{ number_format($item->price) }}{{ $type === 'product' ? ' each' : '' }}
            </p>
          </div>
        </div>

        <div class="col-lg-7 reveal">
          <form method="POST" action="{{ route('checkout.place') }}" class="ss-form">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="item_id" value="{{ $item->id }}">

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
              @if ($type === 'product')
                <div class="col-md-6">
                  <label for="quantity">Quantity</label>
                  <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" max="50">
                </div>
              @endif
              <div class="col-12">
                <button type="submit" class="ss-btn ss-btn--solid">Place Order</button>
              </div>
              <div class="col-12">
                <p class="text-muted small mb-0" style="color: var(--ss-gray) !important;">
                  <i class="bi bi-shield-check me-1"></i>
                  Mobile Money &amp; card payments are launching soon — for now we confirm every order personally on WhatsApp.
                </p>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

@endsection
