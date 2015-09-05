<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFlashcards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flashcardables', function(Blueprint $table) {
            $table->integer('num_correct');
            $table->timestamp('last_review_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flashcardables', function(Blueprint $table) {
            $table->dropColumn(['num_correct', 'last_review_time']);
        });
    }
}
