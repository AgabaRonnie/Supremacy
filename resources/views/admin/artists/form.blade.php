@extends('layouts.layoutMaster')

@section('title', $artist->exists ? 'Edit Artist' : 'Add Artist')

@section('content')

@if ($errors->any())
  <div class="alert alert-danger" role="alert">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" enctype="multipart/form-data"
      action="{{ $artist->exists ? route('admin.artists.update', $artist) : route('admin.artists.store') }}">
  @csrf
  @if ($artist->exists)
    @method('PUT')
  @endif

  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">{{ $artist->exists ? 'Edit ' . $artist->name : 'Add Artist' }}</h5></div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="name">Name *</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $artist->name) }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="genre">Genre</label>
              <input type="text" class="form-control" id="genre" name="genre" value="{{ old('genre', $artist->genre) }}" placeholder="e.g. Afrobeat / Dancehall">
            </div>
            <div class="col-12">
              <label class="form-label" for="tagline">Tagline</label>
              <input type="text" class="form-control" id="tagline" name="tagline" value="{{ old('tagline', $artist->tagline) }}" placeholder="One line that defines the artist">
            </div>
            <div class="col-12">
              <label class="form-label" for="bio">Bio</label>
              <textarea class="form-control" id="bio" name="bio" rows="6">{{ old('bio', $artist->bio) }}</textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="location">Location</label>
              <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $artist->location ?? 'Kampala, Uganda') }}">
            </div>
            <div class="col-md-3">
              <label class="form-label" for="joined_year">Joined Year</label>
              <input type="number" class="form-control" id="joined_year" name="joined_year" value="{{ old('joined_year', $artist->joined_year) }}">
            </div>
            <div class="col-md-3">
              <label class="form-label" for="sort_order">Sort Order</label>
              <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $artist->sort_order ?? 0) }}">
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Social & Streaming Links</h5>
          <button type="button" class="btn btn-sm btn-outline-primary" id="addLinkRow">
            <i class="bx bx-plus me-1"></i> Add Link
          </button>
        </div>
        <div class="card-body">
          <div id="linkRows">
            @foreach (old('links', $artist->exists ? $artist->links->map(fn ($l) => ['type' => $l->type, 'platform' => $l->platform, 'url' => $l->url])->toArray() : []) as $i => $link)
              <div class="row g-2 mb-2 link-row">
                <div class="col-md-2">
                  <select class="form-select" name="links[{{ $i }}][type]">
                    <option value="social" {{ ($link['type'] ?? '') === 'social' ? 'selected' : '' }}>Social</option>
                    <option value="streaming" {{ ($link['type'] ?? '') === 'streaming' ? 'selected' : '' }}>Streaming</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <input type="text" class="form-control" name="links[{{ $i }}][platform]" placeholder="Platform (e.g. instagram)" value="{{ $link['platform'] ?? '' }}">
                </div>
                <div class="col-md-6">
                  <input type="url" class="form-control" name="links[{{ $i }}][url]" placeholder="https://..." value="{{ $link['url'] ?? '' }}">
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-outline-danger remove-link"><i class="bx bx-x"></i></button>
                </div>
              </div>
            @endforeach
          </div>
          <small class="text-muted">Platforms: instagram, x, tiktok, facebook, youtube, spotify, apple-music, boomplay, audiomack, deezer...</small>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Images</h5></div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label">Profile Photo</label>
            @if ($artist->photo)
              <div class="mb-2"><img src="{{ $artist->photo_url }}" alt="" class="rounded" style="width:90px;height:90px;object-fit:cover;"></div>
            @endif
            <input type="file" class="form-control mb-1" name="photo" accept="image/*">
            <input type="url" class="form-control" name="photo_url" placeholder="...or paste an image URL">
          </div>
          <div class="mb-0">
            <label class="form-label">Cover / Hero Image</label>
            @if ($artist->cover_image)
              <div class="mb-2"><img src="{{ $artist->cover_image_url }}" alt="" class="rounded" style="width:100%;height:90px;object-fit:cover;"></div>
            @endif
            <input type="file" class="form-control mb-1" name="cover_image" accept="image/*">
            <input type="url" class="form-control" name="cover_image_url" placeholder="...or paste an image URL">
          </div>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Visibility</h5></div>
        <div class="card-body">
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1"
                   {{ old('is_published', $artist->exists ? $artist->is_published : true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_published">Published (visible on the website)</label>
          </div>
          @if ($artist->exists)
            <p class="small text-muted mb-3">Public page: <a href="{{ url('/' . $artist->slug) }}" target="_blank">{{ url('/' . $artist->slug) }}</a></p>
          @endif
          <button type="submit" class="btn btn-primary w-100">
            {{ $artist->exists ? 'Save Changes' : 'Add Artist' }}
          </button>
          <a href="{{ route('admin.artists.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</form>

@endsection

@section('page-script')
<script>
  (function () {
    var rows = document.getElementById('linkRows');
    var addBtn = document.getElementById('addLinkRow');
    var idx = rows.querySelectorAll('.link-row').length;

    addBtn.addEventListener('click', function () {
      var div = document.createElement('div');
      div.className = 'row g-2 mb-2 link-row';
      div.innerHTML =
        '<div class="col-md-2">' +
        '  <select class="form-select" name="links[' + idx + '][type]">' +
        '    <option value="social">Social</option>' +
        '    <option value="streaming">Streaming</option>' +
        '  </select>' +
        '</div>' +
        '<div class="col-md-3"><input type="text" class="form-control" name="links[' + idx + '][platform]" placeholder="Platform (e.g. instagram)"></div>' +
        '<div class="col-md-6"><input type="url" class="form-control" name="links[' + idx + '][url]" placeholder="https://..."></div>' +
        '<div class="col-md-1"><button type="button" class="btn btn-outline-danger remove-link"><i class="bx bx-x"></i></button></div>';
      rows.appendChild(div);
      idx++;
    });

    rows.addEventListener('click', function (e) {
      var btn = e.target.closest('.remove-link');
      if (btn) btn.closest('.link-row').remove();
    });
  })();
</script>
@endsection
