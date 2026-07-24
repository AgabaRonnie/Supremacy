<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\admin\Concerns\ManagesArtistContent;
use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    use ManagesArtistContent;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $videos = $this->scoped(Video::query())
            ->with('artist')
            ->orderBy('artist_id')->orderBy('sort_order')
            ->get();

        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.form', ['video' => new Video(), 'artists' => $this->artistOptions()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['artist_id'] = $this->resolveArtistId($request, nullable: true);

        Video::create($data);

        return redirect()->route('admin.videos.index')->with('success', 'Video added.');
    }

    public function edit(Video $video)
    {
        $this->authorizeOwnership($video);
        return view('admin.videos.form', ['video' => $video, 'artists' => $this->artistOptions()]);
    }

    public function update(Request $request, Video $video)
    {
        $this->authorizeOwnership($video);

        $data = $this->validated($request);
        if ($this->isAdmin()) {
            $data['artist_id'] = $this->resolveArtistId($request, nullable: true);
        }

        $video->update($data);

        return redirect()->route('admin.videos.index')->with('success', 'Video updated.');
    }

    public function destroy(Video $video)
    {
        $this->authorizeOwnership($video);
        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Video deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|url|max:500',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]) + [
            'is_published' => $request->boolean('is_published'),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }
}
