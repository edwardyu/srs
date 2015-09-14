<?php
/**
* Load a bunch of SAT words into the database.
*/

namespace App\Scripts;

class SATLoader
{
	private $deck;

	public function load()
	{
		$this->deck = \App\Deck::create(['name' => 'Elite SAT Vocabulary']);
		$handle = fopen(storage_path() . '/app/Elite SAT Vocabulary.txt', 'r');
		while($line = fgets($handle)) {
			$this->handleLine($line);
		}
	}

	private function handleLine($line)
	{
		$wordArray = explode("\t", $line);
		$front = $wordArray[0];
		$back = $wordArray[1];
		$flashcard = new \App\Flashcard(['front' => $front, 'back' => $back]);
		$this->deck->flashcards()->save($flashcard);
	}
}