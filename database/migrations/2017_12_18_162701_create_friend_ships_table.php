<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friend_ships', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('requester')->unsigned();
            $table->integer('user_requested')->unsigned();
            $table->boolean('status')->default(0);

            $table->foreign('requester')->references('id')->on('users');
            $table->foreign('user_requested')->references('id')->on('users');

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
        Schema::dropIfExists('friendships');
    }
}