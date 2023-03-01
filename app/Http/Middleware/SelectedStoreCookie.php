<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelectedStoreCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasCookie('selected_store_id')) {
            $response = $next($request);
            // Get the first store attached to a user
            $defaultStore = Auth::user()->stores()->first();
            $response->cookie('selected_store_id', $defaultStore->id);
            return $response;
        }

        return $next($request);
    }
}
