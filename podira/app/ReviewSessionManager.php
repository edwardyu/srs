<?php
/**
 * Manages a session intented to review material.
 */
namespace App;

use DB;

class ReviewSessionManager extends AbstractSessionManager
{	
	public function start()
	{
		//load all flashcards that the user has learned in the past. 
		$pastSessions = $this->user->sessions()->with('flashcards')->get();
		$deckFlashcards = $this->deck->flashcards;
		$sessionFlashcards = collect([]);
		
		foreach($pastSessions as $session) {
			$sessionFlashcards->merge(
				$session->flashcards()->where('correct', 1)->get()
			);
		}

		//for each deck, we want this information: last_review_time, num_correct, next_review_time
		$this->usableFlashcards = $sessionFlashcards->intersect($deckFlashcards);
		$this->originalFlashcards = $this->usableFlashcards;

		$this->session = new \App\Session(['type' => 'review']);
        $this->user->sessions()->save($this->session);
        $this->session->deck()->save($this->deck);		
		$this->startTime = microtime();
	}
}