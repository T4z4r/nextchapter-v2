<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;
use Illuminate\Contracts\View\View;

class VisitController extends Controller
{
    public function index(): View
    {
        $recent = PageVisit::query()
            ->latest('visited_at')
            ->paginate(25);

        $series = PageVisit::dailySeries(14);

        return view('admin.visits.index', [
            'recent' => $recent,
            'series' => $series,
            'maxSeries' => max(1, max($series)),
            'total' => PageVisit::total(),
            'today' => PageVisit::todayCount(),
            'uniqueToday' => PageVisit::uniqueToday(),
            'yesterday' => PageVisit::yesterdayCount(),
            'topPaths' => PageVisit::topPaths(6),
        ]);
    }
}