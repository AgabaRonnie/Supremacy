@extends('layouts.front')

@section('title', 'News | Supremacy Studios')
@section('description', 'Signings, releases, shows and stories from Supremacy Studios, Kampala.')

@section('content')

  <section class="ss-page-hero">
    <div class="ss-container">
      <span class="ss-label">The Label</span>
      <h1 class="ss-page-hero__title">News</h1>
      <p class="ss-lead">Signings, releases and stories from the house.</p>
    </div>
  </section>

  <section class="ss-section">
    <div class="ss-container">
      <div class="row g-4">
        @forelse ($posts as $post)
          <div class="col-md-6 col-lg-4 reveal">
            <a href="{{ route('front.news.show', $post) }}" class="ss-news-card">
              <span class="ss-news-card__img d-block">
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="lazy">
              </span>
              <span class="ss-news-card__date">{{ $post->published_at->format('d M Y') }}</span>
              <span class="ss-news-card__title d-block">{{ $post->title }}</span>
              <p class="ss-news-card__excerpt">{{ $post->excerpt }}</p>
            </a>
          </div>
        @empty
          <div class="col-12">
            <div class="ss-empty"><i class="bi bi-newspaper"></i> No stories yet — the first headlines are coming.</div>
          </div>
        @endforelse
      </div>

      @if ($posts->hasPages())
        <div class="mt-5 d-flex justify-content-center">
          {{ $posts->links() }}
        </div>
      @endif
    </div>
  </section>

@endsection
