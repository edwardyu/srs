<?php

namespace App\Http\Middleware;

use Closure;

class DeckAddUser
{
    const USER_LIMIT = 1;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return response('Unauthorized.', 401); 
        if(!$request->user() || !$request->id) {
            return response('Unauthorized.', 401); 
        }

        if(!$this->canAdd($request->user(), $request->id)) {
            return response('You have reached the user limit.', 401);
        }

        return $next($request);
    }

    private function canAdd(\App\User $user, $request)
    {
        if(\App\Subscription::isSubscribed($user)) {
            return true;
        }
        else {
            $deck = \App\Deck::find($request->id);
            if($deck->users->count >= DeckAddUser::USER_LIMIT)
                return false;
            else
                return true;
        }
    }
}
