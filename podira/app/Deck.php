<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{

	protected $fillable = ['name'];

	/**
	 * Return the flashcards contained in the deck.
	 */
    public function flashcards()
    {
    	return $this->morphToMany('App\Flashcard', 'flashcardable');
    }

    /**
     * Returns the users that are able to access this deck.
     */
    public function users()
    {
    	return $this->morphedByMany('App\User', 'deckable')->withPivot('permissions');
    }
}
