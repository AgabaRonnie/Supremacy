@extends('layouts.front')

@section('title', 'Sign With Us | Supremacy Studios — Submit Your Demo')
@section('description', 'Want to be a Supremacy Studios artist? Learn how signing works and submit your demo to the label.')

@section('content')

  <section class="ss-page-hero">
    <div class="ss-container">
      <span class="ss-label">The Door</span>
      <h1 class="ss-page-hero__title">Sign With Us</h1>
      <p class="ss-lead">If the music is undeniable, we want to hear it.</p>
    </div>
  </section>

  <section class="ss-section">
    <div class="ss-container">
      <div class="row g-5">
        <div class="col-lg-5 reveal">
          <span class="ss-label">How It Works</span>
          <h2 class="ss-h2">Three steps in.</h2>

          <div class="mt-4">
            <div class="ss-service-row" style="grid-template-columns: 3.4rem 1fr;">
              <span class="ss-service-row__num">01</span>
              <span>
                <span class="ss-service-row__title d-block" style="font-size: 1.2rem;">Send your demo</span>
                <p class="ss-service-row__summary">Links to your best 2–3 songs. Quality over quantity.</p>
              </span>
            </div>
            <div class="ss-service-row" style="grid-template-columns: 3.4rem 1fr;">
              <span class="ss-service-row__num">02</span>
              <span>
                <span class="ss-service-row__title d-block" style="font-size: 1.2rem;">We listen. Properly.</span>
                <p class="ss-service-row__summary">Every submission is heard by the label team.</p>
              </span>
            </div>
            <div class="ss-service-row" style="grid-template-columns: 3.4rem 1fr;">
              <span class="ss-service-row__num">03</span>
              <span>
                <span class="ss-service-row__title d-block" style="font-size: 1.2rem;">The call</span>
                <p class="ss-service-row__summary">If it's a fit, we invite you to the studio in Nankulabye — and we build from there.</p>
              </span>
            </div>
          </div>
        </div>

        <div class="col-lg-7 reveal">
          @if (session('demo_success'))
            <div class="ss-alert">{{ session('demo_success') }}</div>
          @endif
          @if ($errors->any())
            <div class="ss-alert ss-alert--error">{{ $errors->first() }}</div>
          @endif

          <form method="POST" action="{{ route('demo.submit') }}" class="ss-form">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label for="name">Your Name *</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
              </div>
              <div class="col-md-6">
                <label for="artist_name">Artist / Stage Name</label>
                <input type="text" class="form-control" id="artist_name" name="artist_name" value="{{ old('artist_name') }}">
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
                <label for="genre">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" value="{{ old('genre') }}" placeholder="e.g. Afrobeat, R&B, Hip-Hop">
              </div>
              <div class="col-12">
                <label for="links">Links to Your Music *</label>
                <textarea class="form-control" id="links" name="links" rows="3" placeholder="YouTube, Audiomack, SoundCloud, Google Drive... one per line" required>{{ old('links') }}</textarea>
              </div>
              <div class="col-12">
                <label for="message">Tell us about you</label>
                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Who are you, and where do you want to go?">{{ old('message') }}</textarea>
              </div>
              <div class="col-12">
                <button type="submit" class="ss-btn ss-btn--solid">Submit Demo</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

@endsection
