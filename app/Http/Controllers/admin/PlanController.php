<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\admin\Concerns\ManagesArtistContent;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    use ManagesArtistContent;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $plans = $this->scoped(SubscriptionPlan::query())
            ->with('artist')
            ->orderBy('artist_id')->orderBy('price')
            ->get();

        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.form', ['plan' => new SubscriptionPlan(), 'artists' => $this->artistOptions()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['artist_id'] = $this->resolveArtistId($request);

        SubscriptionPlan::create($data);

        return redirect()->route('admin.plans.index')->with('success', 'Fan club plan added.');
    }

    public function edit(SubscriptionPlan $plan)
    {
        $this->authorizeOwnership($plan);
        return view('admin.plans.form', ['plan' => $plan, 'artists' => $this->artistOptions()]);
    }

    public function update(Request $request, SubscriptionPlan $plan)
    {
        $this->authorizeOwnership($plan);

        $data = $this->validated($request);
        if ($this->isAdmin()) {
            $data['artist_id'] = $this->resolveArtistId($request);
        }

        $plan->update($data);

        return redirect()->route('admin.plans.index')->with('success', 'Fan club plan updated.');
    }

    public function destroy(SubscriptionPlan $plan)
    {
        $this->authorizeOwnership($plan);
        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Fan club plan deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'price' => 'required|numeric|min:0',
            'interval' => 'required|in:monthly,yearly',
            'perks_text' => 'nullable|string|max:3000',
            'is_active' => 'nullable|boolean',
        ]);

        return [
            'name' => $data['name'],
            'price' => $data['price'],
            'interval' => $data['interval'],
            'perks' => collect(preg_split('/\r\n|\r|\n/', (string) ($data['perks_text'] ?? '')))
                ->map(fn ($l) => trim($l))->filter()->values()->all() ?: null,
            'is_active' => $request->boolean('is_active'),
        ];
    }
}
