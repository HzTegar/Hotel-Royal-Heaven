<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class RateLimitRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $maxAttempts = 60, $decayMinutes = 1): Response
    {
        $key = $this->resolveRequestSignature($request);

        $currentAttempts = Cache::get($key, 0);

        if ($currentAttempts >= $maxAttempts) {
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak permintaan. Silakan coba lagi nanti.',
                'errors' => ['rate_limit' => ['Anda telah mencapai batas maksimal permintaan.']],
                'data' => null,
            ], 429, [
                'Retry-After' => $this->getRemainingTime($key, $decayMinutes),
                'X-RateLimit-Limit' => $maxAttempts,
                'X-RateLimit-Remaining' => 0,
            ]);
        }

        Cache::put($key, $currentAttempts + 1, now()->addMinutes($decayMinutes));

        $response = $next($request);

        // Add rate limit headers to response
        $response->headers->set('X-RateLimit-Limit', $maxAttempts);
        $response->headers->set('X-RateLimit-Remaining', max(0, $maxAttempts - $currentAttempts - 1));
        $response->headers->set('X-RateLimit-Reset', now()->addMinutes($decayMinutes)->timestamp);

        return $response;
    }

    /**
     * Resolve request signature.
     */
    protected function resolveRequestSignature(Request $request): string
    {
        $userId = auth()->id() ?: $request->ip();

        return sha1(
            $userId .
            '|' .
            $request->method() .
            '|' .
            $request->route()?->getName() ?: $request->path()
        );
    }

    /**
     * Get remaining time until rate limit resets.
     */
    protected function getRemainingTime(string $key, int $decayMinutes): int
    {
        $ttl = Cache::getStore()->getTTL($key);
        return $ttl > 0 ? $ttl : ($decayMinutes * 60);
    }
}
