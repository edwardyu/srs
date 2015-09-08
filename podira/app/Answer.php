<?php
/**
 * A class used to represent an answer. We need a full blown class for this because not all answers are created equal. An answer from a 
 * multiple choice question is different than one from a card after the user has just missed a question.
 * In the future, different answers can also be weighted differently.
 */
 namespace App;

 class Answer
 {
 	const CARD = 'card';
 	const MC = 'multiple-choice';
 	private $answer;
 	private $fromWhence;

 	/**
 	 * Construct an Answer object.
 	 * @param $answer - the string containing an answer.
 	 * @param $fromWhence - what type of answer this is. Can be 'card' or 'multiple-choice' currently.
 	 */
 	public function __construct($answer, $fromWhence)
 	{
 		$this->answer = $answer;
 		if($fromWhence != self::CARD && $fromWhence != self::MC) {
 			throw new \InvalidArgumentException('$fromWhence must be card or multiple-choice');
 		} else {
 			$this->fromWhence = $fromWhence;
 		}
 	}

 	public function getAnswer()
 	{
 		return $this->answer;
 	}

 	public function getFromWhence()
 	{
 		return $this->fromWhence;
 	}
 } 