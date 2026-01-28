<?php

namespace App\Http\Controllers\GeneralUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function dashboard()
    {
        $weather = $this->getWeatherJakarta();

        return view('Public.Dashboard.dashboard', [
            'title' => 'Dashboard',
            'weather' => $weather,
        ]);
    }

    private function getWeatherJakarta()
    {
        $apiKey = config('services.openweather.key');

        if (!$apiKey) {
            return null;
        }

        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'lat'   => -6.2088,
            'lon'   => 106.8456,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'id'
        ]);

        // dd($response->status(), $response->json());
        // dd(
        //     env('OPENWEATHER_API_KEY'),
        //     config('services.openweather.key')
        // );

        if ($response->successful()) {
            return [
                'temp' => round($response['main']['temp']),
                'city' => strtoupper($response['name']),
                'icon' => $response['weather'][0]['icon'],
                'desc' => ucfirst($response['weather'][0]['description']),
                'date' => now()->translatedFormat('D, d M Y')
            ];
        }

        return null;
    }
}
