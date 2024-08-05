<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login(Request $request)
	{
		try
		{
			$validateuser = validator::make($request->all(),[
			'email' => 'required|email',
			'password' => 'required',
			]);
			if($validateuser->fails()){
				return response()->json([
				'status' => false,
				'message' => 'Validation error',
				'errors' => $validateuser->errors()
				],422);
			}
			if(Auth::attempt($request->only(['email','password'])))
			{
				$userdata = Auth::user();
				return response()->json([
				'status' => true,
				'message' => 'User Logged  in successfully',
				'data'=>$userdata,
				],200);
			}else{
				return response()->json([
				'status' => false,
				'message' => 'Email & password does not match with our record'
				],401);
			}
		}catch(\Throwble $th){
			return response()->json([
			'status' => false,
			'message' => $th->getMessage(),
			],500);
		}
	}
}
