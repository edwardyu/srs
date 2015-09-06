<?php
/**
 * Class for calculating aggregate stats for a deck.
 */
namespace App\Stats;

use DB;

class DeckStatsCalculator
{
	private $deck;

	/**
	 * How many flashcards to return for most difficult and most intuitive.
	 */
	const NUM_CONCEPTS = 5;

	/**
	 * Construct the object.
	 * @param $deck - the deck the stats are calculated on.
	 */
	public function __construct(\App\Deck $deck)
	{
		$this->deck = $deck;
	}

	/**
	 * Get the most difficult concepts in the deck, based on recall score.
	 * @return collection of [Flashcard, recallScore] pairs. 
	 */
	public function mostDifficultConcepts()
	{

	}

	/**
	 * Get the most intuitive concepts in the deck, based on recall score.
	 * @return collection of [Flashcard, recallScore] pairs. 
	 */	
	public function mostIntuitiveConcepts()
	{

	}
	
	/**
	 * Get all concepts, sorted by recall score.
	 * @return ['flashcard_id' => average_recall_score]
	 */
	private function getRecallScores()
	{

	}

	/**
	 * How many interactions users have had with cards. Review and learn count as 1 each.
	 * @return int representing total interactions.
	 */
	public function totalInteractions()
	{
		$total = 0;

		foreach($this->deck->sessions as $session)
		{
			$interactions = (int) DB::table('flashcardables')->where('flashcardable_type', 'App\Session')
									   						 ->where('flashcardable_id', $session->id)
									   						 ->count();
			$total += $interactions;
		}

		return $total;
	}

	/**
	 * Total time spent by users learning or reviewing this deck.
	 * @return time in seconds
	 */
	public function totalTime()
	{
		return intval($this->deck->sessions()->sum('time_spent'));
	}

	/**
	 * Total number of users who have access to this deck.
	 * @return int number of users.
	 */
	public function numUsers()
	{
		return intval($this->deck->users->count());
	}
}