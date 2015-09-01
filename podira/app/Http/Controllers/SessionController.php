<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.deck.view');
    }

    public function startSession(Request $request, $id)
    {
        $session = new \App\Session();
        $user = $request->user();
        $deck = \App\Deck::find($id);
        $user->sessions()->save($session);
        $session->deck()->save($deck);
        
        return view('session.generic')->with([
            'session' => $session,
            'user_sessions' => $user->sessions,
            'deck_sessions' => $deck->sessions
        ]);
    }
}
