<?php

namespace App\Http\Middleware;

use Closure;

class ApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('API_KEY') != env('API_KEY')) {
            return response()->json(['success' => 0, 'message' => 'Unauthorized']);
        }
        return $next($request);
    }
}
