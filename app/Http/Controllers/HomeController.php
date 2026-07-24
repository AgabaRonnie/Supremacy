<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\DemoSubmission;
use App\Models\Event;
use App\Models\Product;
use App\Models\StudioBooking;
use App\Models\Track;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Role-aware dashboard: label stats for admins, own stats for artists.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $stats = [
                'artists' => Artist::count(),
                'tracks' => Track::count(),
                'albums' => Album::count(),
                'products' => Product::count(),
                'upcoming_events' => Event::upcoming()->count(),
                'pending_bookings' => StudioBooking::where('status', 'pending')->count(),
                'new_demos' => DemoSubmission::where('status', 'new')->count(),
                'pending_orders' => \App\Models\Order::where('status', 'pending')->count(),
            ];

            $recentBookings = StudioBooking::orderByDesc('created_at')->take(5)->get();
            $recentDemos = DemoSubmission::orderByDesc('created_at')->take(5)->get();

            return view('admin.home', compact('stats', 'recentBookings', 'recentDemos'));
        }

        // Artist portal dashboard
        $artist = $user->artist;

        $stats = $artist ? [
            'tracks' => Track::where('artist_id', $artist->id)->count(),
            'albums' => Album::where('artist_id', $artist->id)->count(),
            'products' => Product::where('artist_id', $artist->id)->count(),
            'videos' => Video::where('artist_id', $artist->id)->count(),
            'upcoming_events' => Event::where('artist_id', $artist->id)->upcoming()->count(),
        ] : [];

        $analytics = $artist ? [
            'views_30' => \App\Models\PageView::where('artist_id', $artist->id)->where('created_at', '>=', now()->subDays(30))->count(),
            'views_total' => \App\Models\PageView::where('artist_id', $artist->id)->count(),
            'clicks_30' => \App\Models\LinkClick::where('artist_id', $artist->id)->where('created_at', '>=', now()->subDays(30))->count(),
            'top_platform' => optional(
                \App\Models\LinkClick::where('artist_id', $artist->id)
                    ->selectRaw('platform, COUNT(*) as c')
                    ->groupBy('platform')->orderByDesc('c')->first()
            )->platform,
        ] : [];

        return view('admin.portal.home', compact('artist', 'stats', 'analytics'));
    }
}
