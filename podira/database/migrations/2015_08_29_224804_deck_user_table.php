<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeckUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deck_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('deck_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('permissions');
            $table->timestamps();

            $table->foreign('deck_id')
                  ->references('id')
                  ->on('decks');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('deck_user');
    }
}
