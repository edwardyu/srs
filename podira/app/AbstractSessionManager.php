<?php
/**
 * Manages a general session.
 */
namespace App;

use DB;

abstract class AbstractSessionManager implements SessionManagerInterface
{
	/**
	 * How many cards are in one session.
	 */
	const NUM_CONCEPTS = 10;

	/**
	 * A session
	 * @var App\Session
	 */
	protected $session;

	/**
	 * The time that the session was started, in unix time (milliseconds)
	 */
	protected $startTime;

	/**
	 * The cards that are acceptable to learn.
	 */
	protected $usableFlashcards;

	/**
	 * The cards that were originally picked out as usable. This collection does not diminish as the session progresses, so it is useful for 
	 * generating random answers.
	 */
	protected $originalFlashcards;

	/**
	 * The current flashcard that the user is interacting with.
	 */
	protected $currentFlashcard;

	/**
	 * How many correct answers the user has.
	 */
	protected $count;

	/**
	 * Type of session. Either 'learn' or 'review'
	 */
	private $type;

	public function __construct(\App\User $user, \App\Deck $deck, $type)
	{
		$this->user = $user;
		$this->deck = $deck;
		$this->count = 0;
		$this->type = $type;
	}
	
	abstract public function start();

	public function next()
	{
		if($this->count >= self::NUM_CONCEPTS) {
			return Null;
		}

		if(!$this->usableFlashcards->count()) {
			return Null;
		}

		$this->currentFlashcard = $this->usableFlashcards->random();

		$this->originalFlashcards = $this->originalFlashcards->reject(function($flashcard) {
			return $flashcard == $this->currentFlashcard;
		});

		$question = $this->currentFlashcard->front;
		$correctAnswer = $this->currentFlashcard->back;

		if($this->originalFlashcards->count() >= 3) {
			$randomAnswers = $this->originalFlashcards->random(3);
		} else if(!$this->originalFlashcards->count()) {
			return Null;
		} else {
			$randomAnswers = $this->originalFlashcards;
		}

		$randomAnswers = $randomAnswers->map(function($flashcard) {
			return $flashcard->back;
		})->toArray();

		$randomAnswers[] = $correctAnswer;
		shuffle($randomAnswers);

		$this->originalFlashcards->push($this->currentFlashcard);

		return [$question, $randomAnswers];
	}

	public function checkAnswer($answer)
	{
		$correct = (int) $answer == $this->currentFlashcard->back;
		$this->currentFlashcard->sessions()->save($this->session, ['interaction' => $this->type . 'ed', 'correct' => $correct]);

		if($correct) {
			//remove card from usuable ones.
			$this->usableFlashcards = $this->usableFlashcards->reject(function($flashcard) {
				return $flashcard == $this->currentFlashcard;
			});

			$this->count++;
		}

		return $correct;
	}

	public function end()
	{
		$timeSpent = microtime() - $this->startTime;
		$this->session->update(['time_spent' => $timeSpent]);
	}
}