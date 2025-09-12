<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    public function getWeather($cityId)
    {
        $cacheKey = 'weather_' . $cityId;

        // Return cached data if exists
        if (Cache::has($cacheKey)) {
            $cachedData = Cache::get($cacheKey);
            return response()->json([
                'List' => [
                    $this->formatWeatherData($cachedData, $cityId)
                ]
            ]);
        }

        // Get OpenWeatherMap API key from .env
        $apiKey = env('OPENWEATHER_API_KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'API key not set'], 500);
        }

        // Call OpenWeatherMap API
        try {
            $response = Http::timeout(30)->get("https://api.openweathermap.org/data/2.5/weather", [
                'id' => $cityId,
                'appid' => $apiKey,
                'units' => 'metric'
            ]);

            if ($response->failed()) {
                return response()->json(['error' => 'Failed to fetch weather data'], 500);
            }

            $data = $response->json();

            // Cache response for 5 minutes
            Cache::put($cacheKey, $data, now()->addMinutes(5));

            // Return in your desired format
            return response()->json([
                'List' => [
                    $this->formatWeatherData($data, $cityId)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Get weather data for all cities
     */
    public function getAllCitiesWeather()
    {
        $cityIds = $this->loadCityCodesFromJson();
        $result = [];

        foreach ($cityIds as $cityId) {
            $cacheKey = 'weather_' . $cityId;
            
            if (Cache::has($cacheKey)) {
                $data = Cache::get($cacheKey);
                $result[] = $this->formatWeatherData($data, $cityId);
            } else {
                // Fetch fresh data if not cached
                $apiKey = env('OPENWEATHER_API_KEY');
                
                if (!$apiKey) {
                    continue; // Skip if no API key
                }
                
                try {
                    $response = Http::timeout(30)->get("https://api.openweathermap.org/data/2.5/weather", [
                        'id' => $cityId,
                        'appid' => $apiKey,
                        'units' => 'metric'
                    ]);
                    
                    if ($response->successful()) {
                        $data = $response->json();
                        Cache::put($cacheKey, $data, now()->addMinutes(5));
                        $result[] = $this->formatWeatherData($data, $cityId);
                    }
                } catch (\Exception $e) {
                    // Log error but continue with other cities
                    Log::error("Failed to fetch weather for city $cityId: " . $e->getMessage());
                }
            }
        }

        return response()->json(['List' => $result]);
    }

    /**
     * Format the weather data to match your desired structure
     */
    private function formatWeatherData($weatherData, $cityId)
    {
        // Get city name from API response or use a mapping
        $cityName = $weatherData['name'] ?? $this->getCityNameById($cityId);
        
        return [
            'CityCode' => $cityId,
            'CityName' => $cityName,
            'Temp' => $weatherData['main']['temp'] ?? 'N/A',
            'Status' => $weatherData['weather'][0]['main'] ?? 'N/A'
        ];
    }

    /**
     * Map city IDs to names (fallback if API doesn't return name)
     */
    private function getCityNameById($cityId)
    {
        $cityMap = [
            '1248991' => 'Colombo',
            '1850147' => 'Tokyo',
            '2644210' => 'Liverpool',
            '2988507' => 'Paris',
            '2147714' => 'Sydney',
            '4930956' => 'Boston',
            '1796236' => 'Shanghai',
            '3143244' => 'Oslo'
        ];

        return $cityMap[$cityId] ?? 'Unknown City';
    }

    /**
     * Load city codes from JSON file or return default ones
     */
    private function loadCityCodesFromJson()
    {
        $jsonPath = storage_path('app/cities.json');
        
        if (file_exists($jsonPath)) {
            $cities = json_decode(file_get_contents($jsonPath), true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($cities)) {
                return array_column($cities, 'CityCode');
            }
        }
        
        // Fallback to hardcoded IDs
        return ['1248991', '1850147', '2644210', '2988507', '2147714', '4930956', '1796236', '3143244'];
    }
}