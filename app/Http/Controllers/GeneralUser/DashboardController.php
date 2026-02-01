<?php

namespace App\Http\Controllers\GeneralUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\News\NewsCategoryModel;
use App\Models\News\NewsModel;

class DashboardController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function dashboard()
    {
        $weather = $this->getWeatherJakarta();

        $categories = NewsCategoryModel::with('news')
            ->where('news_category_softdel', 0)
            ->get()
            ->filter(fn($c) => $c->news->isNotEmpty())
            ->sortByDesc(fn($c) => $c->news->first()->news_inserted_at)
            ->take(4);

        $latest_news = NewsModel::with('category')
            ->where('news_public', 1)
            ->where('news_softdel', 0)
            ->where(function ($q) {
                $q->whereNull('news_start_date')
                    ->orWhereDate('news_start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('news_end_date')
                    ->orWhereDate('news_end_date', '>=', now());
            })
            ->orderBy('news_inserted_at', 'desc')
            ->limit(10)
            ->get();

        // dd(
        //     $categories->map(fn($c) => [
        //         'category' => $c->news_category_name,
        //         'total_news' => $c->news->count(),
        //         'latest_news' => optional($c->news->first())->news_title,
        //     ])
        // );

        return view('Public.Dashboard.dashboard', [
            'title' => 'Dashboard',
            'weather' => $weather,
            'categories' => $categories,
            'latest_news' => $latest_news,
        ]);
    }

    public function news_detail($id)
    {
        $weather = $this->getWeatherJakarta();

        $news = NewsModel::with('category')
            ->where('id_news', $id)
            ->where('news_public', 1)
            ->where('news_softdel', 0)
            ->where(function ($q) {
                $q->whereNull('news_start_date')
                    ->orWhereDate('news_start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('news_end_date')
                    ->orWhereDate('news_end_date', '>=', now());
            })
            ->firstOrFail();

        $news->increment('news_views');

        $related_news = NewsModel::where('id_news_category', $news->id_news_category)
            ->where('id_news', '!=', $news->id_news)
            ->where('news_public', 1)
            ->where('news_softdel', 0)
            ->where(function ($q) {
                $q->whereNull('news_start_date')
                    ->orWhereDate('news_start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('news_end_date')
                    ->orWhereDate('news_end_date', '>=', now());
            })
            ->orderBy('news_inserted_at', 'desc')
            ->limit(5)
            ->get();

        return view('Public.Dashboard.news-detail', [
            'title' => strip_tags($news->news_title),
            'weather' => $weather,
            'news' => $news,
            'related_news' => $related_news,
        ]);
    }

    public function getWeatherJakarta()
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
