<?php
/**
 * Manages a session intented to learn new material.
 */
namespace App;

use DB;

class LearningSessionManager extends AbstractSessionManager
{	
	protected function getSessionFlashcards()
	{
		$this->getAnswerPool();

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
		}

		//load all flashcards that we can't use, because the user has already learned it. 
		$pastSessions = $this->user->sessions()->where('type', 'learn')->with('flashcards')->get();
		$this->unusable = collect();

		foreach($pastSessions as $session) {
			$learned = $session->flashcards()
						->where('interaction', 'learned')
						->where('correct', 1)
						->get();

			$this->unusable = $this->unusable->merge($learned);	
		}

		//remove from deck
		$this->answerPool = $this->deck->flashcards->diff($this->unusable);
		return $this->answerPool;
	}
}