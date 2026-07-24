{{--
  Artist micro-site layout.
  Deliberately NOT the main site layout: the artist page should feel like the
  artist's own official website, with Supremacy Studios present only as a
  quiet signature. Shares the same design system (custom.css).
--}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>@yield('title')</title>
  <meta name="description" content="@yield('description')">
  <meta name="author" content="@yield('author', 'Supremacy Studios')">
  <meta name="robots" content="index, follow">

  <!-- Open Graph -->
  <meta property="og:title" content="@yield('og_title')">
  <meta property="og:description" content="@yield('og_description')">
  <meta property="og:image" content="@yield('og_image')">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:type" content="profile">
  <meta property="og:site_name" content="Supremacy Studios">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="@yield('og_title')">
  <meta name="twitter:description" content="@yield('og_description')">
  <meta name="twitter:image" content="@yield('og_image')">

  <!-- Favicons -->
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

  <link rel="canonical" href="{{ url()->current() }}">

  <!-- Fonts -->
  <link rel="preconnect" href="https://api.fontshare.com" crossorigin>
  <link href="https://api.fontshare.com/v2/css?f[]=clash-display@400,500,600,700&f[]=satoshi@400,500,700&display=swap" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('custom/custom.css') }}">

  @stack('meta')
</head>

<body class="ss-body">

  @yield('content')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('custom/custom.js') }}"></script>

  @stack('scripts')
</body>
</html>
