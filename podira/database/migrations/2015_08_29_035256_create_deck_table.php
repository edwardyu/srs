<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });       

        Schema::create('deckables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('deck_id')->unsigned();
            $table->morphs('deckable');
            $table->string('permissions');
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
        Schema::drop('decks');
        Schema::drop('deckables');
    }
}
