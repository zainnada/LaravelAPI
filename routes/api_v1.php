<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('tickets', \App\Http\Controllers\Api\V1\TicketController::class)
    ->middleware('auth:sanctum');

Route::post('/login',[AuthController::class,'login']);

//Route::get('/user', [\App\Http\Controllers\Api\V1\UsersController::class,'index'])->middleware('auth:sanctum');
Route::apiResource(
    'users',
    \App\Http\Controllers\Api\V1\UsersController::class
)->middleware('auth:sanctum');
