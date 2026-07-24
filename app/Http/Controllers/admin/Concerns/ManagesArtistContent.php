<?php

namespace App\Http\Controllers\admin\Concerns;

use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Shared helpers for admin/portal content controllers.
 *
 * Admins manage content for any artist; artist users are hard-scoped to
 * their own artist_id on every query, write and delete.
 */
trait ManagesArtistContent
{
    protected function isAdmin(): bool
    {
        return auth()->user()->isAdmin();
    }

    // The artist_id an artist user is locked to (403 if their account is not linked).
    protected function ownArtistId(): int
    {
        $id = auth()->user()->artist_id;
        abort_unless($id, 403, 'Your account is not linked to an artist profile yet — contact the label.');
        return (int) $id;
    }

    // Resolve the artist_id to store: admins choose it, artists are forced to their own.
    protected function resolveArtistId(Request $request, bool $nullable = false): ?int
    {
        if (!$this->isAdmin()) {
            return $this->ownArtistId();
        }

        $value = $request->input('artist_id');
        if ($nullable && !$value) {
            return null; // label-level content (label merch, label events...)
        }

        $request->validate(['artist_id' => 'required|exists:artists,id']);
        return (int) $value;
    }

    // Scope a query to the current user's reach.
    protected function scoped($query)
    {
        return $this->isAdmin() ? $query : $query->where('artist_id', $this->ownArtistId());
    }

    // Guard a single record (edit/update/delete).
    protected function authorizeOwnership($model): void
    {
        if (!$this->isAdmin()) {
            abort_unless((int) $model->artist_id === $this->ownArtistId(), 403);
        }
    }

    protected function artistOptions()
    {
        return $this->isAdmin()
            ? Artist::orderBy('name')->get(['id', 'name'])
            : Artist::where('id', $this->ownArtistId())->get(['id', 'name']);
    }

    // Accepts a file upload ($field) or a pasted URL ($field.'_url').
    protected function resolveImageInput(Request $request, string $field, string $dir)
    {
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            $name = time() . '-' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/' . $dir), $name);
            return 'uploads/' . $dir . '/' . $name;
        }

        return $request->input($field . '_url') ?: null;
    }

    // Collect the fixed streaming-platform link inputs into a JSON-ready array.
    protected function collectLinks(Request $request): ?array
    {
        $links = collect($request->input('platform_links', []))
            ->filter(fn ($url) => filled($url))
            ->all();

        return count($links) ? $links : null;
    }

    protected function uniqueSlugFor(string $modelClass, string $title, $ignoreId = null, ?int $artistId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 2;

        $exists = function ($slug) use ($modelClass, $ignoreId, $artistId) {
            $q = $modelClass::where('slug', $slug);
            if ($ignoreId) $q->where('id', '!=', $ignoreId);
            // Albums/tracks are unique per artist; global models pass null.
            if ($artistId !== null) $q->where('artist_id', $artistId);
            return $q->exists();
        };

        while ($exists($slug)) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
