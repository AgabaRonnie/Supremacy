{{--
  Electronic Press Kit — deliberately white/print-first so promoters and media
  can hit Print -> Save as PDF and get a clean one-pager.
--}}
@php
  $ss = fn ($k, $d = '') => \App\Models\SiteSetting::get($k, $d);
  $socials = $artist->links->where('type', 'social');
  $streams = $artist->links->where('type', 'streaming');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $artist->name }} — Electronic Press Kit | Supremacy Studios</title>
  <meta name="description" content="Official press kit for {{ $artist->name }} — {{ $artist->genre }} artist at Supremacy Studios, Kampala.">
  <meta name="robots" content="noindex">
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link rel="preconnect" href="https://api.fontshare.com" crossorigin>
  <link href="https://api.fontshare.com/v2/css?f[]=clash-display@400,500,600,700&f[]=satoshi@400,500,700&display=swap" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Satoshi', Arial, sans-serif; background: #fff; color: #0a0a0a; line-height: 1.6; }
    .epk { max-width: 860px; margin: 0 auto; padding: 3rem 2rem; }
    .epk-top { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #0a0a0a; padding-bottom: 1rem; margin-bottom: 2rem; }
    .epk-top__label { font-family: 'Clash Display', sans-serif; font-weight: 600; letter-spacing: 0.18em; font-size: 0.95rem; }
    .epk-top__tag { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.25em; color: #666; }
    .epk-head { display: grid; grid-template-columns: 220px 1fr; gap: 2rem; margin-bottom: 2.2rem; align-items: start; }
    .epk-head img { width: 100%; aspect-ratio: 1; object-fit: cover; filter: grayscale(1); }
    .epk-name { font-family: 'Clash Display', sans-serif; font-weight: 700; font-size: 3rem; line-height: 1; text-transform: uppercase; margin-bottom: 0.4rem; }
    .epk-tagline { font-size: 1.1rem; color: #333; margin-bottom: 0.7rem; }
    .epk-facts { display: flex; flex-wrap: wrap; gap: 0.5rem 1.6rem; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.14em; color: #555; margin-bottom: 1rem; }
    .epk-stats { display: flex; gap: 2rem; }
    .epk-stat strong { font-family: 'Clash Display', sans-serif; font-size: 1.6rem; display: block; line-height: 1.1; }
    .epk-stat span { font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.18em; color: #666; }
    .epk h2 { font-family: 'Clash Display', sans-serif; font-weight: 600; font-size: 1.05rem; text-transform: uppercase; letter-spacing: 0.2em; border-bottom: 1px solid #0a0a0a; padding-bottom: 0.4rem; margin: 1.8rem 0 0.9rem; }
    .epk-bio { white-space: pre-line; font-size: 0.98rem; }
    .epk-cols { display: grid; grid-template-columns: 1fr 1fr; gap: 0 2.5rem; }
    .epk ul { list-style: none; }
    .epk li { padding: 0.35rem 0; border-bottom: 1px dotted #ccc; font-size: 0.92rem; display: flex; justify-content: space-between; gap: 1rem; }
    .epk li small { color: #666; white-space: nowrap; }
    .epk-links { display: flex; flex-wrap: wrap; gap: 0.4rem 1.4rem; font-size: 0.88rem; }
    .epk-links a { color: #0a0a0a; }
    .epk-foot { display: grid; grid-template-columns: 1fr auto; gap: 2rem; align-items: center; border-top: 3px solid #0a0a0a; margin-top: 2.2rem; padding-top: 1.4rem; }
    .epk-foot p { font-size: 0.9rem; }
    .epk-foot img { width: 110px; height: 110px; }
    .epk-print { position: fixed; right: 1.5rem; bottom: 1.5rem; background: #0a0a0a; color: #fff; border: 0; font-family: 'Satoshi', sans-serif; font-weight: 700; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.14em; padding: 0.9rem 1.6rem; cursor: pointer; }
    @media (max-width: 700px) { .epk-head, .epk-cols, .epk-foot { grid-template-columns: 1fr; } .epk-name { font-size: 2.2rem; } }
    @media print {
      .epk-print { display: none; }
      .epk { padding: 0; max-width: none; }
      a { text-decoration: none; color: #0a0a0a; }
    }
  </style>
</head>
<body>
  <div class="epk">
    <div class="epk-top">
      <span class="epk-top__label">SUPREMACY STUDIOS</span>
      <span class="epk-top__tag">Electronic Press Kit · {{ now()->format('Y') }}</span>
    </div>

    <div class="epk-head">
      <img src="{{ $artist->photo_url }}" alt="{{ $artist->name }}">
      <div>
        <h1 class="epk-name">{{ $artist->name }}</h1>
        @if ($artist->tagline)<p class="epk-tagline">“{{ $artist->tagline }}”</p>@endif
        <div class="epk-facts">
          @if ($artist->genre)<span>{{ $artist->genre }}</span>@endif
          @if ($artist->location)<span>{{ $artist->location }}</span>@endif
          @if ($artist->joined_year)<span>Signed {{ $artist->joined_year }}</span>@endif
        </div>
        <div class="epk-stats">
          <div class="epk-stat"><strong>{{ $artist->tracks->count() }}</strong><span>Releases</span></div>
          <div class="epk-stat"><strong>{{ $artist->albums->count() }}</strong><span>Albums / EPs</span></div>
          <div class="epk-stat"><strong>{{ $pastEventsCount }}</strong><span>Shows Played</span></div>
        </div>
      </div>
    </div>

    <h2>Biography</h2>
    <p class="epk-bio">{{ $artist->bio }}</p>

    <div class="epk-cols">
      <div>
        <h2>Selected Releases</h2>
        <ul>
          @foreach ($artist->tracks->take(6) as $t)
            <li><span>{{ $t->title }}</span><small>{{ optional($t->release_date)->format('M Y') }}</small></li>
          @endforeach
        </ul>
      </div>
      <div>
        <h2>{{ $upcomingEvents->count() ? 'Upcoming Shows' : 'Booking' }}</h2>
        @if ($upcomingEvents->count())
          <ul>
            @foreach ($upcomingEvents->take(5) as $e)
              <li><span>{{ $e->title }} — {{ $e->venue }}</span><small>{{ $e->starts_at->format('d M Y') }}</small></li>
            @endforeach
          </ul>
        @else
          <p style="font-size: 0.92rem;">Currently accepting bookings for shows, festivals and private events through Supremacy Studios.</p>
        @endif
      </div>
    </div>

    <h2>Listen & Follow</h2>
    <div class="epk-links">
      @foreach ($streams as $l)<a href="{{ $l->url }}">{{ ucwords(str_replace('-', ' ', $l->platform)) }}</a>@endforeach
      @foreach ($socials as $l)<a href="{{ $l->url }}">{{ '@' . basename(parse_url($l->url, PHP_URL_PATH) ?: $artist->slug) }} ({{ ucfirst($l->platform) }})</a>@endforeach
    </div>

    <div class="epk-foot">
      <div>
        <p><strong>Bookings & Management</strong></p>
        <p>Supremacy Studios — {{ $ss('address', 'Nankulabye, Makerere Hill Road, Kampala, Uganda') }}</p>
        <p>{{ $ss('phone') }} · {{ $ss('email') }}</p>
        <p>{{ url('/' . $artist->slug) }}</p>
      </div>
      <img src="{{ route('artist.qr', $artist) }}" alt="QR code — {{ $artist->name }}'s page">
    </div>
  </div>

  <button class="epk-print" onclick="window.print()">Print / Save as PDF</button>
</body>
</html>
