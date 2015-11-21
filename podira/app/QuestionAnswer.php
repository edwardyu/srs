<?php
/**
 * A class that represents a class with a question and answers.
 */
namespace App;

class QuestionAnswer
{
	private $question;
	private $answer;
	private $choices;
	private $flashcard;
	private $cardtype;

	/**
	 * Construct a QuestionAnswer object. At first the object will only have one choice for the answer, we have to provide it with a pool of
	 * flashcards to get more answer choices.
	 * @param $flashcard - A flashcard that represents the question and answer.
	 */
	public function __construct(\App\Flashcard $flashcard)
	{
		$this->flashcard = $flashcard;
		$this->question = $flashcard->front;
		$this->cardtype = $flashcard->cardtype;
		$this->answer = $flashcard->back;
		$this->choices = [$this->answer];
	}

	/**
	 * Returns whether the answer is correct or not.
	 * accounts for fill in in an non-case sensitive fashion.
	 * @return bool
	 */
	public function isCorrect($answer)
	{
		if(($this->cardtype) == 'fill'){
			return strtoupper($answer) == strtoupper($this->answer);
		} else {
			return $answer == $this->answer;
		}
	}

	/**
	 * Generate multiple choice answers.
	 * @param $flashcardPool - a Collection of Flashcards to generate random answers for.
	 * @param $numChoices - the total number of multiple choice answers that we want. The correct answer is automatically included as one.
	 * @throws InvalidArgumentException
	 */
	public function setChoices($flashcardPool, $numChoices=4)
	{
		if($flashcardPool->count() < $numChoices) {
			throw new \InvalidArgumentException("There aren't enough flashcards to generate answers for.");
		}

		//remove answer from flashcard pool
		$flashcardPool = $flashcardPool->reject(function($item) {
			return $item->id == $this->flashcard->id;
		});

		$randomAnswers = $flashcardPool->random($numChoices - 1);
		$randomAnswers = $randomAnswers->map(function($flashcard) {
			return $flashcard->back;
		})->toArray();

		$this->choices = array_merge($this->choices, $randomAnswers);
	}

	/**
	 * Get the choices needed to form a multiple choice question. The answers are randomized each time you call this function.
	 * @return array of answers
	 */
	public function getChoices()
	{
		shuffle($this->choices);
		return $this->choices;
	}

	public function getQuestion()
	{
		return $this->question;
	}

	public function getCardtype()
	{
		return $this->cardtype;
	}
}
