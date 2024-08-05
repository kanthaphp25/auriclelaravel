<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use DB;

class LessonsController extends Controller
{
    public function lessons(Request $request)
	{
		$lession_data = Lesson::where('title','!=','');
		if(isset($request->title) & $request->title != '')
		{
			$lession_data = Lesson::where('title',$request->title);
		}
		$lession_data = $lession_data->paginate(10);
		return response()->json([
		'status' => true,
		'message' => 'Lessons listed successfully',
		'data' => $lession_data
		],200);
	}
    public function course_lessons(Request $request)
	{
		$lession_data = Course::find($request->id)->lessons;
		//$lession_data = $lession_data->paginate(10);
		return response()->json([
		'status' => true,
		'message' => 'Lessons listed successfully',
		'data' => $lession_data
		],200);
	}
    public function lesson_details(Request $request)
	{
		$lession_data = Lesson::find($request->id);
		return response()->json([
		'status' => true,
		'message' => 'products listed successfully',
		'data' => $lession_data
		],200);
	}
    public function create(Request $request)
	{
		$validate = Validator::make($request->all(),[
		'title' => 'required|string',
		'content' => 'required',
		'course_id' => 'required',
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
		'title' => $request->title,
		'content' => $request->content,
		'course_id' => $request->course_id,
		);
		DB::enableQueryLog();
		$lesson = Lesson::create($inputdata);
		$query = DB::getQueryLog();
		// dd($query);
			return response()->json([
			'status' => true,
			'message' => 'Lesson created successfully',
			'data' => $lesson
			],200);
	}
    public function update(Request $request)
	{
		$validate = Validator::make($request->all(),[
		'id' => 'required',
		'course_id' => 'required',
		'title' => 'required|string',
		'content' => 'required',
		]);
		if($validate->fails())
		{
			return response()->json([
			'status' => false,
			'message' => 'validation error',
			'error' => $validate->errors()
			],422);
		}
		DB::enableQueryLog();
		$lesson = Lesson::find($request->id);
		$query = DB::getQueryLog();
		// dd($query);
		$lesson->title = $request->title;
		$lesson->content = $request->content;
		$lesson->course_id = $request->course_id;
		$lesson->save();
		return response()->json([
		'status' => true,
		'message' => 'Lesson updated successfully',
		'data' => $lesson,
		],200);
	}
    public function delete(Request $request)
	{
		$validate = Validator::make($request->all(),[
		'id' => 'required|exists:lessons,id',
		]);
		if($validate->fails())
		{
			return response()->json([
			'status' => false,
			'message' => 'validation error',
			'error' => $validate->errors()
			],422);
		}
		Lesson::find($request->id)->delete();
		return response()->json([
		'status' => true,
		'message' => 'Lesson deleted successfully',
		],200);
	}
}
