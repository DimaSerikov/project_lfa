<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NYTApiThrottleMiddleware
{
    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'nyt_api_request:' . $request->user()?->id ?? $request->ip();

        if (!RateLimiter::attempt($key, 10, function () {}, 60)) {
            throw new HttpException(429, 'Too many requests to NYT API.');
        }

        return $next($request);
    }
}
