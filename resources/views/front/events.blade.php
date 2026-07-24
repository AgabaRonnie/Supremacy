@extends('layouts.front')

@section('title', 'Events | Supremacy Studios — Shows & Live Performances')
@section('description', 'Upcoming shows and live performances from Supremacy Studios and its artists in Kampala and beyond.')

@section('content')

  <section class="ss-page-hero">
    <div class="ss-container">
      <span class="ss-label">Live</span>
      <h1 class="ss-page-hero__title">Events</h1>
      <p class="ss-lead">Where the music meets the people.</p>
    </div>
  </section>

  <section class="ss-section">
    <div class="ss-container">
      <div class="ss-section__head reveal">
        <div>
          <span class="ss-label">Next Up</span>
          <h2 class="ss-h2">Upcoming Shows</h2>
        </div>
      </div>

      <div class="reveal">
        @forelse ($upcoming as $event)
          <div class="ss-event-row">
            <span class="ss-event-row__date">
              <span class="d">{{ $event->starts_at->format('d') }}</span>
              <span class="m">{{ $event->starts_at->format('M Y') }}</span>
            </span>
            <span>
              <span class="ss-event-row__title d-block">{{ $event->title }}</span>
              <p class="ss-event-row__venue">
                {{ $event->venue }}, {{ $event->city }} · {{ $event->starts_at->format('g:ia') }}
                @if ($event->artist) — <a href="{{ url('/' . $event->artist->slug) }}">{{ $event->artist->name }}</a> @endif
              </p>
            </span>
            <span class="ss-event-row__price">{{ $event->price_info }}</span>
            @if ($event->ticket_url)
              <a href="{{ $event->ticket_url }}" target="_blank" rel="noopener" class="ss-btn ss-btn--sm">Tickets</a>
            @else
              <span></span>
            @endif
          </div>
        @empty
          <div class="ss-empty">
            <i class="bi bi-calendar-x"></i>
            No upcoming events right now — follow our socials and you'll be the first to know.
          </div>
        @endforelse
      </div>

      @if ($past->count())
        <div class="ss-section__head reveal mt-5 pt-5">
          <div>
            <span class="ss-label">Archive</span>
            <h2 class="ss-h2">Past Shows</h2>
          </div>
        </div>
        <div class="reveal">
          @foreach ($past as $event)
            <div class="ss-event-row" style="opacity: .55;">
              <span class="ss-event-row__date">
                <span class="d">{{ $event->starts_at->format('d') }}</span>
                <span class="m">{{ $event->starts_at->format('M Y') }}</span>
              </span>
              <span>
                <span class="ss-event-row__title d-block">{{ $event->title }}</span>
                <p class="ss-event-row__venue">{{ $event->venue }}, {{ $event->city }} @if ($event->artist) — {{ $event->artist->name }} @endif</p>
              </span>
              <span class="ss-event-row__price">Played</span>
              <span></span>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </section>

@endsection
