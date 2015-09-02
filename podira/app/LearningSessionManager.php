<?php
/**
 * Manages a session intented to learn new material.
 */
namespace App;

use DB;

class LearningSessionManager implements SessionManagerInterface
{
	const CONCEPTS_TO_LEARN = 10;

	private $session;
	private $startTime;
	private $usableFlashcards;
	private $currentFlashcard;
	private $count;

	public function __construct(\App\User $user, \App\Deck $deck)
	{
		$this->user = $user;
		$this->deck = $deck;
		$this->count = 0;
	}
	
	public function start()
	{
		//load all flashcards that we can't use, because the user has already learned it. 
		$pastSessions = $this->user->sessions()->where('type', 'learn')->with('flashcards')->get();
		$this->unusable = collect([]);

		foreach($pastSessions as $session) {
			$this->unusable->merge(
				$session->flashcards()
						->where('interaction', 'learned')
						->where('correct', 1)
						->get()
			);
		}

		//remove from deck
		$this->usableFlashcards = $this->deck->flashcards->reject(function($flashcard) {
			return $this->unusable->contains($flashcard);
		});

		$this->session = new \App\Session(['type' => 'learn']);
        $this->user->sessions()->save($this->session);
        $this->session->deck()->save($this->deck);		
		$this->startTime = microtime();
	}

	public function next()
	{
		if($this->count >= self::CONCEPTS_TO_LEARN) {
			return Null;
		}

		$randomFour = $this->usableFlashcards->random(4);
		$this->currentFlashcard = $randomFour->random();
		$question = $this->currentFlashcard->front;
		$answers = $randomFour->map(function($flashcard) {
			return $flashcard->back;
		})->toArray();

		$this->count++;
		return [$question, $answers];
	}

	public function checkAnswer($answer)
	{
		$correct = (int) $answer == $this->currentFlashcard->back;
		$this->currentFlashcard->sessions()->save($this->session, ['interaction' => 'learned', 'correct' => $correct]);

		if($correct) {
			//remove card from usuable ones.
			$this->usableFlashcards->pull($this->currentFlashcard->id);
		}

		return $correct;
	}

	public function end()
	{
		$timeSpent = microtime() - $this->startTime;
		$this->session->update(['time_spent' => $timeSpent]);
	}
}