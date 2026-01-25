<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News\NewsCategoryModel;

class NewsCategoryController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index(Request $request)
    {
        $sortir = $request->sortir ?? 10;
        $search = $request->search;

        $data_news_category = NewsCategoryModel::join('tb_user', 'tb_user.id_user', '=', 'tb_news_category.news_category_updated_by')
            ->select([
                'tb_news_category.*',
                'tb_user.user_fullname'
            ])
            ->where('tb_news_category.news_category_softdel', 0);

        if ($search) {
            $data_news_category->where('news_category_name', 'LIKE', "%{$search}%");
        }

        $data_news_category = $data_news_category
            ->orderBy('tb_news_category.id_news_category', 'desc')
            ->paginate($sortir);

        return view('Admin.News.news-category', [
            'title' => 'News Category',
            'data_news_category' => $data_news_category,
        ]);
    }

    public function store(Request $request)
    {
        if ($request->id_news_category) {

            NewsCategoryModel::where('id_news_category', $request->id_news_category)
                ->where('news_category_softdel', 0)
                ->update([
                    'news_category_name' => $request->news_category_name,
                    'news_category_last_updated' => now(),
                    'news_category_updated_by' => session('id_user'),
                ]);

            return response()->json([
                'status' => true,
                'message' => 'News category updated successfully'
            ]);
        }

        NewsCategoryModel::create([
            'news_category_name' => $request->news_category_name,
            'news_category_softdel' => 0,
            'news_category_inserted_at' => now(),
            'news_category_inserted_by' => session('id_user'),
            'news_category_last_updated' => now(),
            'news_category_updated_by' => session('id_user'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'News category added successfully'
        ]);
    }

    public function delete(Request $request)
    {
        NewsCategoryModel::where('id_news_category', $request->id_news_category)->update([
            'news_category_softdel' => 1,
            'news_category_last_updated' => now(),
            'news_category_updated_by' => session('id_user'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'News category deleted successfully'
        ]);
    }
}
