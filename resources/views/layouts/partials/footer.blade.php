<!-- Footer -->
@php
  $ss = fn ($k, $d = '') => \App\Models\SiteSetting::get($k, $d);
@endphp
<footer class="ss-footer">
  <div class="ss-footer__wordmark reveal" aria-hidden="true">SUPREMACY</div>

  <div class="ss-container">
    <div class="row g-5 ss-footer__grid">
      <div class="col-lg-4">
        <div class="ss-footer__logo-card">
          <img src="{{ asset('img/final_logo.JPG') }}" alt="Supremacy Studios logo">
        </div>
        <p class="ss-footer__tag">Music label &amp; recording studio.<br>Kampala, Uganda.</p>
      </div>

      <div class="col-6 col-lg-2">
        <h6>Label</h6>
        <ul>
          <li><a href="{{ url('/artists') }}">Artists</a></li>
          <li><a href="{{ url('/services') }}">Services</a></li>
          <li><a href="{{ url('/events') }}">Events</a></li>
          <li><a href="{{ url('/news') }}">News</a></li>
        </ul>
      </div>

      <div class="col-6 col-lg-2">
        <h6>Studio</h6>
        <ul>
          <li><a href="{{ url('/studio') }}">The Studio</a></li>
          <li><a href="{{ url('/studio') }}#book">Book a Session</a></li>
          <li><a href="{{ url('/join') }}">Sign With Us</a></li>
          <li><a href="{{ url('/about') }}">About</a></li>
        </ul>
      </div>

      <div class="col-lg-4">
        <h6>Contact</h6>
        <ul class="ss-footer__contact">
          <li>{{ $ss('address', 'Nankulabye, Makerere Hill Road, Kampala, Uganda') }}</li>
          <li><a href="tel:{{ str_replace(' ', '', $ss('phone')) }}">{{ $ss('phone') }}</a></li>
          <li><a href="mailto:{{ $ss('email') }}">{{ $ss('email') }}</a></li>
          <li>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ss('whatsapp')) }}" target="_blank" rel="noopener" class="ss-footer__wa">
              <i class="bi bi-whatsapp me-1"></i> Chat on WhatsApp
            </a>
          </li>
        </ul>
        <div class="ss-footer__social">
          @foreach (['instagram' => 'bi-instagram', 'x' => 'bi-twitter-x', 'youtube' => 'bi-youtube', 'tiktok' => 'bi-tiktok', 'facebook' => 'bi-facebook'] as $key => $icon)
            @if ($ss($key))
              <a href="{{ $ss($key) }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($key) }}"><i class="bi {{ $icon }}"></i></a>
            @endif
          @endforeach
        </div>
      </div>
    </div>

    <div class="ss-footer__bottom">
      <span>&copy; {{ date('Y') }} Supremacy Studios. All rights reserved.</span>
      <span>Nankulabye · Kampala · Uganda</span>
    </div>
  </div>
</footer>
