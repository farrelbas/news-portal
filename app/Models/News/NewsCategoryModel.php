<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategoryModel extends Model
{
    protected $table = 'tb_news_category';
    protected $primaryKey = 'id_news_category';
    public $timestamps = false;

    protected $fillable = [
        'news_category_name',
        'news_category_softdel',
        'news_category_inserted_at',
        'news_category_inserted_by',
        'news_category_last_updated',
        'news_category_updated_by',
    ];

    public function news()
    {
        return $this->hasMany(NewsModel::class, 'id_news_category', 'id_news_category')
            ->where('news_public', 1)
            ->where('news_softdel', 0)
            ->where(function ($q) {
                $q->whereNull('news_start_date')
                    ->orWhere('news_start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('news_end_date')
                    ->orWhere('news_end_date', '>=', now());
            })
            ->orderBy('news_inserted_at', 'desc');
    }
}
