<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

 
Route::group(['middleware'=>['auth:sanctum']], function () {
    Route::get('/student',[StudentController::class, 'index']);
    Route::post('/student',[StudentController::class, 'store']);
    Route::put('/student/{id}',[StudentController::class, 'update']);
    Route::get('/student/{id}',[StudentController::class, 'show']);
    Route::delete('/student/{id}',[StudentController::class, 'destroy']);

    Route::post('/auth/user/logOut',[UserController::class, 'logOut']);  
});




Route::post('/auth/user',[UserController::class, 'store']);
Route::post('/auth/user/login',[UserController::class, 'logIn']);
