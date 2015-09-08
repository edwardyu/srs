<?php
/**
* Load a bunch of SAT words into the database.
*/

namespace App\Scripts;

class SATLoader
{
	public function load()
	{
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
	}
}