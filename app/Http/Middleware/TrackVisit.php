<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->shouldTrack($request)) {
            try {
                PageVisit::create([
                    'path' => $request->path(),
                    'method' => $request->method(),
                    'ip' => $request->ip(),
                    'user_agent' => mb_substr($request->userAgent() ?? '', 0, 255),
                    'referer' => mb_substr($request->headers->get('referer') ?? '', 0, 255),
                    'visited_at' => now(),
                ]);
            } catch (\Throwable) {
                // never let tracking break a page render
            }
        }

        return $response;
    }

    protected function shouldTrack(Request $request): bool
    {
        if (! $request->isMethod('GET')) {
            return false;
        }

        if ($request->expectsJson()) {
            return false;
        }

        if ($request->is('admin/*') || $request->is('admin') || $request->is('login')) {
            return false;
        }

        if ($request->is('trix/*', '_debugbar/*', 'up', 'vendor/*')) {
            return false;
        }

        return true;
    }
}