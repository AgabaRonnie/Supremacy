<!-- Navigation -->
<header class="ss-nav" id="ssNav">
  <div class="ss-nav__inner">
    <a class="ss-nav__brand" href="{{ url('/') }}" aria-label="Supremacy Studios — Home">
      SUPREMACY<span>STUDIOS</span>
    </a>

    <nav class="ss-nav__links" aria-label="Main">
      <a href="{{ url('/artists') }}" class="{{ request()->is('artists') ? 'is-active' : '' }}">Artists</a>
      <a href="{{ url('/studio') }}" class="{{ request()->is('studio') ? 'is-active' : '' }}">Studio</a>
      <a href="{{ url('/services') }}" class="{{ request()->is('services*') ? 'is-active' : '' }}">Services</a>
      <a href="{{ url('/events') }}" class="{{ request()->is('events*') ? 'is-active' : '' }}">Events</a>
      <a href="{{ url('/news') }}" class="{{ request()->is('news*') ? 'is-active' : '' }}">News</a>
      <a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'is-active' : '' }}">About</a>
      <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'is-active' : '' }}">Contact</a>
    </nav>

    <div class="ss-nav__cta">
      <a href="{{ url('/studio') }}#book" class="ss-btn ss-btn--solid ss-btn--sm">Book a Session</a>
    </div>

    <button class="ss-nav__toggle" id="ssNavToggle" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span>
    </button>
  </div>
</header>

<!-- Mobile full-screen menu -->
<div class="ss-menu" id="ssMenu" aria-hidden="true">
  <nav class="ss-menu__links" aria-label="Mobile">
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ url('/artists') }}">Artists</a>
    <a href="{{ url('/studio') }}">Studio</a>
    <a href="{{ url('/services') }}">Services</a>
    <a href="{{ url('/events') }}">Events</a>
    <a href="{{ url('/news') }}">News</a>
    <a href="{{ url('/about') }}">About</a>
    <a href="{{ url('/contact') }}">Contact</a>
    <a href="{{ url('/join') }}">Sign With Us</a>
  </nav>
  <div class="ss-menu__foot">
    <a href="{{ url('/studio') }}#book" class="ss-btn ss-btn--solid">Book a Session</a>
    <p>Nankulabye, Makerere Hill Road, Kampala</p>
  </div>
</div>
