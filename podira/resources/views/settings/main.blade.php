@extends('layouts.master')
@section('title', 'Your Current Decks')
@section('content')

<section name="main" class="lightmain" style="height:auto;">

	<section name="page" class="bgmatte">
		<h1>Your Current Plan: <i>Basic</i></h1>
		<div class="paymentmoduli">
			<div class="paymentmodulo" >
				<h1>Basic</h1>
				<li><i class="fa fa-check-circle-o"></i> Unlimited Personal Flashcard Decks</li>
				<li><i class="fa fa-check-circle-o"></i> Can Join Shared Decks with Invite</li>
				<li><i class="fa fa-check-circle-o"></i> Can Generate Basic Flashcards</li>

				<div class="price">FREE</div>
				<a class="mainbutton matte"> Current Plan </a>
			</div>

			<div class="paymentmodulo emphasis bgpurple">
				<h1>Dictionary-Level</h1>
				<li><i class="fa fa-check-circle-o"></i> Unlimited Personal Flashcard Decks</li>
				<li><i class="fa fa-check-circle-o"></i> Can Join Shared Decks with Invite</li>
				<li><i class="fa fa-check-circle-o"></i> Can Generate Basic Flashcards</li>
				<li><i class="fa fa-check-circle-o"></i> Can Generate Advanced Flashcards</li>
				<li><i class="fa fa-check-circle-o"></i> Invite Up to 100 Students</li>
				<li><i class="fa fa-check-circle-o"></i> Up to 10 Shared Decks</li>


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

	</section>

</section>

@endsection
