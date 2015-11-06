<?php
/**
 * This interface defines how a session should be handled. Any review or learning sessions should implement this interface.
 */
namespace App;

interface SessionManagerInterface
{
	public function __construct(\App\User $user, \App\Deck $deck, $type);

	/**
	 * Start a session. Generate the necessary questions and answers, but don't load anything yet.
	 * The choice of eager loading or lazy loading is up to the implementation. 
	 */
	public function start();

	/**
	 * Return the next set of questions and answers.
	 * @param $answer - the result from the previous call
	 * @return QuestionAnswer|Flashcard|Null
	 */
	public function next(\App\Answer $answer);

	/**
	 * Store the time spent on this session in the database.
	 */
	public function end();
}