@extends('layouts.master')
@section('title', 'Your Current Decks')
@section('content')

<section name="main" class="lightmain" style="height:auto;">

	<section name="page" class="bgbaige">
		<h1 class="matte">Your Current Plan: <i>Basic</i></h1>
		<div class="paymentmoduli">
			<div class="paymentmodulo bgmatte" >
				<h1>Basic</h1>
				<li><i class="fa fa-check-circle-o"></i> Unlimited Personal Flashcard Decks</li>
				<li><i class="fa fa-check-circle-o"></i> Can Join Shared Decks with Invite</li>
				<li><i class="fa fa-check-circle-o"></i> Can Generate Basic Flashcards</li>
				<li><i class="fa fa-check-circle-o"></i> Pay as You Go Shared Decks</li>

				<div class="price">FREE</div>
				<a class="mainbutton matte"> Current Plan </a>
			</div>

			<div class="paymentmodulo emphasis bgpurple">
				<h1>Dictionary-Level</h1>
				<li><i class="fa fa-check-circle-o"></i> Unlimited Personal Flashcard Decks</li>
				<li><i class="fa fa-check-circle-o"></i> Can Join Shared Decks with Invite</li>
				<li><i class="fa fa-check-circle-o"></i> Can Generate Basic Flashcards</li>
				<li><i class="fa fa-check-circle-o"></i> Can Generate Advanced Flashcards</li>
				<li><i class="fa fa-check-circle-o"></i> Invite Up to 100 Students</li>
				<li><i class="fa fa-check-circle-o"></i> Up to 10 Shared Decks</li>
				<li><i class="fa fa-check-circle-o"></i> Pay as You Go Share Decks thereafter</li>


				<div class="price">$36.00/month</div>
				<a class="mainbutton purple"> Choose </a>

			</div>

			<div class="paymentmodulo bgpink" >
				<h1>Encyclopedia-Level</h1>
				<li><i class="fa fa-check-circle-o"></i> Unlimited Personal Flashcard Decks</li>
				<li><i class="fa fa-check-circle-o"></i> Can Join Shared Decks with Invite</li>
				<li><i class="fa fa-check-circle-o"></i> Can Generate Basic Flashcards</li>
				<li><i class="fa fa-check-circle-o"></i> Can Generate Advanced Flashcards</li>
				<li><i class="fa fa-check-circle-o"></i> Unlimited Students</li>
				<li><i class="fa fa-check-circle-o"></i> Unlimited Shared Decks</li>

				<div class="price">$96.00/month</div>

				<a class="mainbutton pink"> Choose </a>

			</div>


		</div>

		<div class="subscription_container bgpurple">
			<h1>Want to Pay as You Go?  No Problem!</h1>
			<h2>Rates below on a per shared deck basis</h2>
			<div class="payblock" style="border-left:none;">
				<h1>$1.00</h1>
				<h2>/user per month</h2>
				<h3>for first 15 users</h3>
			</div>
			<div class="payblock">
				<h1>$0.75</h1>
				<h2>/user per month</h2>
				<h3>for next 100 users</h3>
			</div>
			<div class="payblock">
				<h1>$0.45</h1>
				<h2>/user per month</h2>
				<h3>for users thereafter</h3>
			</div>

		</div>


	</section>

</section>

@endsection
