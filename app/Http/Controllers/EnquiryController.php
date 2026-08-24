<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'package' => ['nullable', 'string', 'max:80'],
            'mode' => ['nullable', 'in:individual,joint'],
            'message' => ['required', 'string', 'max:4000'],
        ]);

        ContactMessage::create([
            'type' => 'enquiry',
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'package_interest' => $data['package'] ?? null,
            'billing_mode' => $data['mode'] ?? null,
            'message' => $data['message'],
        ]);

        return back()->with('success', 'Thank you — your message has been received. We will reply within one working day.');
    }

    public function checkoutIntent(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'package' => ['required', 'string', 'max:80'],
            'mode' => ['required', 'in:individual,joint'],
        ]);

        $plan = Plan::query()->where('slug', $data['package'])->where('is_active', true)->first();

        if (! $plan) {
            return back()->with('error', 'That package is not available.');
        }

        ContactMessage::create([
            'type' => 'checkout',
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'package_interest' => $plan->slug,
            'billing_mode' => $data['mode'],
            'message' => sprintf(
                'Checkout intent: %s (%s) at £%s. Awaiting payment integration (Stripe Checkout hook).',
                $plan->name,
                $data['mode'] === 'joint' ? 'joint application' : 'individual',
                number_format($plan->priceFor($data['mode']), 0)
            ),
        ]);

        return redirect()
            ->to(url('/#pricing'))
            ->with('success', 'Your interest in the ' . $plan->name . ' (' . $data['mode'] . ') has been recorded. Payment integration is next on the roadmap; we will be in touch to complete your order.');
    }
}
