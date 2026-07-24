{{-- Streaming platform link inputs. Pass: $links (array|null) --}}
@php
  $platforms = ['spotify' => 'Spotify', 'apple-music' => 'Apple Music', 'boomplay' => 'Boomplay', 'audiomack' => 'Audiomack', 'youtube-music' => 'YouTube Music', 'deezer' => 'Deezer'];
  $links = $links ?? [];
@endphp
<div class="col-12">
  <label class="form-label d-block">Streaming Links</label>
  <div class="row g-2">
    @foreach ($platforms as $key => $label)
      <div class="col-md-6">
        <div class="input-group">
          <span class="input-group-text" style="min-width: 130px;">{{ $label }}</span>
          <input type="url" class="form-control" name="platform_links[{{ $key }}]" value="{{ old('platform_links.' . $key, $links[$key] ?? '') }}" placeholder="https://...">
        </div>
      </div>
    @endforeach
  </div>
</div>
