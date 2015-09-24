<?php
/**
 * Calculates the stats from a session.
 */
namespace App\Stats;

use DB;

class SessionStatsCalculator
{
	/**
	 * The session.
	 */
	private $session;

	public function __construct(\App\Session $session)
	{
		$this->session = $session;
	}

	/**
	 * Calculate the total time the user has spent this session.
	 * @return int
	 */
	public function totalTime()
	{
		return (int) $this->session->time_spent;
	}

	/**
	 * Calculate the total number of cards the user has interacted with (learning + reviewing)
	 * @return int
	 */
	public function totalInteractions()
	{
		$interactions = (int) DB::table('flashcardables')->where('flashcardable_type', 'App\Session')
								   						 ->where('flashcardable_id', $this->session->id)
								   						 ->count();
		return $interactions;		
	}

	/**
	 * Calculate the accuracy of the user in this session.
	 * @return float in [0, 1]
	 */
	public function accuracy()
	{
		if($this->session->num_correct + $this->session->num_incorrect == 0)
			return 1;
		else
			return $this->session->num_correct / ($this->session->num_correct + $this->session->num_incorrect);
	}
}