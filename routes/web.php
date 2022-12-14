<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

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

Route::middleware(["auth", "verified"])->group(function(){
    Route::get("/", function(){
        return inertia('Dashboard');
    })->name('dashboard');
    Route::prefix("dashboard")->group(function(){
        Route::get("/", function(){
           return inertia('Dashboard');
        })->name('dashboard');
        Route::resource("user", UserController::class)->except(["destroy", "show"]);
        Route::resource("role", RoleController::class)->except(["show"]);
    });
});

require __DIR__.'/auth.php';
