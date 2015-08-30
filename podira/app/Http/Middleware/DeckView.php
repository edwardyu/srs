<?php

namespace App\Http\Middleware;

use Closure;

class DeckView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->user() || !$request->id) {
            return response('Unauthorized.', 401); 
        }

        if(!$this->canView($request->user(), $request->id)) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }

    /**
     * Return if a user has permission to view a deck.
     */
    private function canView($user, $id)
    {
        try {
           $permissions = $user->decks->get($id)->pivot->permissions; 
       } catch(\ErrorException $e) {
            return False;
       }
        
        if($permissions == 'view' || $permissions == 'edit')
            return True;
        else
            return False;
    }
}
