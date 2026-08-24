<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

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
}
