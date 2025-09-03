<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService){
        $this->weatherService = $weatherService;
    }

    // test postman: https://api.openweathermap.org/data/2.5/weather?q=Manila&appid=c3c7a0ca334e12aab338990adebaf425&units=metric
    public function index(Request $request){
        $request->validate([
            'city' => 'nullable|string|max:255'
        ]);

        $city = $request->input('city', 'Dubai');

        $weather = cache()->remember("weather_{$city}", 10*60, function() use ($city) {
            return $this->weatherService->getWeather($city);
        });

        return view('weather', compact('weather', 'city'));
    }
    
}