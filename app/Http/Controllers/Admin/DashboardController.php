<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'unreadMessages' => ContactMessage::query()->where('is_read', false)->count(),
            'totalMessages' => ContactMessage::count(),
        ]);
    }
}
