<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\User;

class VerifyJWTToken
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
        try{
            $token = User::where('api_token',$request->token)->first();
            if(!$token) {
                return response()->json(['token invalid'],422);
            }
        }catch (\Exception $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        }
       return $next($request);
    }
}
