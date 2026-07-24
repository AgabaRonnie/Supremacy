@extends('layouts.front')

@section('title', $post->title . ' | Supremacy Studios News')
@section('description', $post->excerpt)
@section('og_title', $post->title)
@section('og_description', $post->excerpt)
@section('og_image', $post->image_url)

@push('meta')
  <meta property="og:type" content="article">
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "NewsArticle",
    "headline": @json($post->title),
    "description": @json($post->excerpt),
    "image": @json($post->image_url),
    "datePublished": @json($post->published_at->toIso8601String()),
    "publisher": { "@type": "Organization", "name": "Supremacy Studios", "url": @json(url('/')) }
  }
  </script>
@endpush

@section('content')

  <section class="ss-page-hero">
    <div class="ss-container">
      <span class="ss-label">{{ $post->published_at->format('d M Y') }}</span>
      <h1 class="ss-page-hero__title" style="font-size: clamp(2rem, 5.5vw, 4.2rem); text-transform: none;">{{ $post->title }}</h1>
    </div>
  </section>

  <section class="ss-section">
    <div class="ss-container">
      <div class="row">
        <div class="col-lg-9 mx-auto">
          <div class="ss-news-card__img reveal" style="aspect-ratio: 16/8;">
            <img src="{{ $post->image_url }}" alt="{{ $post->title }}">
          </div>
          <div class="reveal mt-4" style="font-size: 1.12rem; max-width: 70ch;">
            {!! nl2br(e($post->body)) !!}
          </div>

          @if ($more->count())
            <div class="ss-section__head reveal mt-5 pt-5" style="border-top: 1px solid var(--ss-border);">
              <div><span class="ss-label">More News</span></div>
            </div>
            <div class="row g-4">
              @foreach ($more as $other)
                <div class="col-md-6 reveal">
                  <a href="{{ route('front.news.show', $other) }}" class="ss-news-card">
                    <span class="ss-news-card__date">{{ $other->published_at->format('d M Y') }}</span>
                    <span class="ss-news-card__title d-block">{{ $other->title }}</span>
                  </a>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>

@endsection
