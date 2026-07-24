{{--
  Artist micro-site — Phase 1 provisional version.
  The full premium design lands in Phase 3; this version already proves the
  core concept: /{slug} URL, per-artist share (OG) meta, and every content
  section with graceful empty states.
--}}
@extends('layouts.front')

@section('title', $artist->name . ' | Official Page — Supremacy Studios')
@section('description', Str::limit(strip_tags($artist->bio), 155))
@section('og_title', $artist->name . ' — ' . ($artist->tagline ?: 'Supremacy Studios Artist'))
@section('og_description', Str::limit(strip_tags($artist->bio), 200))
@section('og_image', $artist->photo_url)
@section('twitter_title', $artist->name . ' — Supremacy Studios')
@section('twitter_description', Str::limit(strip_tags($artist->bio), 200))
@section('twitter_image', $artist->photo_url)

@push('meta')
  <meta property="og:type" content="profile">
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "MusicGroup",
    "name": @json($artist->name),
    "genre": @json($artist->genre),
    "description": @json(Str::limit(strip_tags($artist->bio), 300)),
    "image": @json($artist->photo_url),
    "url": @json(url('/' . $artist->slug)),
    "memberOf": {
      "@type": "Organization",
      "name": "Supremacy Studios",
      "url": @json(url('/'))
    }
  }
  </script>
@endpush

