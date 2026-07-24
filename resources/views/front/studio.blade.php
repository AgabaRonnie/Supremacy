@extends('layouts.front')

@section('title', 'The Studio | Supremacy Studios — Recording Studio in Kampala')
@section('description', 'Book a session at the Supremacy Studios recording studio in Nankulabye, Makerere Hill Road, Kampala. Recording, mixing, mastering and production.')

@section('content')

  <section class="ss-page-hero">
    <div class="ss-container">
      <span class="ss-label">Nankulabye · Makerere Hill Road</span>
      <h1 class="ss-page-hero__title">The Studio</h1>
      <p class="ss-lead">Where every Supremacy record is born. Free for our artists — open for yours.</p>
    </div>
  </section>

  {{-- Studio gallery (placeholder imagery — will be replaced with real studio photos) --}}
  <section class="ss-section pb-0">
    <div class="ss-container">
      <div class="row g-3">
        <div class="col-md-8 reveal">
          <div class="ss-news-card__img mb-0" style="aspect-ratio: 16/9;">
            <img src="https://images.unsplash.com/photo-1519892300165-cb5542fb47c7?auto=format&fit=crop&w=1600&q=80" alt="Recording studio control room" loading="lazy">
          </div>
        </div>
        <div class="col-md-4 reveal">
          <div class="ss-news-card__img mb-3" style="aspect-ratio: 16/10.5;">
            <img src="https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?auto=format&fit=crop&w=900&q=80" alt="Vocal booth microphone" loading="lazy">
          </div>
          <div class="ss-news-card__img mb-0" style="aspect-ratio: 16/10.5;">
            <img src="https://images.unsplash.com/photo-1524650359799-842906ca1c06?auto=format&fit=crop&w=900&q=80" alt="Mixing console" loading="lazy">
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- What happens here --}}
  <section class="ss-section">
    <div class="ss-container">
      <div class="row g-5">
        <div class="col-lg-5 reveal">
          <span class="ss-label">The Room</span>
          <h2 class="ss-h2">Built for the record.</h2>
          <p class="ss-lead">Recording, mixing, mastering and full production — engineered by the team behind every Supremacy release.</p>
        </div>
        <div class="col-lg-7 reveal">
          <div class="row g-4">
            <div class="col-6"><div class="ss-stat"><span class="ss-stat__num">24/7</span><span class="ss-stat__label">Session availability</span></div></div>
            <div class="col-6"><div class="ss-stat"><span class="ss-stat__num">100%</span><span class="ss-stat__label">Free for signed artists</span></div></div>
            <div class="col-6"><div class="ss-stat"><span class="ss-stat__num">4+</span><span class="ss-stat__label">Sessions types offered</span></div></div>
            <div class="col-6"><div class="ss-stat"><span class="ss-stat__num">1</span><span class="ss-stat__label">Legendary address</span></div></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Booking form --}}
  <section class="ss-section ss-services" id="book">
    <div class="ss-container">
      <div class="row g-5">
        <div class="col-lg-5 reveal">
          <span class="ss-label">Book a Session</span>
          <h2 class="ss-h2">Lock your time.</h2>
          <p class="ss-lead">Send your request and we'll confirm your slot on a call or WhatsApp. Signed Supremacy artists record free — just walk in.</p>
        </div>
        <div class="col-lg-7 reveal">
          @if (session('booking_success'))
            <div class="ss-alert">{{ session('booking_success') }}</div>
          @endif
          @if ($errors->any())
            <div class="ss-alert ss-alert--error">
              {{ $errors->first() }}
            </div>
          @endif

          <form method="POST" action="{{ route('studio.book') }}" class="ss-form">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label for="name">Name *</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
              </div>
              <div class="col-md-6">
                <label for="phone">Phone / WhatsApp *</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
              </div>
              <div class="col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
              </div>
              <div class="col-md-6">
                <label for="session_type">Session Type</label>
                <select class="form-select" id="session_type" name="session_type">
                  <option value="Recording">Recording</option>
                  <option value="Mixing">Mixing</option>
                  <option value="Mastering">Mastering</option>
                  <option value="Production">Production</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="preferred_date">Preferred Date *</label>
                <input type="date" class="form-control" id="preferred_date" name="preferred_date" value="{{ old('preferred_date') }}" min="{{ date('Y-m-d') }}" required>
              </div>
              <div class="col-md-6">
                <label for="preferred_time">Preferred Time</label>
                <input type="text" class="form-control" id="preferred_time" name="preferred_time" value="{{ old('preferred_time') }}" placeholder="e.g. Afternoon, 2pm - 6pm">
              </div>
              <div class="col-12">
                <label for="message">Anything we should know?</label>
                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Tell us about your project...">{{ old('message') }}</textarea>
              </div>
              <div class="col-12">
                <button type="submit" class="ss-btn ss-btn--solid">Request Session</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

@endsection
