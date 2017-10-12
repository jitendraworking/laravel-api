<?php

namespace App\Http\Controllers;

use Socialite;
use App\User;
//for api login
use JWTAuth;
//for web login
use Auth;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
			//for web app
			//return Socialite::driver($provider)->redirect();

			//for api return url for social login
			$url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
			return response()->json(['status' => 'success', 'url' => $url]);
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that 
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
			//for web app
			//$user = Socialite::driver($provider)->user();
			//$authUser = $this->findOrCreateUser($user, $provider);
			//Auth::login($authUser, true);
			//return redirect()->action('HomeController@index');

			//for api get user
			$user = Socialite::driver($provider)->stateless()->user();
			$authUser = $this->findOrCreateUser($user, $provider);

			//genrate jwt token for api
			$token = null;
			try {
//				$customClaims = ['fruit' => 'apple', 'herb' => 'basil'];
//				$payload = JWTFactory::make($customClaims);
//				$token = JWTAuth::encode($payload);
				if (!$token = JWTAuth::fromUser($authUser)) {
					return response()->json(['invalid_auth code'], 422);
				}
			} catch (JWTAuthException $e) {
					return response()->json(['failed_to_create_token'], 500);
			}
			return response()->json(['token' => $token, 'user_data' => $this->getAuthUser($token)]);
			


		 
			//return redirect($this->redirectTo);
			//return view ( 'welcome' )->withDetails ( $user )->withService ( $provider );

			// $user->token;
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
		public function findOrCreateUser($user, $provider)
    {
			$authUser = User::where('provider_id', $user->id)->where('provider', $provider)->first();
			if ($authUser) {
					return $authUser;
			}
			return User::create([
					'name'     => $user->name,
					'email'    => $user->email,
					'provider' => $provider,
					'provider_id' => $user->id
			]);
    }

		private function getAuthUser($token){
			$user = JWTAuth::toUser($token);
			return ['status' => 'success', 'user' => $user];
	}
}