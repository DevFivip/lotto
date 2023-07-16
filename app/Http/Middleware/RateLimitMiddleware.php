<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    public function handle($request, Closure $next)
    {
        $key = 'rate_limit:' . $request->ip();

        if (Cache::has($key)) {
            return response()->json(['valid' => false, 'message' => 'too many request'], Response::HTTP_TOO_MANY_REQUESTS);
            // return response('Too Many Requests', );
        }

        Cache::put($key, true, now()->addMinutes(1));

        return $next($request);
    }
}
