<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Group;
use App\Models\User;

class EnsureApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => __('API token is required.')], 401);
        }

        $owner = User::where('token', $token)->first();

        if (!$owner) {
            return response()->json(['message' => __('Invalid API token.')], 401);
        }

        $request->merge(['owner' => $owner]);

        return $next($request);
    }
}