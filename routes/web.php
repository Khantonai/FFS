<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/experiences', [App\Http\Controllers\ExperienceController::class, 'index']);

