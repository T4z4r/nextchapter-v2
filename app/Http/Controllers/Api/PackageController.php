<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Plan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PackageController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Plan::active()->map(fn (Plan $plan) => [
                'slug' => $plan->slug,
                'tier_label' => $plan->tier_label,
                'name' => $plan->name,
                'duration_label' => $plan->duration_label,
                'billing_variants' => [
                    'individual' => [
                        'amount' => (float) $plan->price_ind,
                        'currency' => 'gbp',
                        'display' => '£' . number_format($plan->price_ind, 0),
                        'summary' => $plan->sub_ind,
                    ],
                    'joint' => [
                        'amount' => (float) $plan->price_joint,
                        'currency' => 'gbp',
                        'display' => '£' . number_format($plan->price_joint, 0),
                        'summary' => $plan->sub_joint,
                    ],
                ],
                'features' => $plan->featureList(),
                'badge' => $plan->badge,
                'featured' => $plan->featured,
            ]),
        ]);
    }

    public function purchase(Request $request): JsonResponse
    {
        $data = $request->validate([
            'package_slug' => ['required', 'string', 'max:80', Rule::exists('plans', 'slug')->where('is_active', true)],
            'billing_variant' => ['required', Rule::in(['individual', 'joint'])],
            'customer_email' => ['required', 'email', 'max:190'],
        ]);

        $plan = Plan::query()
            ->where('slug', $data['package_slug'])
            ->where('is_active', true)
            ->firstOrFail();

        $purchaseUrl = config('services.packages.purchase_url');

        if (! $purchaseUrl) {
            return response()->json([
                'message' => 'Package purchase API is not configured. Set PACKAGES_PURCHASE_API_URL to enable checkout.',
            ], 503);
        }

        $response = Http::acceptJson()
            ->asJson()
            ->timeout(20)
            ->post($purchaseUrl, [
                'package_slug' => $plan->slug,
                'billing_variant' => $data['billing_variant'],
                'customer_email' => $data['customer_email'],
            ]);

        if ($response->failed()) {
            Log::warning('Remote package purchase API failed.', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return response()->json([
                'message' => 'Checkout could not be started. Please try again or contact us.',
            ], 502);
        }

        $session = $response->json();

        ContactMessage::create([
            'type' => 'checkout',
            'email' => $data['customer_email'],
            'package_interest' => $plan->slug,
            'billing_mode' => $data['billing_variant'],
            'message' => sprintf(
                'Stripe Checkout started: %s (%s) at £%s. Session: %s',
                $plan->name,
                $data['billing_variant'] === 'joint' ? 'joint application' : 'individual',
                number_format($plan->priceFor($data['billing_variant']), 0),
                $session['checkout_session_id'] ?? $session['id'] ?? 'unknown'
            ),
        ]);

        return response()->json([
            'checkout_session_id' => $session['checkout_session_id'] ?? $session['id'] ?? null,
            'url' => $session['url'] ?? null,
        ]);
    }

    public function webhook(Request $request): JsonResponse
    {
        if (! $this->hasValidStripeSignature($request)) {
            return response()->json(['message' => 'Invalid Stripe signature.'], 400);
        }

        $payload = $request->json()->all();

        if (($payload['type'] ?? null) === 'checkout.session.completed') {
            $session = $payload['data']['object'] ?? [];
            $email = $session['customer_details']['email'] ?? $session['customer_email'] ?? null;

            ContactMessage::create([
                'type' => 'checkout',
                'email' => $email,
                'package_interest' => $session['metadata']['package_slug'] ?? null,
                'billing_mode' => $session['metadata']['billing_variant'] ?? null,
                'message' => sprintf(
                    'Stripe Checkout completed. Session: %s. Payment intent: %s.',
                    $session['id'] ?? 'unknown',
                    $session['payment_intent'] ?? 'unknown'
                ),
            ]);

            if ($email) {
                $this->createRemoteAccount($email, $session);
            }
        }

        return response()->json(['received' => true]);
    }

    private function hasValidStripeSignature(Request $request): bool
    {
        $secret = config('services.stripe.webhook_secret');

        if (! $secret) {
            return app()->environment('local', 'testing');
        }

        $signature = $request->header('Stripe-Signature', '');

        if (! preg_match('/(?:^|,)t=([^,]+)/', $signature, $timestamp)) {
            return false;
        }

        if (! preg_match('/(?:^|,)v1=([^,]+)/', $signature, $hash)) {
            return false;
        }

        $expected = hash_hmac('sha256', $timestamp[1] . '.' . $request->getContent(), $secret);

        return hash_equals($expected, $hash[1]);
    }

    /**
     * @param array<string, mixed> $session
     */
    private function createRemoteAccount(string $email, array $session): void
    {
        $url = config('services.packages.remote_account_url');
        $token = config('services.packages.remote_registration_token');

        if (! $url || ! $token) {
            Log::warning('Remote account creation skipped because BalancePoint registration is not configured.', [
                'session_id' => $session['id'] ?? null,
                'email' => $email,
            ]);

            return;
        }

        $name = $session['customer_details']['name'] ?? $session['customer_name'] ?? $this->nameFromEmail($email);

        $response = Http::acceptJson()
            ->asJson()
            ->withToken($token)
            ->timeout(20)
            ->post($url, [
                'name' => $name,
                'email' => $email,
                'display_name' => strtok($name, ' ') ?: null,
            ]);

        if ($response->failed()) {
            Log::warning('Remote BalancePoint account creation failed.', [
                'status' => $response->status(),
                'body' => $response->json(),
                'session_id' => $session['id'] ?? null,
                'email' => $email,
            ]);
        }
    }

    private function nameFromEmail(string $email): string
    {
        $localPart = str($email)->before('@')->replace(['.', '_', '-'], ' ')->squish()->title()->toString();

        return $localPart ?: $email;
    }
}
