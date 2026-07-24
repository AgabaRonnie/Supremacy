<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\DemoSubmission;
use App\Models\StudioBooking;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function bookStudio(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:40',
            'preferred_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'nullable|string|max:60',
            'session_type' => 'nullable|string|max:100',
            'message' => 'nullable|string|max:3000',
        ]);

        StudioBooking::create($data);

        return back()->with('booking_success', "Thank you {$data['name']} — your session request has been received. We'll confirm on {$data['phone']} shortly.");
    }

    public function submitDemo(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'artist_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:40',
            'genre' => 'nullable|string|max:100',
            'links' => 'required|string|max:3000',
            'message' => 'nullable|string|max:3000',
        ]);

        DemoSubmission::create($data);

        return back()->with('demo_success', 'Your demo has been submitted. If the music speaks, we will reach out.');
    }
}