@section('content')

  {{-- Hero --}}
  <section class="text-white text-center d-flex align-items-end"
           style="min-height: 60vh; background: linear-gradient(rgba(0,0,0,.35), rgba(0,0,0,.85)), url('{{ $artist->cover_image_url }}') center/cover;">
    <div class="container pb-5">
      <img src="{{ $artist->photo_url }}" alt="{{ $artist->name }}" class="rounded-circle border border-3 border-white mb-3" style="width:120px;height:120px;object-fit:cover;">
      <h1 class="fw-bold display-4">{{ $artist->name }}</h1>
      @if ($artist->tagline)
        <p class="lead">{{ $artist->tagline }}</p>
      @endif
      <p class="small text-uppercase">{{ $artist->genre }} — {{ $artist->location }}</p>

      <div class="d-flex justify-content-center gap-2 flex-wrap">
        @foreach ($artist->links->where('type', 'social') as $link)
          <a href="{{ $link->url }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-light text-capitalize">{{ str_replace('-', ' ', $link->platform) }}</a>
        @endforeach
        <button class="btn btn-sm btn-light" id="shareArtistBtn" data-share-url="{{ url('/' . $artist->slug) }}" data-share-title="{{ $artist->name }} — Supremacy Studios">
          <i class="bi bi-share me-1"></i> Share
        </button>
      </div>
    </div>
  </section>

  <div class="container py-5">

    {{-- Bio --}}
    <section class="mb-5">
      <h2 class="fw-bold">About</h2>
      <p style="white-space: pre-line;">{{ $artist->bio }}</p>
    </section>

    {{-- Streaming --}}
    <section class="mb-5">
      <h2 class="fw-bold">Listen On</h2>
      @if ($artist->links->where('type', 'streaming')->count())
        <div class="d-flex gap-2 flex-wrap">
          @foreach ($artist->links->where('type', 'streaming') as $link)
            <a href="{{ $link->url }}" target="_blank" rel="noopener" class="btn btn-dark text-capitalize">{{ str_replace('-', ' ', $link->platform) }}</a>
          @endforeach
        </div>
      @else
        <p class="text-muted">Streaming links coming soon.</p>
      @endif
    </section>

    {{-- Albums --}}
    <section class="mb-5">
      <h2 class="fw-bold">Albums</h2>
      @if ($artist->albums->count())
        <div class="row g-4">
          @foreach ($artist->albums as $album)
            <div class="col-6 col-md-3">
              <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="img-fluid rounded mb-2" style="aspect-ratio:1;object-fit:cover;">
              <strong>{{ $album->title }}</strong>
              <div class="text-muted small">{{ optional($album->release_date)->format('Y') }}
                @if ($album->price) — UGX {{ number_format($album->price) }} @endif
              </div>
            </div>
          @endforeach
        </div>
      @else
        <p class="text-muted">{{ $artist->name }} has no albums out yet — the first project is loading.</p>
      @endif
    </section>

    {{-- Singles --}}
    <section class="mb-5">
      <h2 class="fw-bold">Singles</h2>
      @if ($artist->singles->count())
        <ul class="list-group">
          @foreach ($artist->singles as $track)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>
                <strong>{{ $track->title }}</strong>
                <span class="text-muted small ms-2">{{ optional($track->release_date)->format('M Y') }}</span>
              </span>
              <span>
                @if ($track->is_free)
                  <span class="badge bg-success">Free</span>
                @elseif ($track->price)
                  <span class="badge bg-dark">UGX {{ number_format($track->price) }}</span>
                @endif
              </span>
            </li>
          @endforeach
        </ul>
      @else
        <p class="text-muted">No singles released yet.</p>
      @endif
    </section>

    {{-- Videos --}}
    <section class="mb-5">
      <h2 class="fw-bold">Videos</h2>
      @if ($artist->videos->count())
        <div class="row g-4">
          @foreach ($artist->videos as $video)
            <div class="col-md-6">
              <div class="ratio ratio-16x9">
                <iframe src="{{ $video->embed_url }}" title="{{ $video->title }}" allowfullscreen loading="lazy"></iframe>
              </div>
              <p class="mt-2 mb-0"><strong>{{ $video->title }}</strong></p>
            </div>
          @endforeach
        </div>
      @else
        <p class="text-muted">No videos yet — stay tuned.</p>
      @endif
    </section>

    {{-- Merch --}}
    <section class="mb-5">
      <h2 class="fw-bold">Merch</h2>
      @if ($artist->products->count())
        <div class="row g-4">
          @foreach ($artist->products as $product)
            <div class="col-6 col-md-3">
              <img src="{{ $product->first_image_url }}" alt="{{ $product->name }}" class="img-fluid rounded mb-2" style="aspect-ratio:1;object-fit:cover;">
              <strong>{{ $product->name }}</strong>
              <div class="text-muted">UGX {{ number_format($product->price) }}</div>
            </div>
          @endforeach
        </div>
      @else
        <p class="text-muted">No merch available yet.</p>
      @endif
    </section>

    {{-- Events --}}
    <section class="mb-5">
      <h2 class="fw-bold">Upcoming Shows</h2>
      @if ($upcomingEvents->count())
        <ul class="list-group">
          @foreach ($upcomingEvents as $event)
            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2">
              <span>
                <strong>{{ $event->title }}</strong><br>
                <span class="text-muted small">{{ $event->venue }}, {{ $event->city }} — {{ $event->starts_at->format('D d M Y, g:ia') }}</span>
              </span>
              <span class="badge bg-dark">{{ $event->price_info }}</span>
            </li>
          @endforeach
        </ul>
      @else
        <p class="text-muted">{{ $artist->name }} has no upcoming shows right now. Check back soon.</p>
      @endif
    </section>

    {{-- Subscriptions --}}
    @if ($artist->subscriptionPlans->count())
      <section class="mb-5">
        <h2 class="fw-bold">Join the Fan Club</h2>
        <div class="row g-4">
          @foreach ($artist->subscriptionPlans as $plan)
            <div class="col-md-4">
              <div class="border rounded p-4 h-100">
                <h5 class="fw-bold">{{ $plan->name }}</h5>
                <p class="display-6">UGX {{ number_format($plan->price) }}<small class="fs-6 text-muted">/{{ $plan->interval }}</small></p>
                <ul class="small">
                  @foreach ($plan->perks ?? [] as $perk)
                    <li>{{ $perk }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          @endforeach
        </div>
      </section>
    @endif

    <p class="text-center text-muted small border-top pt-4">
      {{ $artist->name }} is an artist under <a href="{{ url('/') }}" class="text-decoration-none">Supremacy Studios</a>, Kampala.
    </p>
  </div>

@endsection

@push('scripts')
<script>
  document.getElementById('shareArtistBtn').addEventListener('click', function () {
    var url = this.dataset.shareUrl;
    var title = this.dataset.shareTitle;
    if (navigator.share) {
      navigator.share({ title: title, url: url });
    } else {
      navigator.clipboard.writeText(url).then(function () {
        alert('Link copied: ' + url);
      });
    }
  });
</script>
@endpush
