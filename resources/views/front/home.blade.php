@extends('layouts.front')

@section('title', 'Supremacy Studios | Music Label & Recording Studio — Kampala, Uganda')

@section('content')

  {{-- ============ HERO ============ --}}
  <section class="ss-hero">
    <div class="ss-hero__bg" aria-hidden="true">
      <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=2000&q=80" alt="">
      <img src="https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?auto=format&fit=crop&w=2000&q=80" alt="">
      <img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=2000&q=80" alt="">
    </div>

    <div class="ss-container ss-hero__content">
      <h1 class="ss-hero__title">
        <span class="line"><span>Supremacy</span></span>
        <span class="line"><span>Studios</span></span>
      </h1>
      <p class="ss-hero__sub">Kampala's home of sound. A music label &amp; recording studio building the artists the world will hear next.</p>
      <div class="ss-hero__cta">
        <a href="{{ url('/artists') }}" class="ss-btn ss-btn--solid">Meet the Artists</a>
        <a href="{{ url('/studio') }}#book" class="ss-btn">Book a Session</a>
      </div>
    </div>

    <span class="ss-hero__scroll" aria-hidden="true">Scroll</span>
  </section>

  {{-- ============ ARTIST NAME MARQUEE ============ --}}
  <div class="ss-marquee" aria-hidden="true">
    <div class="ss-marquee__track">
      @for ($i = 0; $i < 2; $i++)
        @foreach ($artists as $artist)
          <span>{{ $artist->name }}</span>
        @endforeach
        <span>Supremacy Studios</span>
      @endfor
    </div>
  </div>

  {{-- ============ THE ROSTER ============ --}}
  <section class="ss-section">
    <div class="ss-container">
      <div class="ss-section__head reveal">
        <div>
          <span class="ss-label">The Roster</span>
          <h2 class="ss-h2">The Artists</h2>
          <p class="ss-lead">Every artist here is a world of their own. Step inside.</p>
        </div>
        <a href="{{ url('/artists') }}" class="ss-more">All Artists <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="ss-roster reveal">
        @foreach ($artists as $i => $artist)
          <a href="{{ url('/' . $artist->slug) }}" class="ss-roster__card" aria-label="{{ $artist->name }}">
            <img src="{{ $artist->photo_url }}" alt="{{ $artist->name }}" loading="lazy">
            <span class="ss-roster__num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
            <span class="ss-roster__meta">
              <span class="ss-roster__name d-block">{{ $artist->name }}</span>
              <span class="ss-roster__genre">{{ $artist->genre }}</span>
            </span>
            <span class="ss-roster__arrow" aria-hidden="true"><i class="bi bi-arrow-up-right"></i></span>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ============ OUT NOW ============ --}}
  @if ($latestRelease)
    <section class="ss-section ss-outnow">
      <div class="ss-container">
        <div class="row align-items-center g-5">
          <div class="col-md-5 reveal">
            <a href="{{ route('track.smartlink', [$latestRelease->artist, $latestRelease]) }}" class="ss-outnow__cover d-block">
              <img src="{{ $latestRelease->cover_url }}" alt="{{ $latestRelease->title }} — {{ $latestRelease->artist->name }}" loading="lazy">
            </a>
          </div>
          <div class="col-md-7 reveal">
            <span class="ss-label">Out Now</span>
            <h2 class="ss-outnow__title">
              <a href="{{ route('track.smartlink', [$latestRelease->artist, $latestRelease]) }}">{{ $latestRelease->title }}</a>
            </h2>
            <p class="ss-outnow__artist">{{ $latestRelease->artist->name }}
              @if ($latestRelease->release_date) · {{ $latestRelease->release_date->format('F Y') }} @endif
            </p>
            <div class="ss-platforms">
              @foreach ($latestRelease->links ?? [] as $platform => $url)
                <a href="{{ route('go.track', [$latestRelease, $platform]) }}" class="ss-platform">{{ str_replace('-', ' ', $platform) }}</a>
              @endforeach
              <a href="{{ route('track.smartlink', [$latestRelease->artist, $latestRelease]) }}" class="ss-platform"><strong>+ All Platforms</strong></a>
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif

  {{-- ============ WHAT WE DO ============ --}}
  <section class="ss-section ss-services">
    <div class="ss-container">
      <div class="ss-section__head reveal">
        <div>
          <span class="ss-label">What We Do</span>
          <h2 class="ss-h2">A Full-Service Label</h2>
        </div>
        <a href="{{ url('/services') }}" class="ss-more">Our Services <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="reveal">
        @foreach ($services as $i => $service)
          <a href="{{ url('/services') }}#{{ $service->slug }}" class="ss-service-row">
            <span class="ss-service-row__num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
            <span>
              <span class="ss-service-row__title d-block">{{ $service->title }}</span>
              <p class="ss-service-row__summary">{{ $service->summary }}</p>
            </span>
            <span class="ss-service-row__arrow" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
          </a>
        @endforeach
      </div>
    </div>
  </section>

  {{-- ============ THE STUDIO ============ --}}
  <section class="ss-studio-band">
    <div class="ss-studio-band__bg" style="background-image: url('https://images.unsplash.com/photo-1524650359799-842906ca1c06?auto=format&fit=crop&w=2000&q=80');" aria-hidden="true"></div>
    <div class="ss-container reveal">
      <span class="ss-label">The Studio</span>
      <h2 class="ss-h2">Recorded at<br>Nankulabye.</h2>
      <p class="ss-lead mb-4">Our recording studio on Makerere Hill Road is where every Supremacy record is born — free for our artists, open for everyone else.</p>
      <a href="{{ url('/studio') }}#book" class="ss-btn ss-btn--solid">Book a Session</a>
    </div>
  </section>

  {{-- ============ UPCOMING ============ --}}
  <section class="ss-section">
    <div class="ss-container">
      <div class="ss-section__head reveal">
        <div>
          <span class="ss-label">Live</span>
          <h2 class="ss-h2">Upcoming</h2>
        </div>
        <a href="{{ url('/events') }}" class="ss-more">All Events <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="reveal">
        @forelse ($upcomingEvents as $event)
          <a href="{{ url('/events') }}" class="ss-event-row">
            <span class="ss-event-row__date">
              <span class="d">{{ $event->starts_at->format('d') }}</span>
              <span class="m">{{ $event->starts_at->format('M Y') }}</span>
            </span>
            <span>
              <span class="ss-event-row__title d-block">{{ $event->title }}</span>
              <p class="ss-event-row__venue">
                {{ $event->venue }}, {{ $event->city }}
                @if ($event->artist) — {{ $event->artist->name }} @endif
              </p>
            </span>
            <span class="ss-event-row__price">{{ $event->price_info }}</span>
            <span class="ss-service-row__arrow" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
          </a>
        @empty
          <div class="ss-empty">
            <i class="bi bi-calendar-x"></i>
            No upcoming events right now — follow us and you'll be the first to know.
          </div>
        @endforelse
      </div>
    </div>
  </section>

  {{-- ============ NEWS ============ --}}
  @if ($news->count())
    <section class="ss-section pt-0">
      <div class="ss-container">
        <div class="ss-section__head reveal">
          <div>
            <span class="ss-label">Latest</span>
            <h2 class="ss-h2">From the Label</h2>
          </div>
          <a href="{{ url('/news') }}" class="ss-more">All News <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row g-4 reveal">
          @foreach ($news as $post)
            <div class="col-md-6">
              <a href="{{ route('front.news.show', $post) }}" class="ss-news-card">
                <span class="ss-news-card__img d-block">
                  <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="lazy">
                </span>
                <span class="ss-news-card__date">{{ $post->published_at->format('d M Y') }}</span>
                <span class="ss-news-card__title d-block">{{ $post->title }}</span>
                <p class="ss-news-card__excerpt">{{ $post->excerpt }}</p>
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

@endsection
