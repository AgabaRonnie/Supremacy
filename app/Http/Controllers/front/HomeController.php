<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Event;
use App\Models\NewsPost;
use App\Models\Service;
use App\Models\Track;

class HomeController extends Controller
{

  public function index()
  {
    $artists = Artist::published()->orderBy('sort_order')->get();

    $latestRelease = Track::published()
      ->with('artist')
      ->orderByDesc('release_date')
      ->first();

    $services = Service::published()->orderBy('sort_order')->get();

    $upcomingEvents = Event::published()
      ->upcoming()
      ->with('artist')
      ->take(3)
      ->get();

    $news = NewsPost::published()
      ->orderByDesc('published_at')
      ->take(2)
      ->get();

    return view('front.home', compact('artists', 'latestRelease', 'services', 'upcomingEvents', 'news'));
  }

}
