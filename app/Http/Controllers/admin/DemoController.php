<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DemoSubmission;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $demos = DemoSubmission::orderByRaw("status = 'new' DESC")
            ->orderByDesc('created_at')
            ->get();

        return view('admin.demos.index', compact('demos'));
    }

    public function updateStatus(Request $request, DemoSubmission $demo)
    {
        $request->validate(['status' => 'required|in:new,reviewed,contacted']);
        $demo->update(['status' => $request->input('status')]);

        return back()->with('success', "Demo marked as {$demo->status}.");
    }

    public function destroy(DemoSubmission $demo)
    {
        $demo->delete();
        return back()->with('success', 'Demo submission removed.');
    }
}
