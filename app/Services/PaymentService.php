<?php

namespace App\Services;

use App\Models\Order;

/**
 * Single entry point for online payments.
 *
 * Until real gateway keys are configured (.env + config/payments.php),
 * onlineEnabled() returns false and the site gracefully falls back to
 * "payments launching soon" + complete-on-WhatsApp.
 */
class PaymentService
{
    public static function onlineEnabled(): bool
    {
        return match (config('payments.driver')) {
            'flutterwave' => filled(config('payments.flutterwave.secret_key')),
            'pesapal' => filled(config('payments.pesapal.consumer_key')),
            default => false,
        };
    }

    /**
     * Start an online charge for an order and return a redirect URL to the
     * gateway's hosted payment page.
     *
     * TODO(SUPREMACY): implement when API keys + docs arrive.
     *
     * Flutterwave sketch:
     *   POST {base_url}/payments  (Authorization: Bearer secret_key)
     *   payload: tx_ref = $order->reference, amount, currency,
     *            redirect_url = route('order.show', $order),
     *            customer { name, email, phonenumber }
     *   -> respond with data.link  (redirect the buyer there)
     *
     * Pesapal sketch:
     *   1) POST {base_url}/api/Auth/RequestToken (consumer key/secret)
     *   2) POST /api/Transactions/SubmitOrderRequest with callback URL
     *   -> respond with redirect_url
     */
    public static function initiate(Order $order): string
    {
        throw new \RuntimeException(
            'Online payments are not configured yet. Fill in the gateway keys in .env (see config/payments.php).'
        );
    }

    /**
     * Handle a gateway webhook confirming payment.
     *
     * TODO(SUPREMACY): implement when API keys + docs arrive.
     *  - Flutterwave: verify the `verif-hash` header equals
     *    config('payments.flutterwave.secret_hash'), then re-verify the
     *    transaction via GET /transactions/{id}/verify before marking paid.
     *  - Pesapal: use the IPN notification to query transaction status.
     * On success: $order->update(['status' => 'paid', 'payment_ref' => ...]);
     */
    public static function handleWebhook(string $gateway, array $payload): void
    {
        logger()->info("[payments] {$gateway} webhook received (gateway not configured yet)", $payload);
    }
}
