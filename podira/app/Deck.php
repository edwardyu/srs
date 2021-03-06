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

    /**
    * Return the sessions associated with this deck.
    */
    public function sessions()
    {
        return $this->morphedByMany('App\Session', 'deckable');
    }

    /**
     * Return a clone of this deck. 
     */
    public function clone()
    {
        $newDeck = Deck::create([
            'name' => $this->name
        ]);

        foreach($this->flashcards as $card) {
            $newCard = Flashcard::create([
                'front' => $card->front;
                'back' => $card->back;
            ]);
            $newDeck->flashcards()->save($newCard);
        }

        return $newDeck;
    }
}
