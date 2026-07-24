<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\StudioBooking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $bookings = StudioBooking::orderByRaw("status = 'pending' DESC")
            ->orderBy('preferred_date')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, StudioBooking $booking)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,declined']);
        $booking->update(['status' => $request->input('status')]);

        return back()->with('success', "Booking marked as {$booking->status}.");
    }

    public function destroy(StudioBooking $booking)
    {
        $booking->delete();
        return back()->with('success', 'Booking removed.');
    }
}
