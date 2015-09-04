<?php
/**
 * Manages a session intented to learn new material.
 */
namespace App;

use DB;

class LearningSessionManager extends AbstractSessionManager
{
	/**
	 * A collection of card ids that have been shown to the user in card format (not multiple choice format)
	 */
	private $shown = [];

	public function start()
	{
		$this->remainingFlashcards = $this->getSessionFlashcards();
		$this->answerPool = $this->getAnswerPool();

		$this->session = new \App\Session(['type' => $this->type]);
        $this->user->sessions()->save($this->session);
        $this->session->deck()->save($this->deck);		
		$this->startTime = time();

		if(!$this->remainingFlashcards->count()) {
			return Null;
		}

		$this->nextFlashcard = $this->remainingFlashcards->random();	
		$qa = new \App\QuestionAnswer($this->nextFlashcard);
		$qa->setChoices($this->answerPool);
		$this->lastFlashcard = $this->nextFlashcard;
		$this->shown[] = $this->nextFlashcard->id;
		return $this->nextFlashcard;
	}

	public function next(\App\Answer $answer)
	{
		$this->nextFlashcard = $this->remainingFlashcards->random();

		if(!in_array($this->nextFlashcard->id, $this->shown)) {
			$this->shown[] = $this->nextFlashcard->id;
			$this->lastFlashcard = $this->nextFlashcard;
			return $this->nextFlashcard;
		}

		if($this->checkAnswer($answer)) {
			$qa = new \App\QuestionAnswer($this->nextFlashcard);
			$qa->setChoices($this->answerPool);
			$this->lastFlashcard = $this->nextFlashcard;

			if(!$this->remainingFlashcards->count()) 
				return Null;
			else
				return $qa;
		} else {
			$this->nextFlashcard = $this->lastFlashcard;
			return $this->nextFlashcard;			
		}
	}

	protected function getSessionFlashcards()
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
		$usable = $this->deck->flashcards->diff($this->unusable)->unique(function($flashcard) {
				return $flashcard->id;
		});

		if($usable->count() >= self::NUM_CONCEPTS) {
			return $usable->random(self::NUM_CONCEPTS);
		} else {
			return $usable;
		}		
	}

	protected function getAnswerPool()
	{
		return $this->deck->flashcards;
	}
}