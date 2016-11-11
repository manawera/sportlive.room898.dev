<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->rememberToken();
            $table->unsignedTinyInteger('role_id')->default(0);
            $table->string('mac_ethernet')->nullable();
            $table->string('mac_wifi')->nullable();
            $table->string('vip_key', 4)->default("8899");
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
        Schema::drop('users');
    }
}
