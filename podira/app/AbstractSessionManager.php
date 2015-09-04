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
	 * The last Flashcard that the user saw.
	 */
	protected $lastFlashcard;

	/**
	 * The next Flashcard that the user will see.
	 */
	protected $nextFlashcard;

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
		$this->lastFlashcard = Null;
	}
	
	abstract public function start();

	public function next($answer)
	{
		if($this->count >= self::NUM_CONCEPTS) {
			return Null;
		}

		if(!$this->usableFlashcards || !$this->usableFlashcards->count()) {
			return Null;
		}

		$this->nextFlashcard = $this->usableFlashcards->random();
		//make sure flashcardPool doesn't contain the current flashcard. 
		$flashcardPool = $this->originalFlashcards->reject(function($flashcard) {
			return $flashcard == $this->lastFlashcard;
		});

		if($this->checkAnswer($answer)) {
			$qa = new \App\QuestionAnswer($this->nextFlashcard);
			$qa->setChoices($flashcardPool);
			$this->lastFlashcard = $this->nextFlashcard;
			return $qa;
		} else {
			$missedFlashcard = $this->lastFlashcard;
			$this->lastFlashcard = $this->nextFlashcard;
			return $missedFlashcard;			
		}
	}

	/**
	 * Helper function to check an answer. Side effect: stores the answer in the database.
	 * @param $answer - the answer to check
	 */
	private function checkAnswer($answer)
	{
		if($answer == $this->lastFlashcard) {
			return True;
		}

		$correct = (int) $answer == $this->lastFlashcard->back;
		$this->lastFlashcard->sessions()->save($this->session, ['interaction' => $this->type . 'ed', 'correct' => $correct]);

		if($correct) {
			//remove card from usuable ones.
			$this->usableFlashcards = $this->usableFlashcards->reject(function($flashcard) {
				return $flashcard == $this->lastFlashcard;
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