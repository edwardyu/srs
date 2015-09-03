<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.deck.view');
    }

    public function startSession(Request $request, $id, $type)
    {
        $user = $request->user();
        $deck = \App\Deck::find($id);
        
        if($type == 'learn') {
            $sessionManager = new \App\LearningSessionManager($user, $deck, $type);
        } else if($type == 'review') {
            $sessionManager = new \App\ReviewSessionManager($user, $deck, $type);
        } else {
            return response('Not found.', 404);
        }

        $sessionManager->start();
        if ($info = $sessionManager->next()) {
            Session::put('sessionManager', $sessionManager);
            return view('session.' . $type)->with([
                'type' => $type,
                'deck' => $deck,
                'question' => $info[0],
                'answers' => $info[1],
                'sessionManager' => $sessionManager
            ]);                
        } else {
            $sessionManager->end();
            return 'You have completed this session!';
        }         
    }

    public function next(Request $request, $id, $type)
    {
        if(!$this->isValidSessionType($type)) {
            return response('Not found.', 404);
        }

        $sessionManager = Session::get('sessionManager');
        $correct = $sessionManager->checkAnswer($request->answer);

        if(!$correct) {
            return 'You got the answer wrong.';
        }

        $user = $request->user();
        $deck = \App\Deck::find($id);

        if ($info = $sessionManager->next()) {
            return view('session.' . $type)->with([
                'type' => $type,
                'deck' => $deck,
                'question' => $info[0],
                'answers' => $info[1]
            ]);                
        } else {
            $sessionManager->end();
            return 'You have completed this session!';
        }        
    }

    private function isValidSessionType($type) {
        return ($type == 'learn' || $type == 'review');
    }
}
