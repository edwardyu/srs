<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGlobalDecks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('decks', function(Blueprint $table) {
            $table->tinyInteger('public')->default(1);
        });

        Schema::create('global_decks', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('deck_id')->unsigned();
            $table->foreign('deck_id')->references('id')->on('decks');
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
        Schema::table('decks', function(Blueprint $table) {
            $table->dropColumn('public');
        });

        Schema::drop('global_decks');
    }
}
