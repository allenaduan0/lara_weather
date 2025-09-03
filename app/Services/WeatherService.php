<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService {
    protected $apiKey;

    public function __construct(){
        $this->apiKey = env('OPENWEATHER_API_KEY');
    }

    public function getWeather(string $city): ?array {
        try {
            $response = Http::timeout(5)->get(
                "https://api.openweathermap.org/data/2.5/weather",
                [
                    'q' => $city,
                    'appid' => $this->apiKey,
                    'units' => 'metric'
                ]
            );

            if($response->successful()){
                return $response->json();
            }

            return null;
        } catch(\Exception $e){
            \Log::error("Weather API error: " . $e->getMessage());
            return null;
        }
    }
}