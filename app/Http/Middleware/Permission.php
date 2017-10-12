<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
				$user = JWTAuth::toUser($request->token); 

        if ($permission != null && ! $user->can($permission)) {
            //abort(403);
						return response()->json(['status'=>false,'message'=>'Permission Not allowed.']);
        }


        return $next($request);
    }
}
