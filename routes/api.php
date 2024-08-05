<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonsController;
use App\Http\Controllers\AuthController;


Route::post('login',[AuthController::class,'login'])->withoutMiddleware('authbasic');;
/**
*Course routes
*
*/
Route::controller(CourseController::class)->group(function(){
	Route::get('courses','courses');
	Route::post('create-course','create');
	Route::post('update-course','update');
	Route::post('update-course-details','course_details');
	Route::delete('delete-course','delete');
})->middleware('authbasic');

/**
*Lessons routes
*
*/
Route::controller(LessonsController::class)->group(function(){
	Route::get('lessons','lessons');
	Route::get('course-lessons','course_lessons');
	Route::post('create-lesson','create');
	Route::post('update-lesson','update');
	Route::post('update-lesson-details','lesson_details');
	Route::delete('delete-lesson','delete');
})->middleware('authbasic');





// Route::get('/user', function (Request $request) {
    // return $request->user();
// })->middleware('auth:sanctum');
