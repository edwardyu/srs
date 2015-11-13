<?php
/**
 * Class for calculating all user related stats.
 */
namespace App\Stats;

use DB;

class UserStatsCalculator
{
	/**
	 * The user to calculate stats for. 
	 */
	private $user;

	const SECONDS_PER_DAY = 86400;

	public function __construct(\App\User $user)
	{
		$this->user = $user;
	}

	/**
	 * Calculate the recall score for each card. Also stores the results in the database.
	 * @return an associative array with flashcard_id as the key and score as the value. 
	 * ['flashcard_id' => score]
	 * Scores will be sorted from low to high.
	 */
	public function calcRecallScores()
	{
		$scores = [];

		foreach($this->user->flashcards as $flashcard)
		{
			$accuracy = $flashcard->pivot->num_correct / ($flashcard->pivot->num_correct + $flashcard->pivot->num_incorrect);
			$correctMultiplier = 2 * pow(2, $flashcard->pivot->num_correct);
			$secondsSinceLastReview = time() - \Carbon\Carbon::parse($flashcard->pivot->last_review_time)->timestamp;
			$decay = exp(-$secondsSinceLastReview / (self::SECONDS_PER_DAY * $correctMultiplier));
			$recallScore = $accuracy*.3 + .7*$decay;
			$recallScore *= 100;
			$scores[strval($flashcard->id)] = $recallScore;
			$this->user->flashcards()->where('flashcard_id', $flashcard->id)
									 ->where('flashcardable_id', $this->user->id)
									 ->update(['recall_score' => round($recallScore, 3)]);
		}

		asort($scores);
		return $scores;
	}

	/**
	 * Calculate the total time the user has spent on sessions.
	 * @return int
	 */
	public function totalTime()
	{
		return intval($this->user->sessions()->sum('time_spent'));
	}

	/**
	 * Calculate the total number of cards the user has interacted with (learning + reviewing)
	 * @return int
	 */
	public function totalInteractions()
	{
		$total = 0;

		foreach($this->user->sessions as $session)
		{
			$interactions = (int) DB::table('flashcardables')->where('flashcardable_type', 'App\Session')
									   						 ->where('flashcardable_id', $session->id)
									   						 ->count();
			$total += $interactions;
		}

		return $total;
	}

	/**
	 * Calculate the accuracy of the user.
	 * @return float in [0, 1]
	 */
	public function accuracy()
	{
		$correct = intval($this->user->sessions()->sum('num_correct'));
		$incorrect = intval($this->user->sessions()->sum('num_incorrect'));

		if($incorrect + $correct == 0)
			return 1;
		else
			return $correct / ($incorrect + $correct);		
	}
}