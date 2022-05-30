<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CourseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("register",[UserController::class, "register"])->name('user.registeration');
Route::post("login",[UserController::class, "login"])->name('user.login');

Route::group(["middleware" => ["auth:api"]], function(){

   Route::get("profile",[UserController::class, "profile"])->name('user.profile');
   Route::get("logout",[UserController::class, "logout"])->name('user.logout');


   ////course releted route
   Route::post("course/enroll",[CourseController::class, "courseEnrollment"])->name('course.enroll');
   Route::get("course/all",[CourseController::class, "totalCourses"])->name('course.all');
   Route::get("course/delete/{id}",[CourseController::class, "deleteCourse"])->name('course.delete');

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
