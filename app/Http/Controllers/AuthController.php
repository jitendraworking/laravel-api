<?php
//This auth controller works only for api with jwt authentication
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use App\User;
use JWTAuthException;
use Validator;
use Socialite;

class AuthController extends Controller
{
    private $user;
    public function __construct(User $user){
        $this->user = $user;
    }
   
    public function register(Request $request){
//				$this->validate($request, [
//            'name' => 'required',
//            'email' => 'required|email|unique:users',
//						'password' => 'required|min:6'
//            //'password' => 'required|min:6|confirmed'
//           // 'roles' => 'required'
//        ]);

			$validator = $this->validator($request,[
					'name' => 'required',
					'email' => 'required|email|unique:users',
					'password' => 'required|min:6'
				]);
			if ($validator->fails()) {
				return response()->json($validator->errors(), 422);
			}
			$user = $this->user->create([
				'name' => $request->get('name'),
				'email' => $request->get('email'),
				'password' => bcrypt($request->get('password'))
			]);
			return response()->json(['status'=>true,'message'=>'User created successfully','data'=>$user]);
	}

	public function login(Request $request){
			//$data = json_decode($request->getContent());
			$credentials = $request->only('email', 'password');
			$token = null;
			try {
				 if (!$token = JWTAuth::attempt($credentials)) {
					return response()->json(['invalid_email_or_password'], 422);
				 }
			} catch (JWTAuthException $e) {
					return response()->json(['failed_to_create_token'], 500);
			}
			return response()->json(['token' => $token, 'user_info' => $this->getAuthUser($token)]);
	}
	
	public function logout(Request $request){
			JWTAuth::invalidate($request->token);
			return response()->json(['status'=>true,'message'=>'User logout successfully','data'=>array()]);
	}

	public function createRole(Request $request){
			$role = Role::create(['name' => $request->get('role')]);
			return response()->json(['result' => ['message' => 'Role created successfully.']]);
	}

	public function createPermission(Request $request){
			$permission = Permission::create(['name' => $request->get('permission')]);
			return response()->json(['result' => ['message' => 'Permission created successfully.']]);
	}

	private function validator($request, $dataFields){
			return Validator::make($request->all(), $dataFields);
	}

	private function getAuthUser($token){
			return JWTAuth::toUser($token);
	}


//    public function getAuthUser(Request $request){
//      $user = JWTAuth::toUser($request->token);
//			//$user->hasPermissionTo('edit articles');
//
//			//$user->hasAnyPermission(['edit articles', 'publish articles', 'unpublish articles']);
//
//			// get a list of all permissions directly assigned to the user
//			$permissions = $user->permissions;
//
//			// get all permissions inherited by the user via roles
//			$permissions1 = $user->getAllPermissions();
//
//			// get a collection of all defined roles
//			//$roles = $user->getRoleNames(); // Returns a collection   not working
//			$roles = \App\User::with('roles')->get();
//
//			$users = User::role('manager')->get(); // Returns only users with the role 'writer'
//
//        return response()->json(['result' => $user,'all roles' => $roles,'user direct_permissions' => $permissions,'user permissions' => $permissions1,'user data' => $users]);
//    }

}
