@extends('layouts.front')

@section('title', 'Order ' . $order->reference . ' | Supremacy Studios')

@push('meta')
  <meta name="robots" content="noindex, nofollow">
@endpush

@section('content')

  <section class="ss-page-hero">
    <div class="ss-container">
      <span class="ss-label">Order {{ $order->reference }}</span>
      <h1 class="ss-page-hero__title" style="font-size: clamp(2rem, 5.5vw, 4rem);">
        @if ($order->status === 'paid' || $order->status === 'fulfilled')
          Thank You.
        @else
          Order Received.
        @endif
      </h1>
      <p class="ss-lead">
        <span class="ss-event-row__price" style="display: inline-block;">Status: {{ strtoupper($order->status) }}</span>
      </p>
    </div>
  </section>

  <section class="ss-section">
    <div class="ss-container">
      <div class="row g-5">
        <div class="col-lg-6 reveal">
          <span class="ss-label">Your Items</span>
          @foreach ($order->items as $item)
            <div class="ss-event-row" style="grid-template-columns: 1fr auto;">
              <span>
                <span class="ss-event-row__title d-block">{{ $item->title }}</span>
                <p class="ss-event-row__venue">Qty {{ $item->quantity }} · UGX {{ number_format($item->unit_price) }} each</p>
              </span>
              <span class="ss-event-row__price">UGX {{ number_format($item->unit_price * $item->quantity) }}</span>
            </div>
          @endforeach
          <div class="d-flex justify-content-between align-items-center mt-4">
            <span class="ss-label mb-0">Total</span>
            <span style="font-family: var(--ss-display); font-size: 1.8rem; font-weight: 600;">UGX {{ number_format($order->total) }}</span>
          </div>
        </div>

        <div class="col-lg-6 reveal">
          @if (in_array($order->status, ['paid', 'fulfilled']))
            <span class="ss-label">All Set</span>
            <h2 class="ss-h2">Payment received.</h2>
            <p class="ss-lead">We've got it from here — thank you for supporting the movement.</p>
          @elseif ($onlinePayments)
            {{-- TODO(SUPREMACY): "Pay Now" button goes to PaymentService::initiate() once keys are live --}}
            <span class="ss-label">Payment</span>
            <h2 class="ss-h2">Complete your payment.</h2>
            <a href="#" class="ss-btn ss-btn--solid">Pay Now</a>
          @else
            <span class="ss-label">What Happens Next</span>
            <h2 class="ss-h2">Payments are<br>launching soon.</h2>
            <p class="ss-lead mb-4">Mobile Money (MTN &amp; Airtel) and card payments are coming to the site very soon. Until then, tap below and we'll complete your order together on WhatsApp — your reference is already filled in.</p>
            <a href="{{ $order->whatsapp_url }}" target="_blank" rel="noopener" class="ss-btn ss-btn--solid">
              <i class="bi bi-whatsapp"></i> Complete on WhatsApp
            </a>
            <p class="mt-3 small" style="color: var(--ss-dim);">Keep your reference: <strong style="color: var(--ss-white);">{{ $order->reference }}</strong></p>
          @endif
        </div>
      </div>
    </div>
  </section>

@endsection
