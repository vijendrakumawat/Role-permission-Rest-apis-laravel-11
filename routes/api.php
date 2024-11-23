<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PostController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Route::post('/profile', [AuthController::class, 'updateProfile']);
    Route::middleware('auth:api')->group(function () {
    Route::post('/profile', [AuthController::class, 'updateProfile']);
   
    Route::delete('/delete/{id}', [AuthController::class, 'destroy']);
    });
});
    Route::middleware('auth:api')->group(function () {
    Route::post('/role/store', [RoleController::class, 'store']);
    });
    Route::middleware(['auth:api', 'role:manager|admin|'])->group(function () {
        Route::post('/posts', [PostController::class, 'store']);
        Route::get('/posts', [PostController::class, 'index']);
        Route::put('/posts/{id}', [PostController::class, 'update']);
        Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    });
    Route::middleware(['auth:api', 'role:viewer|admin|manager'])->group(function () {
        Route::get('/posts', [PostController::class, 'index']);
    });
    // Route::middleware(['auth:api', 'role:manager'])->group(function () {
    //     Route::get('/posts', [PostController::class, 'index']);
    // });
    // Route::middleware('auth:api')->group(function () {
    //     Route::post('/post', [PostController::class, 'store']);
    // });
    // Route::middleware(['role:admin'])->group(function () {
    
    //     Route::put('/posts/{id}', [PostController::class, 'update']);
    //     Route::delete('/posts/{id}', [PostController::class, 'destroy']); 
    // });

