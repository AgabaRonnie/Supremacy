<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\admin\Concerns\ManagesArtistContent;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use ManagesArtistContent;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $events = $this->scoped(Event::query())
            ->with('artist')
            ->orderByDesc('starts_at')
            ->get();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.form', ['event' => new Event(), 'artists' => $this->artistOptions()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['artist_id'] = $this->resolveArtistId($request, nullable: true); // null = label event
        $data['slug'] = $this->uniqueSlugFor(Event::class, $data['title']);

        if ($image = $this->resolveImageInput($request, 'image', 'events')) {
            $data['image'] = $image;
        }

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event added.');
    }

    public function edit(Event $event)
    {
        $this->authorizeOwnership($event);
        return view('admin.events.form', ['event' => $event, 'artists' => $this->artistOptions()]);
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeOwnership($event);

        $data = $this->validated($request);
        if ($this->isAdmin()) {
            $data['artist_id'] = $this->resolveArtistId($request, nullable: true);
        }
        if ($data['title'] !== $event->title) {
            $data['slug'] = $this->uniqueSlugFor(Event::class, $data['title'], $event->id);
        }
        if ($image = $this->resolveImageInput($request, 'image', 'events')) {
            $data['image'] = $image;
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event updated.');
    }

    public function destroy(Event $event)
    {
        $this->authorizeOwnership($event);
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'venue' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:120',
            'country' => 'nullable|string|max:120',
            'starts_at' => 'required|date',
            'ticket_url' => 'nullable|url|max:500',
            'price_info' => 'nullable|string|max:120',
            'description' => 'nullable|string|max:5000',
            'is_published' => 'nullable|boolean',
        ]) + [
            'is_published' => $request->boolean('is_published'),
            'country' => $request->input('country') ?: 'Uganda',
        ];
    }
}
