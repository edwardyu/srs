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
	 * @param $num - number of concepts to return 
	 * @return ['flashcard_id' => average_recall_score] 
	 */
	public function mostDifficultConcepts($num = self::NUM_CONCEPTS)
	{
		$scores = $this->calcRecallScores();
		return array_slice($scores, 0, $num, True);
	}

	/**
	 * Get the most intuitive concepts in the deck, based on recall score.
	 * @param $num - number of concepts to return 
	 * @return ['flashcard_id' => average_recall_score] 
	 */	
	public function mostIntuitiveConcepts($num = self::NUM_CONCEPTS)
	{
		$scores = $this->calcRecallScores();
		arsort($scores);
		$neededScores = array_slice($scores, 0, $num, True);
		asort($scores);
		return $neededScores;
	}
	
	/**
	 * Get all concepts, sorted by recall score from low to high.
	 * @param $force - if set to true, it will recalculate all scores instead of returning the cached version.
	 * @return ['flashcard_id' => average_recall_score]
	 */
	public function calcRecallScores($force = False)
	{
		if(isset($this->recallScores) && !$force) {
			return $this->recallScores;
		}

		/**
		 * [
		 * 		$flashcardId => [
		 *				'sum_scores' => $sum,
		 *				'num_scores' => $num
		 *			 ]
		 * ]
		 */
		$aggregateScores = [];

		foreach($this->deck->users as $user)
		{
			$userCalculator = new UserStatsCalculator($user);
			$scores = $userCalculator->calcRecallScores();

			foreach($scores as $flashcardId => $recallScore)
			{
				if($this->inDeck($flashcardId)) {
					if(array_key_exists($flashcardId, $aggregateScores)) {
						$aggregateScores[$flashcardId]['sum_scores'] += $recallScore;
						$aggregateScores[$flashcardId]['sum_scores'] += 1;						
					} else {
						$aggregateScores[$flashcardId] = ['sum_scores' => $recallScore, 'num_scores' => 1];						
					}
				}
			}
		}

		$averageScores = [];

		foreach($aggregateScores as $flashcardId => $info) {
			$averageScores[$flashcardId] = $info['sum_scores'] / $info['num_scores'];
		}

		asort($averageScores);
		$this->recallScores = $averageScores;
		return $averageScores;
	}

	/**
	 * Test if a card is in the deck.
	 * @param $flashcardId
	 * @return bool
	 */
	private function inDeck($flashcardId)
	{
		if(!isset($this->flashcardIds))
			$this->calcFlashcardIds();

		return $this->flashcardIds->contains($flashcardId);
	}

	/**
	 * Get all flashcard ids in the deck and put them in a collection
	 */
	private function calcFlashcardIds()
	{
		$this->flashcardIds = $this->deck->flashcards->each(function($item) {
			return $item->id;
		});
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

	/**
	 * Accuracy of the users learning the deck.
	 * @return float in [0, 1]
	 */
	public function accuracy()
	{
		$correct = 0;
		$incorrect = 0;

		foreach($this->deck->sessions as $session)
		{
			$correct += (int) DB::table('flashcardables')->where('flashcardable_type', 'App\Session')
									   						 ->where('flashcardable_id', $session->id)
									   						 ->sum('num_correct');
			$incorrect += (int) DB::table('flashcardables')->where('flashcardable_type', 'App\Session')
									   						 ->where('flashcardable_id', $session->id)
									   						 ->sum('num_incorrect');			
		}

		if($incorrect == 0)
			return 1;
		else
			return $correct / $incorrect;		
	}

}