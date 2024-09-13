<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TodolistController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\MemberMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class,"home"]);

Route::controller(UserController::class)->group(function(){
    Route::get("/login","loginPage")->middleware(GuestMiddleware::class);
    Route::post("/login","userLogin")->middleware(GuestMiddleware::class);
    Route::post("/logout","userLogout")->middleware(MemberMiddleware::class);
});

Route::controller(TodolistController::class)->middleware(MemberMiddleware::class)->group(function(){
    Route::get("/todolist","todolistPage");
    Route::post("/todolist","addTodo");
    Route::post("/todolist/{id}/delete","removeTodo");
});