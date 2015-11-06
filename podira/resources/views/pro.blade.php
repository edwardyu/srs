@extends('layouts.master')
@section('title', 'Your Current Decks')
@section('content')
<!DOCTYPE html>
<html>
<head>
	<title>Subscribe</title>
</head>
<body>




	<section name="main" class="lightmain" style="height:auto;">

		<section name="page" class="">
			<h1 class="matte" style='font-size:19px;'>What Are Our Plans?</h1>
			<div class="paymentmoduli">
				<div class="paymentmodulo bgmatte" >
					<h1>Basic</h1>
					<li><i class="fa fa-check-circle-o"></i> Unlimited Personal Flashcard Decks</li>
					<li><i class="fa fa-check-circle-o"></i> Can Join Shared Decks with Invite</li>
					<li><i class="fa fa-check-circle-o"></i> Can Generate Flashcards</li>
					<li><i class="fa fa-times-circle-o"></i> Cannot Add Other Users to Deck</li>

					<div class="price">FREE</div>
					@if(!empty($user))
						@if(($user -> stripe_active) == 0)
							<a class="mainbutton" style="background-color:transparent;padding-top:">Current Plan</a>
						@endif
					@endif
				</div>
	
				<div class="paymentmodulo  bgpurple" style="margin-left:20px;">
					<h1>Pro-Level</h1>
					<li><i class="fa fa-check-circle-o"></i> Unlimited Personal Flashcard Decks</li>
					<li><i class="fa fa-check-circle-o"></i> Can Join Shared Decks with Invite</li>
					<li><i class="fa fa-check-circle-o"></i> Can Generate Flashcards</li>
					<li><i class="fa fa-check-circle-o"></i> Unlimited Added Users</li>
					<li><i class="fa fa-check-circle-o"></i> 30 Day Trial Included</li>

					<div class="price">$9.99/month</div>

					@if(!empty($user))
						@if(($user -> stripe_active) == 0)
					<a class="mainbutton" style="background-color:transparent;">
						<form action="/createSubscription" method="POST">
							<script
								src="https://checkout.stripe.com/checkout.js" class="stripe-button"
								data-key="pk_live_F8wemN8o8LEAPftGPw2mCqFq"
								data-amount="999"
								data-name="Podira"
								data-description="Signing Up for Pro"
								data-locale="auto"
								data-label="Upgrade Today"
								data-image="/assets/images/Podira_square.png"
								>
							</script>
						</form>
					</a>
						@else
						<a class="mainbutton" style="background-color:transparent;width:80%;left:10%;">

							Current Plan<br>
							<span style="font-size:11px;">If you wish to cancel, please email us at team@podira.com.</span>
						</a>
						@endif
					@endif


				</div>

				<!--<div class="paymentmodulo bgpink" >
					<h1>Encyclopedia-Level</h1>
					<li><i class="fa fa-check-circle-o"></i> Unlimited Personal Flashcard Decks</li>
					<li><i class="fa fa-check-circle-o"></i> Can Join Shared Decks with Invite</li>
					<li><i class="fa fa-check-circle-o"></i> Can Generate Basic Flashcards</li>
					<li><i class="fa fa-check-circle-o"></i> Can Generate Advanced Flashcards</li>
					<li><i class="fa fa-check-circle-o"></i> Unlimited Students</li>
					<li><i class="fa fa-check-circle-o"></i> Unlimited Shared Decks</li>

					<div class="price">$96.00/month</div>

					<a class="mainbutton pink"> Choose </a>

				</div>-->


			</div>
			<!--
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
		-->

		</section>


	</section>
	@if(!empty($congrats))
	<div class="congrats">
		<h1>Congrats!  You've Been Upgraded to Pro!</h1>
	</div>
	@endif



</body>
</html>
@endsection
