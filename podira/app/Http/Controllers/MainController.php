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

	public function pro(Request $request)
	{

		if(!Auth::check()) {
			return view('pro');
		} else {
			$user = Auth::user();
			return view('pro')->with(['user' => $user]);
		}
	}

	public function createSubscription(Request $request)
	{
		\App\Subscription::create($request->stripeToken, Auth::user());
		return view('pro')->with(['user' => $request->user, 'congrats' => true]);
	}

	public function globalDecks(Request $request)
	{
		$decks = \App\Deck::all();
		return $decks;
	}
}
