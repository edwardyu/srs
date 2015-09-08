<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flashcardables', function(Blueprint $table) {
            $table->integer('num_incorrect')->default(0);
            $table->decimal('recall_score', 6, 3);
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
            $table->dropColumn(['num_incorrect', 'recall_score']);
        });
    }       
}
