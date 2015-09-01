<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = ['time_spent'];

    /**
     * Return the user who owns the session.
     */
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    /**
     * Return the deck associated with the session.
     */
    public function deck()
    {
    	return $this->morphToMany('App\Deck', 'deckable');
    }

    /**
     * Return the flashcards associated with the session.
     */
    public function flashcards()
    {
    	return $this->morphToMany('App\Flashcard', 'flashcardable')->withPivot('interaction', 'correct');
    }
}
