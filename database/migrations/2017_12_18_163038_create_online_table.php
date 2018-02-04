<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onlines', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->integer('group_chat')->nullable();
            $table->integer('friend_chat')->nullable();
            $table->string('timelogin');
            $table->string('timelogout')->nullable();

            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('online_groups');
    }
}
