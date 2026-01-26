<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbNewsTable extends Migration
{
    public function up(): void
    {
        Schema::create('tb_news', function (Blueprint $table) {

            $table->smallIncrements('id_news');
            $table->smallInteger('id_news_category');
            $table->text('news_title');
            $table->text('news_description');
            $table->text('news_picture');
            $table->tinyInteger('news_public');
            $table->date('news_start_date');
            $table->date('news_end_date');
            $table->dateTime('news_inserted_at');
            $table->smallInteger('news_inserted_by');
            $table->dateTime('news_last_updated');
            $table->smallInteger('news_updated_by');
            $table->tinyInteger('news_softdel');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_news');
    }
}
