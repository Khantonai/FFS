<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/experiences', [App\Http\Controllers\ExperienceController::class, 'index']);

Route::get('/experiences/{experience}', [App\Http\Controllers\ExperienceController::class, 'show']);
