<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\FavoriteController;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;


use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\UserController;


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/favorites/add', [FavoriteController::class, 'add']);
    Route::post('/favorites/remove', [FavoriteController::class, 'remove']);
    Route::get('/favorites', [FavoriteController::class, 'index']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

Route::middleware('auth:sanctum')->get('/profile', [AuthController::class, 'profile']);
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Categories CRUD
Route::apiResource('categories', CategoryController::class);

Route::put('/categories/{id}', [CategoryController::class, 'update']);

// Courses CRUD
Route::apiResource('courses', CourseController::class);

// Videos CRUD (مع رفع الملفات داخل store/update)
Route::apiResource('videos', VideoController::class);

Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::apiResource('posts', PostController::class);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/signup', [AuthController::class, 'signup']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    
});
use App\Models\User;

Route::get('/users', function () {
    return response()->json(User::all());
});

Route::get('/stream/{filename}', function ($filename) {

    $path = storage_path("app/public/videos/" . basename($filename));

    if (!file_exists($path)) {
        return response()->json([
            'error' => 'File not found',
            'path' => $path
        ]);
    }

    return response()->file($path, [
        'Content-Type' => 'video/mp4',
        'Accept-Ranges' => 'bytes',
    ]);
});