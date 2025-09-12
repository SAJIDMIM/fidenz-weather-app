<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

// Weather API routes
Route::get('/weather/{cityId}', [WeatherController::class, 'getWeather']);
Route::get('/weather-all', [WeatherController::class, 'getAllCitiesWeather']);

// Test route
Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!',
        'time' => now(),
        'status' => 'OK'
    ]);
});
