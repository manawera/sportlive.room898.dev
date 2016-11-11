<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('topup_type_id');
            $table->unsignedTinyInteger('package_id')->nullable();
            $table->unsignedTinyInteger('plan_id')->nullable();
            $table->string('card_number', 14);
            $table->string('transaction_id', 30)->nullable();
            $table->double('amount', 10, 2)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->smallInteger('quantity')->nullable();
            $table->dateTime('expired')->nullable();
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('cards');
    }
}
