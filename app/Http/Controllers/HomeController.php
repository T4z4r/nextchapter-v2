<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(protected ContentRepository $content)
    {
    }

    public function index(): View
    {
        return view('home', $this->content->homeData());
    }

    public function legal(): View
    {
        return view('legal', $this->content->homeData());
    }

    public function checkout(Request $request, string $package): View|RedirectResponse
    {
        $plan = Plan::query()
            ->where('slug', $package)
            ->where('is_active', true)
            ->first();

        if (! $plan) {
            return redirect()
                ->to(url('/#pricing'))
                ->with('error', 'That package is not available.');
        }

        $mode = $request->query('billing_variant', 'individual');
        $mode = in_array($mode, ['individual', 'joint'], true) ? $mode : 'individual';

        return view('checkout', [
            ...$this->content->homeData(),
            'plan' => $plan,
            'selectedMode' => $mode,
        ]);
    }
}
