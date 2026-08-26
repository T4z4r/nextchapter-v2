<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Addon;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\Plan;
use App\Models\Tutorial;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $messages = ContactMessage::query()
            ->selectRaw('count(*) as total')
            ->selectRaw("sum(case when type = 'enquiry' then 1 else 0 end) as enquiries")
            ->selectRaw("sum(case when type = 'checkout_intent' then 1 else 0 end) as intents")
            ->selectRaw('sum(case when is_read = 0 then 1 else 0 end) as unread')
            ->first();

        return view('admin.dashboard', [
            'totalMessages' => (int) $messages->total,
            'unreadMessages' => (int) $messages->unread,
            'enquiries' => (int) $messages->enquiries,
            'intents' => (int) $messages->intents,
            'tutorials' => Tutorial::count(),
            'lockedTutorials' => Tutorial::where('is_locked', true)->count(),
            'faqs' => Faq::count(),
            'plans' => Plan::where('is_active', true)->count(),
            'addons' => Addon::where('is_active', true)->count(),
            'recent' => ActivityLog::with('user')->latest()->limit(8)->get(),
        ]);
    }
}
