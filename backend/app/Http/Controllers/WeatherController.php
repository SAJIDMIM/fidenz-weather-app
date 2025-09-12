<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather($cityId)
    {
        $apiKey = env('OPENWEATHER_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'API key not set'], 500);
        }

        try {
            $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
                'id' => $cityId,
                'appid' => $apiKey,
                'units' => 'metric'
            ]);

            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getAllCitiesWeather()
    {
        return response()->json(['message' => 'All cities weather route']);
    }
}
