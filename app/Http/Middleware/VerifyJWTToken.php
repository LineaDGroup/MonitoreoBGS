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
            if(!$request->has('token')) {
                return response()->json(['token not sended'],422);
            }
            $user = User::where('api_token',$request->token)->first();
            $request->userId = $user->id; 
            if(!$user) {
                return response()->json(['token invalid'],422);
            }
        }catch (\Exception $e) {
            return response()->json(['token_invalid'], 500);
        }
       return $next($request);
    }
}
