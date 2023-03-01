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
     * 1a: If user has no stores, throw 403 error.
     * 2: If cookie does exist, check whether user is in store related to cookie data.
     * 2a: If user is not in any store (or cookie is invalid), throw 403 and clear cookie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasCookie('selected_store_id')) {
            // Redirect so that it ensures the cookie is also accessible in components etc
            return redirect($request->getRequestUri())->cookie('selected_store_id', $this->getDefaultStoreId());
        } else {
            $cookie_value = $request->cookie('selected_store_id');
            $userInStore = Auth::user()->stores()->where('id', $cookie_value)->first();
            // If store is set but user is not in this store, get default store
            if ($userInStore == null) {
                return redirect($request->getRequestUri())->cookie('selected_store_id', $this->getDefaultStoreId());
            }
        }

        return $next($request);
    }

    private function getDefaultStoreId() {
        // Get the first store attached to a user
        $defaultStore = Auth::user()->stores()->first();

        // If user is not in any store, throw 403
        if ($defaultStore == null) {
            abort(403, 'Je moet toegang hebben tot minimaal één winkekl.');
        }

        return $defaultStore->id;
    }
}
