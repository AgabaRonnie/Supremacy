<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\admin\Concerns\ManagesArtistContent;
use App\Http\Controllers\Controller;
use App\Models\FanSubscription;
use Illuminate\Http\Request;

class FanSubscriptionController extends Controller
{
    use ManagesArtistContent;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $subs = $this->scoped(FanSubscription::query())
            ->with(['plan', 'artist'])
            ->orderByRaw("status = 'pending' DESC")
            ->orderByDesc('created_at')
            ->get();

        return view('admin.subscriptions.index', compact('subs'));
    }

    public function updateStatus(Request $request, FanSubscription $subscription)
    {
        abort_unless($this->isAdmin(), 403);

        $request->validate(['status' => 'required|in:pending,active,cancelled']);

        $subscription->update([
            'status' => $request->input('status'),
            'started_at' => $request->input('status') === 'active'
                ? ($subscription->started_at ?? now())
                : $subscription->started_at,
        ]);

        return back()->with('success', 'Subscription updated.');
    }

    public function destroy(FanSubscription $subscription)
    {
        abort_unless($this->isAdmin(), 403);
        $subscription->delete();

        return back()->with('success', 'Subscription removed.');
    }
}
