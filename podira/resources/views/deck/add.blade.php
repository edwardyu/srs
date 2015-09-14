@extends('layouts.master')
@section('title', $deck -> name)
@section('content')

<script>
$(document).ready(function(){


	$('.minichooser a').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('.minichooser a').removeClass('chooseractive');
		$('.datanone').removeClass('displayit');

		$(this).addClass('chooseractive');
		$("."+tab_id).addClass('displayit');
	})

})
</script>

<section name="main" class="bgmatte full" style="height:auto;">
		<h1>{{$deck -> name}}</h1>

		<div class="minichooser">
			<a class="chooser chooseractive" data-tab="data3">List Deck</a>
			<a class="chooser" data-tab="data2">Add Users</a>
			<a class="chooser" data-tab="data1">Add Cards</a>
		</div>

		<form class="deck datanone data1" method="POST" action="/deck/{{$id}}/storeCard">
			{!! csrf_field() !!}
			 <fieldset>Info</fieldset>
				<input placeholder="Front" name="front">
				<input placeholder="Back" name="back">

				<!--<input placeholder="Short Tagline" name="tagline">
				<fieldset>Class</fieldset>
				<select>
						<option>Arabic History</option>
						<option>AP World History</option>
				</select>
				<select>
						<option>All Sections</option>
						<option>1st Period</option>
						<option>2nd Period</option>
						<option>6th Period</option>
				</select>-->
				<input type="submit" value="Add Card">
		</form>


		<form class="deck datanone data2" method="POST" action="/deck/{{$id}}/storeUser" id="data2">
			{!! csrf_field() !!}
			 <fieldset>Info</fieldset>
				<input placeholder="User ID" name="user_id">

				<!--<input placeholder="Short Tagline" name="tagline">
				<fieldset>Class</fieldset>
				<select>
						<option>Arabic History</option>
						<option>AP World History</option>
				</select>
				<select>
						<option>All Sections</option>
						<option>1st Period</option>
						<option>2nd Period</option>
						<option>6th Period</option>
				</select>-->
				<input type="submit" value="Add User">
		</form>


				<div style="width:80%;margin-left:10%;text-align:center;" class="datanone data3 displayit">
					@if ($deck->flashcards->isEmpty())
						<br><br><br><br><br>
						You have no current cards in this deck.
					@else
							@foreach($deck->flashcards as $card)
							<div class="card sidebyside bgbaige" style="-webkit-animation-duration:0s;">
							<div class="innercard">
									<div class="emblem">
											<div class="inneremblem">
													<img src="{!! URL::asset('assets/images/podira_watermark.png') !!}">
											</div>

									</div>
									<h1>{{$card -> front}}</h1>
									<br>
									<h1>
											Answer: <i>{{$card -> back}}</i>
									</h1>

									<a class="skip" style="right:45px;"  href="/deck/{{$deck->id}}/deleteCard">Delete</a><a class="enter" href="/deck/{{$deck->id}}/editCard">Edit Card</a>



							</div>

							</div>
							@endforeach
					@endif
				</div>



</section>
@endsection
<!--
<html>
	<head>
		<title>{{$deck->name}}</title>
	</head>
	<body>
		<h1>{{$deck->name}}</h1>
		@foreach($deck->flashcards as $card)
		<p>{{ $card }}</p>
		@endforeach
-->
<!--		<h3>Add a flashcard.</h3>
		<form method="POST" action="/deck/{{$id}}/storeCard">
		    {!! csrf_field() !!}
		    <div>
		        Front
		        <input type="text" name="front" value="{{ old('front') }}">
		    </div>

		    <div>
		        Back
		        <input type="text" name="back" value="{{ old('back') }}">
		    </div>

		    <div>
		        <button type="submit">Add</button>
		    </div>
		</form>-->
<!--
		<h3>Add an user.</h3>
		<form method="POST" action="/deck/{{$id}}/storeUser">
		    {!! csrf_field() !!}
		    <div>
		        User ID
		        <input type="text" name="user_id" value="{{ old('user_id') }}">
		    </div>

		    <div>
		        <button type="submit">Add</button>
		    </div>
		</form>
	</body>
</html>-->
