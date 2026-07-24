<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\admin\Concerns\ManagesArtistContent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ManagesArtistContent;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $query = Order::with('items');

        // Artists see orders that contain their items (read-only).
        if (!$this->isAdmin()) {
            $query->whereHas('items', fn ($q) => $q->where('artist_id', $this->ownArtistId()));
        }

        $orders = $query->orderByRaw("status = 'pending' DESC")->orderByDesc('created_at')->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        abort_unless($this->isAdmin(), 403);

        $request->validate(['status' => 'required|in:pending,paid,fulfilled,cancelled']);
        $order->update(['status' => $request->input('status')]);

        return back()->with('success', "Order {$order->reference} marked as {$order->status}.");
    }

    public function destroy(Order $order)
    {
        abort_unless($this->isAdmin(), 403);
        $order->delete();

        return back()->with('success', 'Order removed.');
    }
}
