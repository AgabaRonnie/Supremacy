<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\FanSubscription;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SubscriptionPlan;
use App\Models\Track;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    private const TYPES = [
        'track' => Track::class,
        'album' => Album::class,
        'product' => Product::class,
    ];

    // Resolve a purchasable item or 404.
    private function findItem(string $type, int $id)
    {
        abort_unless(isset(self::TYPES[$type]), 404);

        $item = self::TYPES[$type]::published()->findOrFail($id);
        abort_if($type !== 'product' && !$item->price, 404); // free/non-sale items aren't purchasable

        return $item;
    }

    private function itemTitle(string $type, $item): string
    {
        $name = $item->title ?? $item->name;
        $artist = optional($item->artist)->name;

        return $artist ? "{$name} — {$artist}" : $name;
    }

    public function checkout(string $type, int $id)
    {
        $item = $this->findItem($type, $id);

        return view('front.checkout', [
            'type' => $type,
            'item' => $item,
            'title' => $this->itemTitle($type, $item),
            'image' => $type === 'product' ? $item->first_image_url : $item->cover_url,
        ]);
    }

    public function placeOrder(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:track,album,product',
            'item_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:40',
            'email' => 'nullable|email|max:255',
            'quantity' => 'nullable|integer|min:1|max:50',
        ]);

        $item = $this->findItem($data['type'], (int) $data['item_id']);
        $quantity = $data['type'] === 'product' ? (int) ($data['quantity'] ?? 1) : 1;

        $order = Order::create([
            'reference' => Order::generateReference(),
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'total' => $item->price * $quantity,
            'currency' => $item->currency ?? 'UGX',
            'status' => 'pending',
            'payment_method' => PaymentService::onlineEnabled() ? config('payments.driver') : 'whatsapp',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'item_type' => $data['type'],
            'item_id' => $item->id,
            'artist_id' => $item->artist_id,
            'title' => $this->itemTitle($data['type'], $item),
            'unit_price' => $item->price,
            'quantity' => $quantity,
        ]);

        // TODO(SUPREMACY): once gateway keys are configured this redirects the
        // buyer straight to the hosted payment page.
        if (PaymentService::onlineEnabled()) {
            return redirect()->away(PaymentService::initiate($order));
        }

        return redirect()->route('order.show', $order);
    }

    public function orderShow(Order $order)
    {
        $order->load('items');

        return view('front.order', [
            'order' => $order,
            'onlinePayments' => PaymentService::onlineEnabled(),
        ]);
    }

    /* ---------------------------- Fan club ---------------------------- */

    public function joinClub(SubscriptionPlan $plan)
    {
        abort_unless($plan->is_active, 404);
        $plan->load('artist');

        return view('front.fanclub-join', compact('plan'));
    }

    public function subscribe(Request $request, SubscriptionPlan $plan)
    {
        abort_unless($plan->is_active, 404);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:40',
            'email' => 'nullable|email|max:255',
        ]);

        FanSubscription::create([
            'subscription_plan_id' => $plan->id,
            'artist_id' => $plan->artist_id,
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'] ?? null,
            'status' => 'pending',
        ]);

        // TODO(SUPREMACY): with a gateway configured, start the recurring
        // charge here instead of the waitlist confirmation.
        return back()->with('club_success', "You're on the list, {$data['name']}! Online payments launch soon — we'll reach out on {$data['phone']} to activate your membership.");
    }

    /* ---------------------------- Webhooks ---------------------------- */

    public function webhook(Request $request, string $gateway)
    {
        abort_unless(in_array($gateway, ['flutterwave', 'pesapal']), 404);

        PaymentService::handleWebhook($gateway, $request->all());

        return response()->json(['status' => 'ok']);
    }
}
