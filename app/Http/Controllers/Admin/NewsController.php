<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News\NewsModel;
use App\Models\News\NewsCategoryModel;


class NewsController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index(Request $request)
    {
        $news_category = NewsCategoryModel::where('news_category_softdel', 0)
            ->orderBy('news_category_name')
            ->get();

        $sortir = $request->sortir ?? 10;
        $search = $request->search;

        $data_news = NewsModel::join('tb_news_category', 'tb_news_category.id_news_category', '=', 'tb_news.id_news_category')
            ->join('tb_user', 'tb_user.id_user', '=', 'tb_news.news_updated_by')
            ->select([
                'tb_news.*',
                'tb_news_category.news_category_name',
                'tb_user.user_fullname'
            ])
            ->where('tb_news.news_softdel', 0);

        if ($search) {
            $data_news->where(function ($q) use ($search) {
                $q->where('tb_news.news_title', 'LIKE', "%{$search}%")
                    ->orWhere('tb_news_category.news_category_name', 'LIKE', "%{$search}%");
            });
        }

        $data_news = $data_news
            ->orderBy('tb_news.id_news', 'desc')
            ->paginate($sortir);

        return view('Admin.News.news', [
            'title'     => 'News',
            'data_news' => $data_news,
            'news_category' => $news_category
        ]);
    }


    public function store(Request $request)
    {
        $data = [
            'id_news_category'  => $request->id_news_category,
            'news_title'        => $request->news_title,
            'news_description'  => $request->news_description,
            'news_public'       => $request->news_public ?? 1,
            'news_start_date'   => $request->news_start_date,
            'news_end_date'     => $request->news_end_date,
            'news_last_updated' => now(),
            'news_updated_by'   => session('id_user'),
        ];

        if ($request->hasFile('news_picture')) {
            $file = $request->file('news_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('news_picture'), $filename);
            $data['news_picture'] = $filename;
        }

        if ($request->id_news) {
            NewsModel::where('id_news', $request->id_news)->update($data);
        } else {
            $data['news_softdel'] = 0;
            $data['news_inserted_at'] = now();
            $data['news_inserted_by'] = session('id_user');
            NewsModel::create($data);
        }

        return response()->json(['status' => true]);
    }


    public function delete(Request $request)
    {
        NewsModel::where('id_news', $request->id_news)->update([
            'news_softdel'       => 1,
            'news_last_updated' => now(),
            'news_updated_by'   => session('id_user'),
        ]);

        return response()->json(['status' => true]);
    }
}
