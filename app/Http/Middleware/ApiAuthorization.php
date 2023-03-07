<?php

namespace App\Http\Middleware;

use App\Models\WebstoreToken;
use Closure;
use Illuminate\Http\Request;

class ApiAuthorization
{
    const UNAUTHORIZED = 401;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        $webstoreToken = WebstoreToken::where('id', $request->webstoreToken_id)->first();
        if(!$webstoreToken->hasAnyPermission($permissions)){
            return response()->json(['error' => 'You do not have the right permissions to perform this action'], self::UNAUTHORIZED);
        }
        return $next($request);
    }
}
