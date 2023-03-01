<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelectedStoreCookie
{
    /**
     * Validate cookie. Strategy:
     * 1: If cookie does not exist, create it with default value (first store found on user).
     * 1a: If user has no stores, continue.
     * 2: If cookie does exist, check whether user is in store related to cookie data.
     * 2a: If user is not in store (or cookie is invalid), throw 403 and clear cookie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!$request->hasCookie('selected_store_id')) {

            // Get the first store attached to a user
            $defaultStore = Auth::user()->stores()->first();

            // If user is not in any store, just continue
            if ($defaultStore == null) {
                return $next($request);
            }

            $response->cookie('selected_store_id', $defaultStore->id);
        } else {
            $cookie_value = $request->cookie('selected_store_id');
            $userInStore = Auth::user()->stores()->where('id', $cookie_value)->first();
            // If store is set but user is not in this store, forget cookie
            if ($userInStore == null) {
                $response->withCookie(cookie()->forget('selected_store_id'));
            }
        }

        return $response;
    }
}
