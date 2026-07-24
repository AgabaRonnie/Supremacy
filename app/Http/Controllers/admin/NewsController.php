<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\admin\Concerns\ManagesArtistContent;
use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    use ManagesArtistContent;

    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $posts = NewsPost::orderByDesc('published_at')->orderByDesc('id')->get();
        return view('admin.news.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.news.form', ['post' => new NewsPost()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlugFor(NewsPost::class, $data['title']);

        if ($image = $this->resolveImageInput($request, 'image', 'news')) {
            $data['image'] = $image;
        }

        NewsPost::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Story published to the newsroom.');
    }

    public function edit(NewsPost $news)
    {
        return view('admin.news.form', ['post' => $news]);
    }

    public function update(Request $request, NewsPost $news)
    {
        $data = $this->validated($request);
        if ($data['title'] !== $news->title) {
            $data['slug'] = $this->uniqueSlugFor(NewsPost::class, $data['title'], $news->id);
        }
        if ($image = $this->resolveImageInput($request, 'image', 'news')) {
            $data['image'] = $image;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Story updated.');
    }

    public function destroy(NewsPost $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Story deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'nullable|string|max:50000',
            'published_at' => 'nullable|date',
        ]);
    }
}
