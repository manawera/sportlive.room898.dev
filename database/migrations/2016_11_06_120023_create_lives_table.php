<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->smallInteger('channel_number')->default(0);
            $table->smallInteger('sort')->default(0);
            $table->smallInteger('tv_genre_id');
            $table->string('logo_url');
            $table->string('stream_url');
            $table->tinyInteger('protect_id')->default(1);
            $table->tinyInteger('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lives');
    }
}
