<?php

use App\Http\Controllers\API\LessonController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\RelationshipController;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\UserController;
use App\Models\Lesson;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1')->group(function () {

    Route::apiResource('lessons', LessonController::class);


    Route::any('lesson', function () {
        $message= "Please make sure to update your code to use the newer version of your api.
        you should use lessons instead of lesson";

        return response()->json(['data' => $message,'link' => url('documentation/api')], 404);
    });

    //Route::redirect('lesson', 'lessons');

    // users
    Route::apiResource('users',UserController::class);
    
    // tags
    Route::apiResource('tags',TagController::class);

    Route::get('users/{id}/lessons', [RelationshipController::class,'userLessons']);

    Route::get('lessons/{id}/tags', [RelationshipController::class,'lessonTags']);

    Route::get('tags/{id}/lessons', [RelationshipController::class,'tagLessons']);

    Route::get('/login', [LoginController::class,'login'])->name('login');
});

