<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbLevelTable extends Migration
{
    public function up(): void
    {
        Schema::create('tb_level', function (Blueprint $table) {

            $table->smallIncrements('id_level');
            $table->string('level_name', 50);
            $table->tinyInteger('level_softdel');
            $table->dateTime('level_inserted_at');
            $table->smallInteger('level_inserted_by');
            $table->dateTime('level_last_updated');
            $table->smallInteger('level_updated_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_level');
    }
}
