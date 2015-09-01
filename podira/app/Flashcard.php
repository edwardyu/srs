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

    /** 
     * Return the sessions that have interacted with this flashcard.
     */
    public function sessions()
    {
    	return $this->morphedByMany('App\Session', 'flashcardable')->withPivot('interaction', 'correct');
    }
}
