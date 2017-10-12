<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class postController extends Controller
{
    public function getPost(){
			$post = DB::table('post')->get();

			return response()->json(['status' => 'success', 'post' => $post]);
		}
}
