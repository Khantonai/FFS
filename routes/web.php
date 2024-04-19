<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;


Route::get('/', function () {
    return view('index');
});

Route::get('/experiences', [ExperienceController::class, 'index'])->name('experiences.index');
Route::get('/experiences/create', [ExperienceController::class, 'create'])->name('experiences.create');
Route::post('/experiences/create', [ExperienceController::class, 'store'])->name('experiences.create');
Route::get('/experiences/{experience}', [ExperienceController::class, 'show'])->name('experiences.show');
Route::get('/experiences/{experience}/edit', [ExperienceController::class, 'edit'])->name('experiences.edit');


Route::get('/dashboard', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/create', [UserController::class, 'store'])->name('users.store');


Route::get('/login', [LoginController::class, 'index'])->name('users.login');
Route::post('/login', [LoginController::class, 'login'])->name('users.login');


// Route::resource('experiences', ExperienceController::class);
