<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;


Route::get('/', function () {
    return view('index');
});

Route::get('/experiences', [ExperienceController::class, 'index'])->name('experiences.index');
Route::get('/experiences/create', [ExperienceController::class, 'create'])->name('experiences.create');
Route::post('/experiences/create', [ExperienceController::class, 'store'])->name('experiences.create');
Route::get('/experiences/{experience}', [ExperienceController::class, 'show'])->name('experiences.show');
Route::get('/experiences/{experience}/edit', [ExperienceController::class, 'edit'])->name('experiences.edit');
Route::post('dashboard/experiences/{experience}',[ExperienceController::class,'publish'])->name('experiences.publish');
Route::put('/experiences/{experience}/edit', [ExperienceController::class, 'update'])->name('experiences.update');


Route::get('/dashboard', [UserController::class, 'index'])->name('users.index');

// Route::get('/users/create/{token}', 'UserController@create')->name('users.create');
// Route::post('/users/create/{token}', [UserController::class, 'store'])->name('users.store');

Route::post('/dashboard', [LoginController::class, 'storeToken'])->name('users.storeToken');


Route::get('/login', [LoginController::class, 'index'])->name('users.login');
Route::post('/login', [LoginController::class, 'login'])->name('users.login');
Route::get('/register', [UserController::class, 'create'])->name('users.create');
Route::post('/regiter', [UserController::class, 'store'])->name('users.register');
Route::post('/logout', [LogoutController::class, 'logout'])->name('users.logout');


