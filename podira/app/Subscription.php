<?php
namespace App;

class Subscription
{
	public static function create($stripeToken, \App\User $user)
	{
		$user->subscription('Pro')->create($stripeToken,array('plan' => 'Pro'));
	}

	public static function isSubscribed(\App\User $user)
	{
		return (bool) $user->stripe_active;
	}
}
