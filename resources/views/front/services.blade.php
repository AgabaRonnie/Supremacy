@extends('layouts.front')

@section('title', 'Services | Supremacy Studios — Distribution, Pitching, Management')
@section('description', 'Supremacy Studios services: music recording and production, custom music distribution, playlist pitching, artist management and development, publishing and sync licensing.')

@section('content')

  <section class="ss-page-hero">
    <div class="ss-container">
      <span class="ss-label">What We Do</span>
      <h1 class="ss-page-hero__title">Services</h1>
      <p class="ss-lead">Everything a record needs between the booth and the world.</p>
    </div>
  </section>

  <section class="ss-section">
    <div class="ss-container">
      @foreach ($services as $i => $service)
        <div class="row g-5 align-items-center ss-section pt-0 reveal" id="{{ $service->slug }}">
          <div class="col-md-6 {{ $i % 2 ? 'order-md-2' : '' }}">
            <div class="ss-news-card__img mb-0" style="aspect-ratio: 4/3;">
              <img src="{{ $service->image_url }}" alt="{{ $service->title }}" loading="lazy">
            </div>
          </div>
          <div class="col-md-6 {{ $i % 2 ? 'order-md-1' : '' }}">
            <span class="ss-label">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
            <h2 class="ss-h2">{{ $service->title }}</h2>
            <p class="ss-lead mb-4">{{ $service->summary }}</p>
            @if ($service->slug === 'music-recording-production')
              <a href="{{ url('/studio') }}#book" class="ss-btn">Book a Session</a>
            @else
              <a href="{{ url('/contact') }}" class="ss-btn">Work With Us</a>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </section>

@endsection
