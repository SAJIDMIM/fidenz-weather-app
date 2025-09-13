<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function getWeather($cityId)
    {
        $apiKey = env('OPENWEATHER_API_KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'API key not set'], 500);
        }

        $cacheKey = "weather_{$cityId}";

        // Return cached data if exists
        if (Cache::has($cacheKey)) {
            return response()->json(Cache::get($cacheKey));
        }

        try {
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'id' => $cityId,
                'appid' => $apiKey,
                'units' => 'metric'
            ]);

            if ($response->failed()) {
                return response()->json(['error' => 'Failed to fetch weather data'], 500);
            }

            $data = $response->json();

            // Cache for 5 minutes
            Cache::put($cacheKey, $data, now()->addMinutes(5));

            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}