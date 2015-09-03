<?php
/**
 * Manages a session intented to learn new material.
 */
namespace App;

use DB;

class LearningSessionManager extends AbstractSessionManager
{	
	public function start()
	{
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
		$this->usableFlashcards = $this->deck->flashcards->diff($this->unusable);
		$this->originalFlashcards = $this->usableFlashcards = $this->usableFlashcards->unique();

		$this->session = new \App\Session(['type' => 'learn']);
        $this->user->sessions()->save($this->session);
        $this->session->deck()->save($this->deck);		
		$this->startTime = microtime();
	}
}