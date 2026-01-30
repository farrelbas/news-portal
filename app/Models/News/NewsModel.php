<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    protected $table = 'tb_news';
    protected $primaryKey = 'id_news';
    public $timestamps = false;

    protected $fillable = [
        'id_news_category',
        'news_title',
        'news_description',
        'news_picture',
        'news_public',
        'news_start_date',
        'news_end_date',
        'news_views',
        'news_inserted_at',
        'news_inserted_by',
        'news_last_updated',
        'news_updated_by',
        'news_softdel',
    ];

    public function category()
    {
        return $this->belongsTo(
            NewsCategoryModel::class,
            'id_news_category',
            'id_news_category'
        );
    }
}
