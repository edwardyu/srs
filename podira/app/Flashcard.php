<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    protected $fillable = ['front', 'back'];

    /**
     * Return the deck that owns the flashcard.
     */
    public function deck()
    {
    	return $this->morphedByMany('App\Deck', 'flashcardable');
    }
}
