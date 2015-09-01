<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlashcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flashcards', function (Blueprint $table) {
            $table->increments('id');
            $table->text('front');
            $table->text('back');
            $table->timestamps();
        });

        Schema::create('flashcardables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('flashcard_id')->unsigned();
            $table->morphs('flashcardable');
            $table->text('interaction');
            $table->tinyInteger('correct');
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
        Schema::drop('flashcards');
        Schema::drop('flashcardables');
    }
}
