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
    	return $this->hasMany('App\Flashcard');
    }
}
