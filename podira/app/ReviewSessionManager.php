<?php
/**
 * Manages a session intented to review material.
 */
namespace App;

use DB;
use App\Stats\UserStatsCalculator as UserStatsCalculator;

class ReviewSessionManager extends AbstractSessionManager
{
	protected function getSessionFlashcards()
	{
		//get 10 most struggleed with words by recall score
		$calculator = new UserStatsCalculator($this->user);
		$scores = $calculator->calcRecallScores();
		$usable = collect();
		foreach ($scores as $flashcard_id => $score) {
			if($usable->count() >= self::NUM_CONCEPTS)
				break;

			$this->deck->flashcards->each(function($item) use (&$usable, $flashcard_id) {
				if($item->id == $flashcard_id) {
					$usable->push($item);
					return False;
				}
			});
		}

		return $usable;
	}

	public function getTotalFlashcards()
	{
		$arr = array();
		for($i = 0; $i < $this->getSessionFlashcards()->count(); $i++){
			$arr[] = $i + 1;
		}
		return $arr;
	}

}
