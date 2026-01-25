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
}
