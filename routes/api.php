<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;


Route::post('register',[ApiController::class,'register']);
Route::post('login',[ApiController::class,'login']);

/**
*Course routes
*
*/
Route::controller(CourseController::class)->group(function(){
	Route::get('courses','courses');
	Route::post('create-course','create');
	Route::post('update-course','update');
	Route::delete('delete-course','delete');
})->middleware('authbasic');

/**
*Lessons routes
*
*/
Route::controller(LessonsController::class)->group(function(){
	Route::get('lessons','lessons');
	Route::post('create-lesson','create');
	Route::get('update-lesson','update');
	Route::post('delete-lesson','delete');
});




Route::group(['middleware'=>['auth:sanctum']],function(){
	Route::get('profile',[ApiController::class,'profile']);
	Route::get('logout',[ApiController::class,'logout']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
