<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

// Weather API routes
Route::get('/weather/{cityId}', [WeatherController::class, 'getWeather']);
Route::get('/weather-all', [WeatherController::class, 'getAllCitiesWeather']);

// Test routes
Route::get('/test', function() {
    return response()->json([
        'message' => 'API is working!',
        'time' => now(),
        'status' => 'OK'
    ]);
});

Route::get('/test-weather', function() {
    $apiKey = env('OPENWEATHER_API_KEY');
    $cityId = 1248991;
    
    if (!$apiKey) {
        return response()->json(['error' => 'API key not set in .env'], 500);
    }
    
    try {
        $response = Http::timeout(30)->get("https://api.openweathermap.org/data/2.5/weather", [
            'id' => $cityId,
            'appid' => $apiKey,
            'units' => 'metric'
        ]);
        
        return response()->json([
            'api_key' => $apiKey,
            'status' => $response->status(),
            'data' => $response->json(),
            'success' => $response->successful()
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'api_key' => $apiKey
        ], 500);
    }
});