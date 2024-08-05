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
		$course_data = Course::where('title','!=','');
		if(isset($request->title) & $request->title != '')
		{
			$course_data = Course::where('title',$request->title);
		}
		$course_data = $course_data->paginate(10);
		return response()->json([
		'status' => true,
		'message' => 'products listed successfully',
		'data' => $course_data
		],200);
	}
    public function course_details(Request $request)
	{
		$course_data = Course::find($request->id);
		return response()->json([
		'status' => true,
		'message' => 'products listed successfully',
		'data' => $course_data
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
		$course = Course::create($inputdata);
			return response()->json([
			'status' => true,
			'message' => 'Product created successfully',
			'data' => $course
			],200);
	}
    public function update(Request $request)
	{
		$validate = Validator::make($request->all(),[
		'id' => 'required',
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
		$course = Course::find($request->id);
		$course->title = $request->title;
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
		'id' => 'required|exists:courses,id',
		]);
		if($productvalidate->fails())
		{
			return response()->json([
			'status' => false,
			'message' => 'validation error',
			'error' => $productvalidate->errors()
			],422);
		}
		Course::find($request->id)->delete();
		return response()->json([
		'status' => true,
		'message' => 'Product deleted successfully',
		],200);
	}
}
