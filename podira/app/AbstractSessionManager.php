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
	 * The cards that are left to interact with.
	 */
	protected $remainingFlashcards;

	/**
	 * Cards that have already been interacted with.
	 */
	protected $interactedFlashcards;

	/**
	 * The cards that can be used to generate answer choices. This collection does not diminish as the session progresses, so it is useful for 
	 * generating random answers.
	 */
	protected $answerPool;

	/**
	 * The last Flashcard that the user saw.
	 */
	protected $lastFlashcard;

	/**
	 * The next Flashcard that the user will see.
	 */
	protected $nextFlashcard;

	/**
	 * Type of session. Either 'learn' or 'review'
	 */
	protected $type;

	/**
	 * How many times next() has been called.
	 */
	protected $count;

	public function __construct(\App\User $user, \App\Deck $deck, $type)
	{
		$this->user = $user;
		$this->deck = $deck;
		$this->count = 0;
		$this->type = $type;
		$this->lastFlashcard = Null;
		$this->answerPool = Null;
		$this->interactedFlashcards = collect();
	}
	
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
		return $qa;
	}

	abstract protected function getSessionFlashcards();
	abstract protected function getAnswerPool();

	public function next(\App\Answer $answer)
	{
		$this->nextFlashcard = $this->remainingFlashcards->random();

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

	/**
	 * Helper function to check an answer. Side effect: stores the answer in the database.
	 * @param $answer - the answer to check
	 */
	protected function checkAnswer(\App\Answer $answer)
	{
		$correct = (int) ($answer->getAnswer() == $this->lastFlashcard->back);
		$this->lastFlashcard->sessions()->save($this->session, ['interaction' => $this->type . 'ed', 'correct' => $correct]);

		if($correct && $answer->getFromWhence() == \App\Answer::MC) {
			//remove card from usuable ones.
			$this->remainingFlashcards = $this->remainingFlashcards->reject(function($flashcard) {
				return $flashcard->id == $this->lastFlashcard->id;
			});
			//add card to interacted
			$this->interactedFlashcards->push($this->lastFlashcard);
		}

		return $correct;
	}

	public function end()
	{
		$timeSpent = time() - $this->startTime;
		$this->session->update(['time_spent' => $timeSpent]);
	}
}