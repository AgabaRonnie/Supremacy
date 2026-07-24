<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\admin\Concerns\ManagesArtistContent;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ManagesArtistContent;

    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $services = Service::orderBy('sort_order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.form', ['service' => new Service()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlugFor(Service::class, $data['title']);

        if ($image = $this->resolveImageInput($request, 'image', 'services')) {
            $data['image'] = $image;
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service added.');
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $this->validated($request);
        if ($data['title'] !== $service->title) {
            $data['slug'] = $this->uniqueSlugFor(Service::class, $data['title'], $service->id);
        }
        if ($image = $this->resolveImageInput($request, 'image', 'services')) {
            $data['image'] = $image;
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Service deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:20000',
            'sort_order' => 'nullable|integer',
            'is_published' => 'nullable|boolean',
        ]) + [
            'is_published' => $request->boolean('is_published'),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }
}
