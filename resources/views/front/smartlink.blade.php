@extends('layouts.artist')

@php
  $links = collect($track->links ?? []);
  $shareUrl = route('track.smartlink', [$artist, $track]);
  $platformIcons = [
    'spotify' => 'bi-spotify', 'apple-music' => 'bi-apple', 'youtube-music' => 'bi-youtube',
    'boomplay' => 'bi-music-note-beamed', 'audiomack' => 'bi-soundwave', 'deezer' => 'bi-vinyl',
  ];
@endphp

@section('title', $track->title . ' — ' . $artist->name . ' | Listen Everywhere')
@section('description', 'Listen to ' . $track->title . ' by ' . $artist->name . ' on Spotify, Apple Music, Boomplay, Audiomack and more.')
@section('author', $artist->name)
@section('og_title', $track->title . ' — ' . $artist->name)
@section('og_description', 'Choose your platform and press play.')
@section('og_image', $track->cover_url)

@push('meta')
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "MusicRecording",
    "name": @json($track->title),
    "byArtist": { "@type": "MusicGroup", "name": @json($artist->name), "url": @json(url('/' . $artist->slug)) },
    "image": @json($track->cover_url),
    "datePublished": @json(optional($track->release_date)->toDateString()),
    "url": @json($shareUrl)
  }
  </script>
@endpush

@section('content')

  <div class="sl-page" style="background-image: url('{{ $track->cover_url }}');">
    <div class="sl-page__scrim"></div>

    <div class="sl-card">
      <a href="{{ url('/' . $artist->slug) }}" class="sl-card__artist-link">
        <img src="{{ $artist->photo_url }}" alt="{{ $artist->name }}">
        <span>{{ $artist->name }}</span>
      </a>

      <div class="sl-card__cover">
        <img src="{{ $track->cover_url }}" alt="{{ $track->title }} — {{ $artist->name }}">
      </div>

      <h1 class="sl-card__title">{{ $track->title }}</h1>
      <p class="sl-card__meta">
        {{ $track->album ? $track->album->title : 'Single' }}
        @if ($track->release_date) · {{ $track->release_date->format('Y') }} @endif
      </p>

      <div class="sl-card__platforms">
        @forelse ($links as $platform => $url)
          <a href="{{ route('go.track', [$track, $platform]) }}" class="sl-platform">
            <span><i class="bi {{ $platformIcons[$platform] ?? 'bi-music-note' }}"></i> {{ ucwords(str_replace('-', ' ', $platform)) }}</span>
            <span class="sl-platform__play">Play <i class="bi bi-arrow-right"></i></span>
          </a>
        @empty
          <p class="text-center" style="color: var(--ss-gray);">Streaming links coming soon.</p>
        @endforelse

        @if (!$track->is_free && $track->price)
          <a href="{{ route('checkout', ['type' => 'track', 'id' => $track->id]) }}" class="sl-platform sl-platform--buy">
            <span><i class="bi bi-bag"></i> Buy the song</span>
            <span class="sl-platform__play">UGX {{ number_format($track->price) }}</span>
          </a>
        @endif
      </div>

      <button class="sl-card__share" data-share-url="{{ $shareUrl }}" data-share-title="{{ $track->title }} — {{ $artist->name }}">
        <i class="bi bi-share me-1"></i> Share this song
      </button>

      <p class="sl-card__sig">
        <a href="{{ url('/') }}">SUPREMACY STUDIOS</a>
      </p>
    </div>
  </div>

@endsection
