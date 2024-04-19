<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExperienceController;

Route::get('/', function () {
    return view('index');
});

Route::get('/experiences', [ExperienceController::class, 'index'])->name('experiences.index');

Route::get('/experiences/create', [ExperienceController::class, 'create'])->name('experiences.create');
Route::post('/experiences/create', [ExperienceController::class, 'store'])->name('experiences.create');

Route::get('/experiences/{experience}', [ExperienceController::class, 'show'])->name('experiences.show');


// Route::resource('experiences', ExperienceController::class);
