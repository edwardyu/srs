<?php
/**
 * Manages a session intented to review material.
 */
namespace App;

use DB;

class ReviewSessionManager implements SessionManagerInterface
{
	const CONCEPTS_TO_REVIEW = 10;

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

		$this->session = new \App\Session(['type' => 'review']);
        $this->user->sessions()->save($this->session);
        $this->session->deck()->save($this->deck);		
		$this->startTime = microtime();
	}

	public function next()
	{
		if($this->count >= self::CONCEPTS_TO_REVIEW) {
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
		$this->currentFlashcard->sessions()->save($this->session, ['interaction' => 'reviewed', 'correct' => $correct]);

		if($correct) {
			//remove card from usable ones.
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