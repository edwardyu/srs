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

    }
}
