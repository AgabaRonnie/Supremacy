@extends('layouts.artist')

@php
  $shareUrl = url('/' . $artist->slug);
  $socials = $artist->links->where('type', 'social');
  $streams = $artist->links->where('type', 'streaming');
  $socialIcons = [
    'instagram' => 'bi-instagram', 'x' => 'bi-twitter-x', 'twitter' => 'bi-twitter-x',
    'tiktok' => 'bi-tiktok', 'youtube' => 'bi-youtube', 'facebook' => 'bi-facebook',
  ];
  $schemaAlbums = $artist->albums->map(fn ($a) => [
    '@type' => 'MusicAlbum',
    'name' => $a->title,
    'datePublished' => optional($a->release_date)->toDateString(),
  ])->values();
  $schemaEvents = $upcomingEvents->map(fn ($e) => [
    '@type' => 'MusicEvent',
    'name' => $e->title,
    'startDate' => $e->starts_at->toIso8601String(),
    'location' => ['@type' => 'Place', 'name' => trim($e->venue . ', ' . $e->city, ', ')],
  ])->values();
@endphp

@section('title', $artist->name . ' | Official Website')
@section('description', Str::limit(strip_tags($artist->bio), 155))
@section('author', $artist->name)
@section('og_title', $artist->name . ' — ' . ($artist->tagline ?: 'Official Website'))
@section('og_description', Str::limit(strip_tags($artist->bio), 200))
@section('og_image', $artist->photo_url)

@push('meta')
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "MusicGroup",
    "name": @json($artist->name),
    "genre": @json($artist->genre),
    "description": @json(Str::limit(strip_tags($artist->bio), 300)),
    "image": @json($artist->photo_url),
    "url": @json($shareUrl),
    "sameAs": @json($artist->links->pluck('url')->values()),
    "foundingLocation": { "@type": "Place", "name": "Kampala, Uganda" },
    "memberOf": { "@type": "Organization", "name": "Supremacy Studios", "url": @json(url('/')) },
    "album": @json($schemaAlbums),
    "event": @json($schemaEvents)
  }
  </script>
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
      { "@type": "ListItem", "position": 1, "name": "Supremacy Studios", "item": @json(url('/')) },
      { "@type": "ListItem", "position": 2, "name": "Artists", "item": @json(url('/artists')) },
      { "@type": "ListItem", "position": 3, "name": @json($artist->name), "item": @json($shareUrl) }
    ]
  }
  </script>
@endpush

