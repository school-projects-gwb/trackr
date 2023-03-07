<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\WebstoreToken;

class ApiAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    const UNAUTHORIZED = 401;

    public function handle(Request $request, Closure $next)
    {
        // Check if the token is avaiable from the request
        if(!$request->bearerToken()){
            //Throws 401 error if the token is not available in the request
            return response()->json(['error' => 'Bearer Token is required'], self::UNAUTHORIZED);
        }

        $tokenData = explode(':', $request->bearerToken());
        $webstoreToken = new WebstoreToken();

        // Checks the validity of the token
        if(!$webstoreToken->isValid($tokenData)){
            //Throws 401 error if the token is not valid.
            return response()->json(['error' => 'Bearer Token is not valid'], self::UNAUTHORIZED);
        }
        $request->merge(['webstoreToken_id' => $tokenData[0]]);
        return $next($request);
    }
}
