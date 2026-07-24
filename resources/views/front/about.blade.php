@extends('layouts.front')

@section('title', 'About | Supremacy Studios — Music Label in Kampala, Uganda')
@section('description', 'The story of Supremacy Studios — a music label and recording studio in Nankulabye, Kampala, building the next generation of Ugandan artists.')

@section('content')

  <section class="ss-page-hero">
    <div class="ss-container">
      <span class="ss-label">The House</span>
      <h1 class="ss-page-hero__title">About</h1>
      <p class="ss-lead">A label built in Kampala, for artists the world will hear.</p>
    </div>
  </section>

  <section class="ss-section">
    <div class="ss-container">
      <div class="row g-5 align-items-center">
        <div class="col-lg-6 reveal">
          <span class="ss-label">The Story</span>
          <h2 class="ss-h2">From Nankulabye,<br>to everywhere.</h2>
          <p>Supremacy Studios is a music label and recording studio based on Makerere Hill Road in Nankulabye, Kampala. We sign artists, record them in our own studio, distribute their music worldwide, pitch it to playlists, and build the careers behind the songs.</p>
          <p class="ss-lead">We believe the next global sound is already here — it just needs the right house behind it.</p>
        </div>
        <div class="col-lg-6 reveal">
          <div class="ss-news-card__img mb-0" style="aspect-ratio: 4/3;">
            <img src="https://images.unsplash.com/photo-1487180144351-b8472da7d491?auto=format&fit=crop&w=1400&q=80" alt="Inside the Supremacy Studios recording studio" loading="lazy">
          </div>
        </div>
      </div>

      <div class="row g-4 mt-5 reveal">
        <div class="col-6 col-md-3"><div class="ss-stat"><span class="ss-stat__num">{{ $artistCount }}</span><span class="ss-stat__label">Signed artists</span></div></div>
        <div class="col-6 col-md-3"><div class="ss-stat"><span class="ss-stat__num">1</span><span class="ss-stat__label">Recording studio</span></div></div>
        <div class="col-6 col-md-3"><div class="ss-stat"><span class="ss-stat__num">5</span><span class="ss-stat__label">Label services</span></div></div>
        <div class="col-6 col-md-3"><div class="ss-stat"><span class="ss-stat__num">∞</span><span class="ss-stat__label">Ambition</span></div></div>
      </div>
    </div>
  </section>

  <section class="ss-studio-band">
    <div class="ss-studio-band__bg" style="background-image: url('https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=2000&q=80');" aria-hidden="true"></div>
    <div class="ss-container reveal">
      <span class="ss-label">Join Us</span>
      <h2 class="ss-h2">Your sound.<br>Our machine.</h2>
      <div class="d-flex gap-3 flex-wrap mt-4">
        <a href="{{ url('/join') }}" class="ss-btn ss-btn--solid">Sign With Us</a>
        <a href="{{ url('/contact') }}" class="ss-btn">Contact</a>
      </div>
    </div>
  </section>

@endsection
