<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class StatsController extends Controller
{
    /**
     * Set the auth middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.deck.edit', ['only' => ['deckStats']]);
    }

    /**
     * Show the statistics for the entire deck. Can only be accessed if the user has edit permissions on the deck.
     * @param Request $request - a HTTP request
     * @param $id - id of the deck.
     */
    public function deckStats(Request $request, $id)
    {
        $deck = \App\Deck::find($id);
        $deckStatsCalculator = new \App\Stats\DeckStatsCalculator($deck);
        $numUsers = $deckStatsCalculator->numUsers();
        $totalTime = $deckStatsCalculator->totalTime();
        $totalInteractions = $deckStatsCalculator->totalInteractions();
        $mostDifficultConcepts = $deckStatsCalculator->mostDifficultConcepts();
        $mostIntuitiveConcepts = $deckStatsCalculator->mostIntuitiveConcepts();
        $mostDifficultCards = $this->convertArrayKeysToFlashcards($mostDifficultConcepts);
        $mostIntuitiveCards = $this->convertArrayKeysToFlashcards($mostIntuitiveConcepts);
        $accuracy = $deckStatsCalculator->accuracy();

        return view('stats.deck')->with([
            'deck' => $deck,
            'numUsers' => $numUsers,
            'totalTime' => $totalTime,
            'totalInteractions' => $totalInteractions,
            'mostDifficultConcepts' => $mostDifficultConcepts,
            'mostIntuitiveConcepts' => $mostIntuitiveConcepts,
            'mostDifficultCards' => $mostDifficultCards,
            'mostIntuitiveCards' => $mostIntuitiveCards,
            'accuracy' => round($accuracy*100)
        ]);
    }

    /**
     * Convert the keys of an array which are flashcard ids to actual flashcard objects.
     */
    private function convertArrayKeysToFlashcards(array $array)
    {
        $flashcards = [];

        foreach($array as $key => $value)
        {
            $flashcards[] = \App\Flashcard::find((int) $key);
        }

        return $flashcards;
    }
}
