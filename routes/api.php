<?php

use App\Models\DietStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\FoodController;
use App\Models\Allergies;
use App\Models\Diseases;
use App\Models\Activity;
use App\Models\BodyType;
use App\Models\FoodCategory;

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
    Route::get('food-categories', function(){
        return  FoodCategory::all();
    });
    Route::get('diet-statuses', function(){
        return  DietStatus::all();
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
    Route::get('/get-blog/{id}', [BlogController::class, 'getBlog']);
    Route::get("/get-all-food", [FoodController::class, "getAllFood"]);
    Route::get("/get-all-users", [UserController::class, "getAllUsers"]);
    Route::get("/get-all-diet-requests", [DietController::class, "getAllDietRequests"]);
    Route::post("/update-food", [FoodController::class, "updateFood"]);
    Route::get("/delete-food/{id}", [FoodController::class, "deleteFood"]);
    Route::get("/delete-user/{id}", [UserController::class, "deleteUser"]);
    Route::get("/delete-diet-request/{id}", [DietController::class, "deleteDietRequest"]);
    Route::get("/generate-diet/{id}", [DietController::class, "generateDiet"]);
    Route::get("/get-diet/{id}", [DietController::class, "getDiet"]);
    Route::post("set-diet-status", [DietController::class, "changeDietRequestStatus"]);
});
