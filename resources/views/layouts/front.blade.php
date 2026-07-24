<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- SEO Meta Tags -->
  <title>@yield('title', 'Supremacy Studios | Music Label & Recording Studio — Kampala, Uganda')</title>
  <meta name="description" content="@yield('description', 'Supremacy Studios is a music label and recording studio in Kampala, Uganda. Artist management, music distribution, playlist pitching, studio bookings and more.')">
  <meta name="keywords" content="@yield('keywords', 'Supremacy Studios, music label Kampala, recording studio Uganda, music distribution, artist management, studio booking Kampala, Ugandan artists')">
  <meta name="author" content="Supremacy Studios">
  <meta name="robots" content="index, follow">

  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="@yield('og_title', 'Supremacy Studios | Music Label & Recording Studio — Kampala')">
  <meta property="og:description" content="@yield('og_description', 'Music label, recording studio, distribution and artist management in Kampala, Uganda.')">
  <meta property="og:image" content="@yield('og_image', asset('img/final_logo.JPG'))">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Supremacy Studios">

  <!-- Twitter Card Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="@yield('twitter_title', 'Supremacy Studios | Music Label — Kampala')">
  <meta name="twitter:description" content="@yield('twitter_description', 'Music label, recording studio, distribution and artist management in Kampala, Uganda.')">
  <meta name="twitter:image" content="@yield('twitter_image', asset('img/final_logo.JPG'))">

  <!-- Favicons -->
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-chrome-192x192.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
  <link rel="manifest" href="{{ asset('site.webmanifest') }}">

  <!-- Canonical URL -->
  <link rel="canonical" href="@yield('canonical', url()->current())">

  <!-- Fonts: Clash Display (display) + Satoshi (text) -->
  <link rel="preconnect" href="https://api.fontshare.com" crossorigin>
  <link href="https://api.fontshare.com/v2/css?f[]=clash-display@400,500,600,700&f[]=satoshi@400,500,700&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('custom/custom.css') }}">

  <!-- Organization Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Supremacy Studios",
    "description": "Music label and recording studio in Kampala, Uganda.",
    "url": "{{ url('/') }}",
    "logo": "{{ asset('img/final_logo.JPG') }}",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Makerere Hill Road, Nankulabye",
      "addressLocality": "Kampala",
      "addressCountry": "UG"
    }
  }
  </script>

  @stack('meta')
  @stack('styles')
</head>

<body class="ss-body">

  <!-- Preloader -->
  <div class="ss-preloader" id="ssPreloader" aria-hidden="true">
    <span class="ss-preloader__word">SUPREMACY</span>
  </div>

  <!-- Navigation -->
  @include('layouts.partials.navbar')

  <!-- Main Content -->
  <main>
    @yield('content')
  </main>

  <!-- Footer -->
  @include('layouts.partials.footer')

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Custom Scripts -->
  <script src="{{ asset('custom/custom.js') }}"></script>

  @stack('scripts')
</body>
</html>
