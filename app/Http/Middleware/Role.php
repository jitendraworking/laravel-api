<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next, $role, $permission = null)
    {
//        if (Auth::guest()) {
//            return redirect('/');
//        }
					$user = JWTAuth::toUser($request->token);
//        if (! $request->user()->hasAnyRole($role))
//        {
//              abort(403);
//        }        
        if (! $user->hasAnyRole($role))
        {
              //abort(403);
			  return response()->json(['status'=>false,'message'=>'Permission Not allowed.']);

        }  

        if ($permission != null && ! $request->user()->can($permission)) {
            //abort(403);
						return response()->json(['status'=>false,'message'=>'Permission Not allowed.']);
        }


        return $next($request);
    }
}
