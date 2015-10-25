<?php
namespace App;

class Subscription
{
	public static function create($stripeToken, \App\User $user)
	{
		$user->subscription('monthly')->create($creditCardToken);
	}
}