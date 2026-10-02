<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticateWithApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = null;

        $authHeader = $request->header('Authorization');
        if ($authHeader && str_starts_with($authHeader, 'Bearer ')) {
            $token = substr($authHeader, 7);
        }

        if (!$token) {
            $token = $request->input('api_token') ?? $request->bearerToken();
        }

        if (!$token) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $user = User::where('api_token', $token)->first();
        if (!$user) {
            return response()->json(['message' => 'Invalid token.'], 401);
        }

        // set the user for the request (use Auth facade)
        Auth::setUser($user);

        return $next($request);
    }
}
