<?php
/**
 * Calculate stats for a specific user and deck combination.
 */
namespace App\Stats;

use DB;

class UserDeckStatsCalculator
{
	private $user;
	private $deck;
	private $deckCards;
	const REVIEW_THRESHOLD = 80;

	public function __construct(\App\User $user, \App\Deck $deck)
	{
		$this->user = $user;
		$this->deck = $deck;
		$this->deckCards = $deck->flashcards;
	}	

	/**
	 * The number of cards that need to be reviewed.
	 * @return int
	 */
	public function numToReview()
	{
		$userCalculator = new UserStatsCalculator($this->user);
		$userCalculator->calcRecallScores();
		$needToReview = $this->user->flashcards()->where('recall_score', '<=', self::REVIEW_THRESHOLD)
											     ->get();
		$numToReview = $this->deckCards->intersect($needToReview)->count();
		return $numToReview;
	}

	/**
	 * The number of cards that need to be learned.
	 * @return int
	 */
	public function numToLearn()
	{
		$learned = collect();
		foreach($this->user->sessions as $session)
		{
			$learned = $learned->merge(
				$session->flashcards()->where('interaction', 'learned')->where('correct', 1)->get()
			);
		}

		$notLearned = $this->deckCards->diff($learned);
		return $notLearned->count();
	}
}
