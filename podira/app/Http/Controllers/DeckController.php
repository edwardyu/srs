<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Deck as Deck;
use App\Flashcard as Flashcard;
use App\User as User;
use Auth;

class DeckController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.deck.view', ['only' => 'addCard']);
        $this->middleware('auth.deck.edit', ['only' => ['storeCard', 'storeUser', 'deleteCard', 'editCard', 'deleteDeck']]);
    }

    /**
     * Show the form for creating a new deck.
     *
     * @return Response
     */
    public function create()
    {
        return view('deck.create');
    }




    public function store(Request $request)
    {
        $deck = Deck::create([
            'name' => $request->name
        ]);

        Auth::user()->decks()->save($deck, ['permissions' => 'edit']);
        $id = $deck->id;
        return redirect()->action('DeckController@addCard', [$id]);
    }

    /**
     * Add a card to the deck.
     */
    public function addCard($id)
    {
        $deck = Deck::find($id);
        return view('deck.add')->with(['id' => $id, 'deck' => $deck]);
    }

    public function storeCard(Request $request)
    {
        $id = $request->id;
        $deck = Deck::find($id);

        if($request->front && $request->back) {
            $card = Flashcard::create([
                'front' => $request->front,
                'back' => $request->back
            ]);

            $deck->flashcards()->save($card);
        }

        return redirect()->action('DeckController@addCard', [$id]);
    }

    /**
     * Add a user to the deck.
     */
    public function storeUser(Request $request)
    {
        $id = $request->id;
        $deck = Deck::find($id);
        $user = User::where('email', $request->user_email)->first();
        try{
          if (!$user) {
              throw new \Exception('No User!');
          } else {
          $user->decks()->save($deck, ['permissions' => 'view']);
          return redirect()->action('DeckController@addCard', [$id]);
          }
        } catch (\Exception $e) {
          return json_encode(array(1));
        }
    }

    public function deleteCard(Request $request)
    {
        $flashcardId = $request->flashcard_id;
        Flashcard::destroy($flashcardId);
    }

    public function editCard(Request $request)
    {
        $flashcardId = $request->flashcard_id;
        $flashcard = Flashcard::find($flashcardId);
        $flashcard->update(['front' => $request->front, 'back' => $request->back]);
    }

    public function deleteDeck(Request $request)
    {
        Deck::destroy($request->id);
    }
}
