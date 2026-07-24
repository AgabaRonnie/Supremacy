<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Event;
use App\Models\NewsPost;
use App\Models\Service;

class PageController extends Controller
{
    public function artists()
    {
        $artists = Artist::published()->orderBy('sort_order')->get();
        return view('front.artists', compact('artists'));
    }

    public function studio()
    {
        return view('front.studio');
    }

    public function services()
    {
        $services = Service::published()->orderBy('sort_order')->get();
        return view('front.services', compact('services'));
    }

    public function events()
    {
        $upcoming = Event::published()->upcoming()->with('artist')->get();
        $past = Event::published()
            ->where('starts_at', '<', now())
            ->with('artist')
            ->orderByDesc('starts_at')
            ->take(6)
            ->get();

        return view('front.events', compact('upcoming', 'past'));
    }

    public function news()
    {
        $posts = NewsPost::published()->orderByDesc('published_at')->paginate(9);
        return view('front.news', compact('posts'));
    }

    public function newsShow(NewsPost $post)
    {
        abort_unless($post->published_at && $post->published_at->isPast(), 404);

        $more = NewsPost::published()
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->take(2)
            ->get();

        return view('front.news-show', compact('post', 'more'));
    }

    public function about()
    {
        $artistCount = Artist::published()->count();
        return view('front.about', compact('artistCount'));
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function join()
    {
        return view('front.join');
    }
}
