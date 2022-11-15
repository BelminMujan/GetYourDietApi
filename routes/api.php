<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DietController;
use App\Models\Allergies;
use App\Models\Diseases;
use App\Models\Activity;
use App\Models\BodyType;

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

Route::post("login", [UserController::class, "login"]);
Route::post("register", [UserController::class, "register"]);
Route::post('diet-request', [DietController::class, 'requestDiet']);
Route::prefix('load')->group(function(){
    Route::get('allergies', function(){
        return  Allergies::all();
    });
    Route::get('diseases', function(){
        return  Diseases::all();
    });
    Route::get('activities', function(){
        return  Activity::all();
    });
    Route::get('body-types', function(){
        return  BodyType::all();
    });
});

Route::middleware("auth:sanctum")->group(function (){
    Route::get("/user", function (Request $request) {
        return $request->user();
    });
    Route::post("/update-user", [UserController::class, "updateUser"]);
    Route::post("/save-blog", [BlogController::class, "saveBlog"]);
    Route::get("/create-blog", [BlogController::class, "createBlog"]);
    Route::get("/delete-blog/{id}", [BlogController::class, "deleteBlog"]);
    Route::get("/get-all-blogs", [BlogController::class, "getAllBlogs"]);
});