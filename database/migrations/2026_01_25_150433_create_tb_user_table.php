<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbUserTable extends Migration
{
    public function up(): void
    {
        Schema::create('tb_user', function (Blueprint $table) {

            $table->smallIncrements('id_user'); 
            $table->smallInteger('id_level'); 
            $table->string('user_fullname', 250);
            $table->string('user_email', 250);
            $table->string('username', 100);
            $table->text('password');
            $table->tinyInteger('user_softdel');
            $table->dateTime('user_inserted_at');
            $table->smallInteger('user_inserted_by');
            $table->dateTime('user_last_updated');
            $table->smallInteger('user_updated_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_user');
    }
}
