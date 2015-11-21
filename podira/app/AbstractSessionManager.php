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

	/**
	 * The user that owns this session.
	 */
	protected $user;

	/**
	 * The deck that the user is interacting with.
	 */
	protected $deck;

	/**
	 * How many correct answers.
	 */
	protected $numCorrect;

	/**
	 * How many incorrect answers.
	 */
	protected $numIncorrect;

	public function __construct(\App\User $user, \App\Deck $deck, $type)
	{
		$this->user = $user;
		$this->deck = $deck;
		$this->count = 0;
		$this->type = $type;
		$this->lastFlashcard = Null;
		$this->answerPool = Null;
		$this->interactedFlashcards = collect();
		$this->numCorrect = 0;
		$this->numIncorrect = 0;
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

	protected function getAnswerPool()
	{
		return $this->deck->flashcards;
	}

	public function remainingFlashcards()
	{
		return $this->remainingFlashcards->count();
	}

	/**
	 * Returns the next item in the session.
	 * The format will be an array
	 * ['previouslyCorrect' => 0|1|null, 'next' => QuestionAnswer|Flashcard]
	 */
	public function next(\App\Answer $answer)
	{
		$answerData = $this->checkAnswer($answer);
		if($answerData['correct']) {
			if(!$this->remainingFlashcards->count())
				return Null;
			else
				$this->nextFlashcard = $this->remainingFlashcards->random();

			$qa = new \App\QuestionAnswer($this->nextFlashcard);
			$qa->setChoices($this->answerPool);
			$this->lastFlashcard = $this->nextFlashcard;
			if($answerData['fromWhence'] == \App\Answer::MC)
				return ['previouslyCorrect' => 1, 'next' => $qa];
			else
				return ['previouslyCorrect' => null, 'next' => $qa];
		} else {
			$this->nextFlashcard = $this->lastFlashcard;
			return ['previouslyCorrect' => 0, 'next' => $this->nextFlashcard];
		}
	}

	/**
	 * Helper function to check an answer. Side effect: stores the answer in the database.
	 * @param $answer - the answer to check
	 * @return ['fromWhence' => '', 'correct' => true|false]
	 */
	protected function checkAnswer(\App\Answer $answer)
	{
		if($this->lastFlashcard->cardtype == 'fill'){
			$correct = (int) (strtoupper($answer->getAnswer()) == strtoupper($this->lastFlashcard->back));
		} else {
			$correct = (int) ($answer->getAnswer() == $this->lastFlashcard->back);
		}


		$this->lastFlashcard->sessions()->save($this->session, ['interaction' => $this->type . 'ed', 'correct' => $correct]);

		if($correct && $answer->getFromWhence() == \App\Answer::MC)
		{
			//remove card from usuable ones.
			$this->remainingFlashcards = $this->remainingFlashcards->reject(function($flashcard) {
				return $flashcard->id == $this->lastFlashcard->id;
			});

			//add card to interacted
			$this->interactedFlashcards->push($this->lastFlashcard);
			$query = DB::table('flashcardables')->where('flashcardable_type', 'App\User')
												->where('flashcardable_id', $this->user->id)
												->where('flashcard_id', $this->lastFlashcard->id)
												->get();
			if(!count($query))
				$this->user->flashcards()->save($this->lastFlashcard, ['num_correct' => 1, 'last_review_time' => \Carbon\Carbon::now()]);
			else
				$this->user->flashcards()->where('flashcard_id', $this->lastFlashcard->id)->increment('num_correct');

			$this->numCorrect++;
			return ['fromWhence' => \App\Answer::MC, 'correct' => true];
		}

		else if(!$correct && $answer->getFromWhence() == \App\Answer::MC)
		{
			$query = DB::table('flashcardables')->where('flashcardable_type', 'App\User')
												->where('flashcardable_id', $this->user->id)
												->where('flashcard_id', $this->lastFlashcard->id)
												->get();

			if(!count($query))
				$this->user->flashcards()->save($this->lastFlashcard, ['num_incorrect' => 1, 'last_review_time' => \Carbon\Carbon::now()]);
			else
				$this->user->flashcards()->where('flashcard_id', $this->lastFlashcard->id)->increment('num_incorrect');

			$this->numIncorrect++;
			return ['fromWhence' => \App\Answer::MC, 'correct' => false];
		}

		else
		{
			return ['fromWhence' => 'card', 'correct' => true];
		}
	}

	public function end()
	{
		$timeSpent = time() - $this->startTime;
		$this->session->update([
			'time_spent' => $timeSpent,
			'num_correct' => $this->numCorrect,
			'num_incorrect' => $this->numIncorrect
		]);
	}

	public function getSession()
	{
		return $this->session;
	}
}
