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

        try {
            $info = $sessionManager->start();
        } catch(\InvalidArgumentException $e) {
          return view('errors.fourcards');
        }


        if(!$info) {
            $sessionManager->end();
            return view('session.neverbegan') -> with(['deck' => $deck,'type' => $type]);
        }

        Session::put('sessionManager', $sessionManager);

        if($info instanceof \App\QuestionAnswer) {
            Session::put('fromWhence', 'multiple-choice');
            return view('session.' . $type)->with([
                'type' => $type,
                'deck' => $deck,
                'question' => $info->getQuestion(),
                'answers' => $info->getChoices()
            ]);
        } else if($info instanceof \App\Flashcard) {
            Session::put('fromWhence', 'card');
            return view('session.card')->with([
                'card' => $info,
                'type' => $type,
                'deck' => $deck
            ]);
        }
    }

    public function next(Request $request, $id, $type)
    {
        if(!$this->isValidSessionType($type)) {
            return response('Not found.', 404);
        }

        $sessionManager = Session::get('sessionManager');
        $user = $request->user();
        $deck = \App\Deck::find($id);
        $fromWhence = Session::get('fromWhence');
        $answer = new \App\Answer($request->answer, $fromWhence);

        if ($info = $sessionManager->next($answer)) {
            if($info instanceof \App\QuestionAnswer) {
                Session::put('fromWhence', 'multiple-choice');
                return view('session.' . $type)->with([
                    'type' => $type,
                    'deck' => $deck,
                    'question' => $info->getQuestion(),
                    'answers' => $info->getChoices()
                ]);
            } else if($info instanceof \App\Flashcard) {
                Session::put('fromWhence', 'card');
                return view('session.card')->with([
                    'card' => $info,
                    'type' => $type,
                    'deck' => $deck
                ]);
            }

        } else {
            $sessionManager->end();
            return view('session.complete') -> with(['deck' => $deck]);
        }
    }

    private function isValidSessionType($type) {
        return ($type == 'learn' || $type == 'review');
    }
}
