<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ApiPostController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Public Route 
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);


Route::get('/posts',[ApiPostController::class, 'index']);
Route::get('/posts/{post}',[ApiPostController::class, 'show'])->middleware('auth:sanctum');
Route::post('/posts/create',[ApiPostController::class, 'store'])->middleware('auth:sanctum');
Route::put('/posts/{post}',[ApiPostController::class,'update'])->middleware('auth:sanctum');
Route::delete('/posts/{post}',[ApiPostController::class,'destroy'])->middleware('auth:sanctum');
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
// Route::apiResource('/posts',ApiPostController::class);