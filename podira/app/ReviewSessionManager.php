<?php
/**
 * Manages a session intented to review material.
 */
namespace App;

use DB;

class ReviewSessionManager extends AbstractSessionManager
{	
	protected function getSessionFlashcards()
	{
		//for each deck, we want this information: last_review_time, num_correct, next_review_time
		$this->answerPool = $this->getAnswerPool();

		if($this->answerPool->count() >= self::NUM_CONCEPTS) {
			return $this->answerPool->random(self::NUM_CONCEPTS);
		} else {
			return $this->answerPool;
		}
	}

	protected function getAnswerPool()
	{
		if($this->answerPool) {
			return $this->answerPool;
		} else {
			$pastSessions = $this->user->sessions()->with('flashcards')->get();
			$deckFlashcards = $this->deck->flashcards;
			$sessionFlashcards = collect([]);
			
			foreach($pastSessions as $session) {
				$sessionFlashcards = $sessionFlashcards->merge(
					$session->flashcards()->where('correct', 1)->get()
				);
			}

			//for each deck, we want this information: last_review_time, num_correct, next_review_time
			return $sessionFlashcards->intersect($deckFlashcards);			
		}
	}
}