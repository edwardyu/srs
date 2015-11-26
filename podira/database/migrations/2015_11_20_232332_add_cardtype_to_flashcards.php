<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCardtypeToFlashcards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flashcards', function (Blueprint $table) {
            //
            $table -> String('cardtype');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flashcards', function (Blueprint $table) {
            $table->dropColumn(['cardtype']);
        });
    }
}
