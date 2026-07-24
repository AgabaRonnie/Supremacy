@extends('layouts.front')

@section('title', 'Artists | Supremacy Studios — Kampala Music Label')
@section('description', 'Meet the artists of Supremacy Studios — the roster shaping the sound of Kampala. Explore their music, merch, shows and full profiles.')

@section('content')

  <section class="ss-page-hero">
    <div class="ss-container">
      <span class="ss-label">The Roster</span>
      <h1 class="ss-page-hero__title">Artists</h1>
      <p class="ss-lead">Tap an artist to enter their world — music, videos, merch, shows and more.</p>
    </div>
  </section>

  <section class="ss-section">
    <div class="ss-container">
      <div class="row g-4">
        @forelse ($artists as $i => $artist)
          <div class="col-sm-6 col-lg-4 reveal">
            <a href="{{ url('/' . $artist->slug) }}" class="ss-roster__card w-100" aria-label="{{ $artist->name }}">
              <img src="{{ $artist->photo_url }}" alt="{{ $artist->name }}" loading="lazy">
              <span class="ss-roster__num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
              <span class="ss-roster__meta">
                <span class="ss-roster__name d-block">{{ $artist->name }}</span>
                <span class="ss-roster__genre">{{ $artist->genre }}</span>
              </span>
              <span class="ss-roster__arrow" aria-hidden="true"><i class="bi bi-arrow-up-right"></i></span>
            </a>
          </div>
        @empty
          <div class="col-12">
            <div class="ss-empty"><i class="bi bi-mic"></i> The roster is being assembled. Watch this space.</div>
          </div>
        @endforelse
      </div>

      <div class="text-center mt-5 reveal">
        <p class="ss-lead mx-auto mb-3">Think you belong on this page?</p>
        <a href="{{ url('/join') }}" class="ss-btn">Sign With Us</a>
      </div>
    </div>
  </section>

@endsection
