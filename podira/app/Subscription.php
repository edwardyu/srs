<?php
namespace App;

class Subscription
{
	public static function create($stripeToken, \App\User $user)
	{
		$user->subscription('monthly')->create($creditCardToken);
	}

	public static function isSubscribed(\App\User $user)
	{
		return (bool) $user->stripe_active;
	}
}