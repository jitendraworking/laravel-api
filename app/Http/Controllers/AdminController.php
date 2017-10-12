<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use JWTAuthException;
use Validator;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;


class adminController extends Controller
{

	public function __construct(User $user){
			
	}

	public function createRole(Request $request){
		$role = Role::create(['name' => $request->get('name')]);
        return response()->json(['result' => ['message' => 'Role created successfully.']]);
    }

	public function createPermission(Request $request){
		$permission = Permission::create(['name' => $request->get('name')]);
        return response()->json(['result' => ['message' => 'Permission created successfully.']]);
    }

	public function addRole(Request $request){
		$user = JWTAuth::toUser($request->token);
		
		$user->assignRole($request->get('name'));
		// You can also assign multiple roles at once
		//$user->assignRole('writer', 'admin');
		// or as an array
		//$user->assignRole(['writer', 'admin']);
        return response()->json(['result' => ['message' => 'Role added successfully.']]);
    }

	public function addPermission(Request $request){
		$user = JWTAuth::toUser($request->token);
		$user->givePermissionTo($request->get('name'));

		// You can also give multiple permission at once
		//$user->givePermissionTo('edit articles', 'delete articles');

		// You may also pass an array
		//$user->givePermissionTo(['edit articles', 'delete articles']);
        return response()->json(['result' => ['message' => 'Permission added successfully.']]);
    }

		public function addPermissionToRole(Request $request){
			$role = Role::findByName($request->get('name'));
			$role->givePermissionTo($request->get('permission'));
			return response()->json(['result' => ['message' => 'Permission added successfully to ' . $request->get('name') . ' role.']]);
		}

		private function validator($request, $dataFields){
		  return Validator::make($request->all(), $dataFields);

//			if ($validator->fails()) {
//				return response()->json($validator->errors(), 422);
//			}
		}

}
