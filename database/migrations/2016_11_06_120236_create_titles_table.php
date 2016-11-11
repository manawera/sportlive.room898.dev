<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('name_local', 100)->nullable();
            $table->unsignedTinyInteger('kind_id');
            $table->unsignedTinyInteger('genre_id');
            $table->unsignedInteger('episode_of_id')->nullable();
            $table->unsignedTinyInteger('season')->nullable();
            $table->unsignedSmallInteger('episode')->nullable();
            $table->unsignedSmallInteger('series_started_year')->nullable();
            $table->unsignedSmallInteger('series_ended_year')->nullable();
            $table->string('poster_url');
            $table->string('stream_url');
            $table->string('stream_url_en');
            $table->tinyInteger('protect_id')->default(1);
            $table->tinyInteger('active')->default(1);
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
        Schema::dropIfExists('titles');
    }
}
