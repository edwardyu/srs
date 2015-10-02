<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class MainController extends Controller
{
	public function mainPage(Request $request)
	{
		if(!Auth::check()) {
			return view('welcome');
		}
		else {
			/**
			 * ['$deck_id' => ['toLearn' => int, 'toReview' => int]]
			 */
			$numToLearnAndReview = [];
			$user = Auth::user();

			foreach($user->decks as $deck) {
				$calculator = new \App\Stats\UserDeckStatsCalculator($user, $deck);
				$numToLearnAndReview[(string) $deck->id] = ['toLearn' => $calculator->numToLearn(), 'toReview' => $calculator->numToReview()];
			}
			
			return view('deck.create')->with(['user' => $user, 'numbers' => $numToLearnAndReview]);
		}
	}

	public function subscribe(Request $request)
	{
		return view('subscribe');
	}

	public function createSubscription(Request $request)
	{
		return $request;
	}
}
