@extends('layouts.layoutMaster')

@section('title', 'My Profile')

@section('content')

@include('admin.partials.flash')

<form method="POST" enctype="multipart/form-data" action="{{ route('admin.portal.profile.update') }}">
  @csrf
  @method('PUT')

  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">My Public Profile</h5>
          <a href="{{ url('/' . $artist->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary">
            <i class="bx bx-link-external me-1"></i> View My Page
          </a>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Artist Name</label>
              <input type="text" class="form-control" value="{{ $artist->name }}" disabled>
              <small class="text-muted">Your name and page link are managed by the label.</small>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="genre">Genre</label>
              <input type="text" class="form-control" id="genre" name="genre" value="{{ old('genre', $artist->genre) }}">
            </div>
            <div class="col-12">
              <label class="form-label" for="tagline">Tagline</label>
              <input type="text" class="form-control" id="tagline" name="tagline" value="{{ old('tagline', $artist->tagline) }}" placeholder="One line that defines you">
            </div>
            <div class="col-12">
              <label class="form-label" for="bio">Bio</label>
              <textarea class="form-control" id="bio" name="bio" rows="6">{{ old('bio', $artist->bio) }}</textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="location">Based In</label>
              <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $artist->location) }}">
            </div>
            <div class="col-md-6">
              <label class="form-label" for="joined_year">With Supremacy Since</label>
              <input type="number" class="form-control" id="joined_year" name="joined_year" value="{{ old('joined_year', $artist->joined_year) }}">
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">My Social & Streaming Links</h5>
          <button type="button" class="btn btn-sm btn-outline-primary" id="addLinkRow"><i class="bx bx-plus me-1"></i> Add Link</button>
        </div>
        <div class="card-body">
          <div id="linkRows">
            @foreach (old('links', $artist->links->map(fn ($l) => ['type' => $l->type, 'platform' => $l->platform, 'url' => $l->url])->toArray()) as $i => $link)
              <div class="row g-2 mb-2 link-row">
                <div class="col-md-2">
                  <select class="form-select" name="links[{{ $i }}][type]">
                    <option value="social" {{ ($link['type'] ?? '') === 'social' ? 'selected' : '' }}>Social</option>
                    <option value="streaming" {{ ($link['type'] ?? '') === 'streaming' ? 'selected' : '' }}>Streaming</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <input type="text" class="form-control" name="links[{{ $i }}][platform]" placeholder="Platform" value="{{ $link['platform'] ?? '' }}">
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
          <small class="text-muted">Platforms: instagram, x, tiktok, facebook, youtube, spotify, apple-music, boomplay, audiomack...</small>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">My Images</h5></div>
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
        <div class="card-body">
          <button type="submit" class="btn btn-primary w-100">Save My Profile</button>
          <p class="small text-muted mt-3 mb-0">Everything you save here appears immediately on <a href="{{ url('/' . $artist->slug) }}" target="_blank">{{ url('/' . $artist->slug) }}</a>.</p>
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
        '<div class="col-md-3"><input type="text" class="form-control" name="links[' + idx + '][platform]" placeholder="Platform"></div>' +
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
