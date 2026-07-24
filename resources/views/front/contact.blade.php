@extends('layouts.front')

@section('title', 'Contact | Supremacy Studios — Nankulabye, Kampala')
@section('description', 'Contact Supremacy Studios: Nankulabye, Makerere Hill Road, Kampala, Uganda. Bookings, signings, press and partnerships.')

@php
  $ss = fn ($k, $d = '') => \App\Models\SiteSetting::get($k, $d);
@endphp

@section('content')

  <section class="ss-page-hero">
    <div class="ss-container">
      <span class="ss-label">Talk To Us</span>
      <h1 class="ss-page-hero__title">Contact</h1>
      <p class="ss-lead">Bookings, signings, press, partnerships — the door is open.</p>
    </div>
  </section>

  <section class="ss-section">
    <div class="ss-container">
      <div class="row g-5">
        <div class="col-lg-5 reveal">
          <div class="mb-4">
            <span class="ss-label">Visit</span>
            <p class="mb-0" style="font-size: 1.15rem;">{{ $ss('address', 'Nankulabye, Makerere Hill Road, Kampala, Uganda') }}</p>
          </div>
          <div class="mb-4">
            <span class="ss-label">Call / WhatsApp</span>
            <p class="mb-1" style="font-size: 1.15rem;"><a href="tel:{{ str_replace(' ', '', $ss('phone')) }}">{{ $ss('phone') }}</a></p>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ss('whatsapp')) }}" target="_blank" rel="noopener" class="ss-btn ss-btn--sm mt-2">
              <i class="bi bi-whatsapp"></i> Chat on WhatsApp
            </a>
          </div>
          <div class="mb-4">
            <span class="ss-label">Email</span>
            <p class="mb-0" style="font-size: 1.15rem;"><a href="mailto:{{ $ss('email') }}">{{ $ss('email') }}</a></p>
          </div>
          <div>
            <span class="ss-label">Follow</span>
            <div class="ss-footer__social">
              @foreach (['instagram' => 'bi-instagram', 'x' => 'bi-twitter-x', 'youtube' => 'bi-youtube', 'tiktok' => 'bi-tiktok'] as $key => $icon)
                @if ($ss($key))
                  <a href="{{ $ss($key) }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($key) }}"><i class="bi {{ $icon }}"></i></a>
                @endif
              @endforeach
            </div>
          </div>
        </div>
        <div class="col-lg-7 reveal">
          <div style="border: 1px solid var(--ss-border-strong); filter: grayscale(1) invert(0.92);">
            <iframe
              src="https://maps.google.com/maps?q=Makerere%20Hill%20Road%20Nankulabye%20Kampala&t=&z=15&ie=UTF8&iwloc=&output=embed"
              width="100%" height="460" style="border:0; display:block;" loading="lazy"
              referrerpolicy="no-referrer-when-downgrade" title="Supremacy Studios location map"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
