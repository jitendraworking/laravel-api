<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //use AuthenticatesUsers;
		use AuthenticatesUsers {
				logout as performLogout;
		}

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

//		public function logout(Request $request)
//		{	
//			 if(\Auth::check()) {
//						//$this->socialite->driver('google')->deauthorize(\Auth::user()->access_token);
//						//\Auth::user()->access_token = '';
//						//\Auth::user()->save();
//						//$this->auth->logout();   
//						//return $listener->userHasLoggedOut();
//						$this->performLogout($request);
//				}
//			//return redirect()->route('/home');
//			return redirect()->action('HomeController@index');
//		}
}
