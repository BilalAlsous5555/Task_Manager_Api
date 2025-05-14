<?php

use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('register',[AuthController::class , 'register']);
Route::post('login',[AuthController::class , 'login']);
Route::delete('logout', [AuthController::class ,'logout'])->middleware('auth:sanctum');


Route::apiResource('tasks', TaskController::class)->middleware('auth:sanctum');
Route::apiResource('status', StatusController::class)->middleware('auth:sanctum');
Route::post('search', [TaskController::class,'search'])->middleware('auth:sanctum');