@section('content')

  {{-- ======== Artist top bar ======== --}}
  <header class="as-topbar" id="ssNav">
    <div class="as-topbar__inner">
      <a href="#top" class="as-topbar__name">{{ strtoupper($artist->name) }}</a>
      <div class="as-topbar__right">
        <a href="{{ url('/') }}" class="as-topbar__label d-none d-md-inline">A <strong>Supremacy Studios</strong> Artist</a>
        <button class="ss-btn ss-btn--sm" data-bs-toggle="modal" data-bs-target="#shareModal">
          <i class="bi bi-share"></i><span class="d-none d-sm-inline"> Share</span>
        </button>
      </div>
    </div>
  </header>

  {{-- ======== Hero ======== --}}
  <section class="as-hero" id="top" style="background-image: url('{{ $artist->cover_image_url }}');">
    <div class="as-hero__scrim" aria-hidden="true"></div>
    <div class="ss-container as-hero__content">
      <span class="as-chip"><span class="as-chip__dot"></span> Supremacy Studios Artist</span>
      <h1 class="as-hero__name">{{ $artist->name }}</h1>
      @if ($artist->tagline)
        <p class="as-hero__tagline">{{ $artist->tagline }}</p>
      @endif
      <p class="as-hero__meta">{{ $artist->genre }} @if ($artist->location) · {{ $artist->location }} @endif</p>

      <div class="as-hero__actions">
        <a href="#music" class="ss-btn ss-btn--solid"><i class="bi bi-play-fill"></i> Listen</a>
        <button class="ss-btn" data-bs-toggle="modal" data-bs-target="#shareModal"><i class="bi bi-share"></i> Share</button>
      </div>

      @if ($socials->count())
        <div class="as-hero__socials">
          @foreach ($socials as $link)
            <a href="{{ $link->url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($link->platform) }}">
              <i class="bi {{ $socialIcons[$link->platform] ?? 'bi-link-45deg' }}"></i>
            </a>
          @endforeach
        </div>
      @endif
    </div>
  </section>

  {{-- ======== Sticky section nav ======== --}}
  <nav class="as-nav" id="asNav" aria-label="Artist sections">
    <div class="as-nav__inner">
      <a href="#music" class="is-active">Music</a>
      <a href="#videos">Videos</a>
      <a href="#merch">Merch</a>
      <a href="#shows">Shows</a>
      @if ($artist->subscriptionPlans->count())
        <a href="#fanclub">Fan Club</a>
      @endif
      <a href="#about">About</a>
    </div>
  </nav>

  <main>

    {{-- ======== MUSIC ======== --}}
    <section class="ss-section" id="music">
      <div class="ss-container">
        <div class="reveal">
          <span class="ss-label">Music</span>
        </div>

        @if ($artist->albums->count())
          <h2 class="ss-h2 reveal">Albums</h2>
          <div class="row g-4 mb-5 reveal">
            @foreach ($artist->albums as $album)
              <div class="col-6 col-md-4 col-lg-3">
                <div class="as-album">
                  <div class="as-album__cover">
                    <img src="{{ $album->cover_url }}" alt="{{ $album->title }} — {{ $artist->name }}" loading="lazy">
                  </div>
                  <h3 class="as-album__title">{{ $album->title }}</h3>
                  <p class="as-album__meta">
                    {{ optional($album->release_date)->format('Y') }} · {{ $album->tracks_count }} tracks
                    @if ($album->price) · UGX {{ number_format($album->price) }} @endif
                  </p>
                  <div class="as-album__links">
                    @foreach (collect($album->links)->take(3) as $platform => $url)
                      <a href="{{ $url }}" target="_blank" rel="noopener">{{ str_replace('-', ' ', $platform) }}</a>
                    @endforeach
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif

        <h2 class="ss-h2 reveal">{{ $artist->albums->count() ? 'Singles' : 'Latest Music' }}</h2>
        <div class="reveal">
          @forelse ($artist->singles as $i => $track)
            <div class="as-track">
              <span class="as-track__num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
              <span class="as-track__cover"><img src="{{ $track->cover_url }}" alt="" loading="lazy"></span>
              <span class="as-track__info">
                <span class="as-track__title">{{ $track->title }}</span>
                <span class="as-track__date">{{ optional($track->release_date)->format('M Y') }}</span>
              </span>
              <span class="as-track__price">
                @if ($track->is_free)
                  Free
                @elseif ($track->price)
                  UGX {{ number_format($track->price) }}
                @endif
              </span>
              <span class="as-track__links">
                @foreach (collect($track->links)->take(4) as $platform => $url)
                  <a href="{{ $url }}" target="_blank" rel="noopener">{{ str_replace('-', ' ', $platform) }}</a>
                @endforeach
              </span>
            </div>
          @empty
            <div class="ss-empty"><i class="bi bi-music-note-beamed"></i> {{ $artist->name }}'s first release is loading. Stay close.</div>
          @endforelse
        </div>

        @if ($streams->count())
          <div class="mt-5 reveal">
            <span class="ss-label">Stream {{ $artist->name }} on</span>
            <div class="ss-platforms">
              @foreach ($streams as $link)
                <a href="{{ $link->url }}" target="_blank" rel="noopener" class="ss-platform">{{ str_replace('-', ' ', $link->platform) }}</a>
              @endforeach
            </div>
          </div>
        @endif
      </div>
    </section>

    {{-- ======== VIDEOS ======== --}}
    <section class="ss-section ss-services" id="videos">
      <div class="ss-container">
        <div class="reveal"><span class="ss-label">Videos</span><h2 class="ss-h2">Watch</h2></div>
        @if ($artist->videos->count())
          <div class="row g-4 reveal">
            @foreach ($artist->videos as $video)
              <div class="col-md-6">
                <div class="ratio ratio-16x9 as-video">
                  <iframe src="{{ $video->embed_url }}" title="{{ $video->title }}" allowfullscreen loading="lazy"></iframe>
                </div>
                <p class="as-video__title">{{ $video->title }}</p>
              </div>
            @endforeach
          </div>
        @else
          <div class="ss-empty reveal"><i class="bi bi-camera-video"></i> No videos yet — the first visual is on the way.</div>
        @endif
      </div>
    </section>

    {{-- ======== MERCH ======== --}}
    <section class="ss-section ss-services" id="merch">
      <div class="ss-container">
        <div class="reveal"><span class="ss-label">Merch</span><h2 class="ss-h2">Wear the Movement</h2></div>
        @if ($artist->products->count())
          <div class="row g-4 reveal">
            @foreach ($artist->products as $product)
              <div class="col-6 col-md-4 col-lg-3">
                <div class="as-album">
                  <div class="as-album__cover">
                    <img src="{{ $product->first_image_url }}" alt="{{ $product->name }}" loading="lazy">
                  </div>
                  <h3 class="as-album__title">{{ $product->name }}</h3>
                  <p class="as-album__meta">UGX {{ number_format($product->price) }}</p>
                  <div class="as-album__links">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('whatsapp')) }}?text={{ urlencode('Hello Supremacy Studios, I want to order: ' . $product->name . ' (' . $artist->name . ')') }}" target="_blank" rel="noopener">Order on WhatsApp</a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="ss-empty reveal"><i class="bi bi-bag"></i> No merch available yet.</div>
        @endif
      </div>
    </section>

    {{-- ======== SHOWS ======== --}}
    <section class="ss-section ss-services" id="shows">
      <div class="ss-container">
        <div class="reveal"><span class="ss-label">Live</span><h2 class="ss-h2">Upcoming Shows</h2></div>
        <div class="reveal">
          @forelse ($upcomingEvents as $event)
            <div class="ss-event-row">
              <span class="ss-event-row__date">
                <span class="d">{{ $event->starts_at->format('d') }}</span>
                <span class="m">{{ $event->starts_at->format('M Y') }}</span>
              </span>
              <span>
                <span class="ss-event-row__title d-block">{{ $event->title }}</span>
                <p class="ss-event-row__venue">{{ $event->venue }}, {{ $event->city }} · {{ $event->starts_at->format('D, g:ia') }}</p>
              </span>
              <span class="ss-event-row__price">{{ $event->price_info }}</span>
              @if ($event->ticket_url)
                <a href="{{ $event->ticket_url }}" target="_blank" rel="noopener" class="ss-btn ss-btn--sm">Tickets</a>
              @else
                <span></span>
              @endif
            </div>
          @empty
            <div class="ss-empty"><i class="bi bi-calendar-x"></i> {{ $artist->name }} has no upcoming shows right now — follow the socials to catch the next one first.</div>
          @endforelse
        </div>
      </div>
    </section>

    {{-- ======== FAN CLUB ======== --}}
    @if ($artist->subscriptionPlans->count())
      <section class="ss-section ss-services" id="fanclub">
        <div class="ss-container">
          <div class="reveal"><span class="ss-label">Fan Club</span><h2 class="ss-h2">Get Closer</h2></div>
          <div class="row g-4 reveal">
            @foreach ($artist->subscriptionPlans as $plan)
              <div class="col-md-5 col-lg-4">
                <div class="as-plan">
                  <h3 class="as-plan__name">{{ $plan->name }}</h3>
                  <p class="as-plan__price">UGX {{ number_format($plan->price) }}<span>/{{ $plan->interval }}</span></p>
                  <ul class="as-plan__perks">
                    @foreach ($plan->perks ?? [] as $perk)
                      <li><i class="bi bi-check2"></i> {{ $perk }}</li>
                    @endforeach
                  </ul>
                  <button class="ss-btn w-100 justify-content-center" disabled title="Coming soon">Join — Coming Soon</button>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </section>
    @endif

    {{-- ======== ABOUT ======== --}}
    <section class="ss-section ss-services" id="about">
      <div class="ss-container">
        <div class="row g-5">
          <div class="col-lg-7 reveal">
            <span class="ss-label">About</span>
            <h2 class="ss-h2">The Story</h2>
            <div class="as-bio">{!! nl2br(e($artist->bio)) !!}</div>
          </div>
          <div class="col-lg-5 reveal">
            <div class="as-facts">
              @if ($artist->genre)<div class="as-fact"><span>Genre</span><strong>{{ $artist->genre }}</strong></div>@endif
              @if ($artist->location)<div class="as-fact"><span>Based in</span><strong>{{ $artist->location }}</strong></div>@endif
              @if ($artist->joined_year)<div class="as-fact"><span>With Supremacy since</span><strong>{{ $artist->joined_year }}</strong></div>@endif
              <div class="as-fact"><span>Label</span><strong><a href="{{ url('/') }}">Supremacy Studios</a></strong></div>
            </div>
          </div>
        </div>

        @if (count($artist->gallery ?? []))
          <div class="as-gallery reveal">
            @foreach ($artist->gallery as $photo)
              <div class="as-gallery__item"><img src="{{ \App\Models\Artist::resolveImage($photo) }}" alt="{{ $artist->name }}" loading="lazy"></div>
            @endforeach
          </div>
        @endif
      </div>
    </section>

  </main>

  {{-- ======== Artist footer ======== --}}
  <footer class="as-footer">
    <div class="ss-container">
      <p class="as-footer__name">{{ strtoupper($artist->name) }}</p>
      @if ($socials->count())
        <div class="as-footer__socials">
          @foreach ($socials as $link)
            <a href="{{ $link->url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($link->platform) }}">
              <i class="bi {{ $socialIcons[$link->platform] ?? 'bi-link-45deg' }}"></i>
            </a>
          @endforeach
        </div>
      @endif
      <p class="as-footer__sig">
        An artist of <a href="{{ url('/') }}">SUPREMACY STUDIOS</a> — Kampala, Uganda
      </p>
      <p class="as-footer__copy">&copy; {{ date('Y') }} {{ $artist->name }} · All rights reserved</p>
    </div>
  </footer>

  {{-- ======== Share modal ======== --}}
  <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content as-modal">
        <div class="as-modal__head">
          <h5 id="shareModalLabel">Share {{ $artist->name }}</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="as-modal__body">
          <p class="as-modal__hint">This link is {{ $artist->name }}'s official page — share it anywhere and it opens like their own website.</p>

          <div class="as-copy">
            <input type="text" readonly value="{{ $shareUrl }}" id="shareUrlInput" aria-label="Artist page link">
            <button class="ss-btn ss-btn--sm ss-btn--solid" data-share-url="{{ $shareUrl }}" data-share-title="{{ $artist->name }} — Supremacy Studios">
              <i class="bi bi-clipboard"></i> Copy
            </button>
          </div>

          <div class="as-share-btns">
            <a href="https://wa.me/?text={{ urlencode($artist->name . ' — ' . $shareUrl) }}" target="_blank" rel="noopener" class="ss-btn ss-btn--sm"><i class="bi bi-whatsapp"></i> WhatsApp</a>
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($artist->name) }}&url={{ urlencode($shareUrl) }}" target="_blank" rel="noopener" class="ss-btn ss-btn--sm"><i class="bi bi-twitter-x"></i> Post</a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank" rel="noopener" class="ss-btn ss-btn--sm"><i class="bi bi-facebook"></i> Share</a>
          </div>

          <div class="as-qr">
            <img src="{{ route('artist.qr', $artist) }}" alt="QR code for {{ $artist->name }}'s page" loading="lazy">
            <div>
              <p>Scan to open this page — perfect for posters, flyers and cover art.</p>
              <a href="{{ route('artist.qr', $artist) }}" download="{{ $artist->slug }}-qr.png" class="ss-btn ss-btn--sm">
                <i class="bi bi-download"></i> Download QR
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
