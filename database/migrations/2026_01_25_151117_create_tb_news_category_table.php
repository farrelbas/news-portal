<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbNewsCategoryTable extends Migration
{
    public function up(): void
    {
        Schema::create('tb_news_category', function (Blueprint $table) {
            $table->smallIncrements('id_news_category');
            $table->string('news_category_name', 50);
            $table->tinyInteger('news_category_softdel');
            $table->dateTime('news_category_inserted_at');
            $table->smallInteger('news_category_inserted_by');
            $table->dateTime('news_category_last_updated');
            $table->smallInteger('news_category_updated_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_news_category');
    }
}
