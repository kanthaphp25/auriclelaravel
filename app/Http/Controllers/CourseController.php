<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Course;
use DB;

class CourseController extends Controller
{
    public function courses(Request $request)
	{
		$products_data = Course::where('title','!=','');
		if(isset($request->name) & $request->name != '')
		{
			$products_data = Product::where('name',$request->name);
		}
		$products_data = $products_data->paginate(3);
		return response()->json([
		'status' => true,
		'message' => 'products listed successfully',
		'data' => $products_data
		],200);
	}
    public function create(Request $request)
	{
		$validate = Validator::make($request->all(),[
		'title' => 'required|string',
		'description' => 'required',
		'instructor' => 'required',
		'duration' => 'required',
		]);
		if($validate->fails())
		{
			return response()->json([
			'status' => false,
			'message' => 'validation error',
			'error' => $validate->errors()
			],422);
		}
		$inputdata = array(
		'title' => trim($request->title),
		'description' => $request->description,
		'instructor' => $request->instructor,
		'duration' => $request->duration,
		);
//isset($request->description) ? $request->description 
		$course = Course::create($inputdata);
			return response()->json([
			'status' => true,
			'message' => 'Product created successfully',
			'data' => $course
			],200);
	}
    public function update(Request $request)
	{
		// echo "hi";exit;
		// dd($request);
		$validate = Validator::make($request->all(),[
		'course_id' => 'required',
		'title' => 'required|string',
		'description' => 'required',
		'instructor' => 'required',
		'duration' => 'required',
		]);
		if($validate->fails())
		{
			return response()->json([
			'status' => false,
			'message' => 'validation error',
			'error' => $validate->errors()
			],422);
		}
		$course = Course::find($request->course_id);
		$course->title = $request->description;
		$course->description = $request->description;
		$course->instructor = $request->instructor;
		$course->duration = $request->duration;
		$course->save();
		return response()->json([
		'status' => true,
		'message' => 'Course updated successfully',
		'data' => $course
		],200);
	}
    public function delete(Request $request)
	{
		$productvalidate = Validator::make($request->all(),[
		'course_id' => 'required|exists:courses,id',
		]);
		if($productvalidate->fails())
		{
			return response()->json([
			'status' => false,
			'message' => 'validation error',
			'error' => $productvalidate->errors()
			],422);
		}
		Course::find($request->course_id)->delete();
		return response()->json([
		'status' => true,
		'message' => 'Product deleted successfully',
		],200);
	}
}
