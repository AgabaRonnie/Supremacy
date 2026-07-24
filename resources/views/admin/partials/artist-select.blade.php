{{-- Artist picker: admins choose; artist users are auto-scoped server-side.
     Pass: $artists, $selected (id|null), $nullable (bool, allows "Label" option) --}}
@if (auth()->user()->isAdmin())
  <div class="col-md-6">
    <label class="form-label" for="artist_id">Artist {{ ($nullable ?? false) ? '' : '*' }}</label>
    <select class="form-select" id="artist_id" name="artist_id" {{ ($nullable ?? false) ? '' : 'required' }}>
      @if ($nullable ?? false)
        <option value="" {{ empty($selected) ? 'selected' : '' }}>— Supremacy Studios (label-level) —</option>
      @endif
      @foreach ($artists as $a)
        <option value="{{ $a->id }}" {{ (string) $selected === (string) $a->id ? 'selected' : '' }}>{{ $a->name }}</option>
      @endforeach
    </select>
  </div>
@endif
