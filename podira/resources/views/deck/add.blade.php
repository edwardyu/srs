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

	$('.editcard').click(function(){
		var card = $(this).attr('card');
		$('.caredit' + card).addClass('displayyes');
		$('.car' + card).removeClass('displayyes');
	})

	$('.cancelcard').click(function(){
		var card = $(this).attr('card');
		$('.caredit' + card).removeClass('displayyes');
		$('.car' + card).addClass('displayyes');
	})

  $('.editcardform').submit(function(event) {

      // get the form data
      // there are many ways to get this data using jQuery (you can use the class or id also)
      var formData = $(this).serializeArray();

			console.log(formData);
      // process the form
			var base_url = window.location.protocol + "//" + window.location.host;

			$.ajaxSetup({
			   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
			});

			$.ajax({
			    type: "POST", // or GET
			    url: base_url + "/deck/{{$deck->id}}/editCard",
					dataType: 'json',
			    data: formData,
			    success: function(data){
						console.log("sucess!!");
			    }
			  });

				var card = formData[0].value;
				$('.caredit' + card).removeClass('displayyes');
				$('.car' + card).addClass('displayyes');
				$('.carquestion' + card).html(formData[1].value);
				$('.caranswer' + card).html(formData[2].value);



      // stop the form from submitting the normal way and refreshing the page
      event.preventDefault();
  });



	$('.deletecard').click(function(){
		var flashcard_id = $(this).attr('flashcardid');
		console.log(flashcard_id);

		var base_url = window.location.protocol + "//" + window.location.host;

		$.ajaxSetup({
		   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
		});

		$.ajax({
		    type: "POST", // or GET
		    url: base_url + "/deck/{{$deck->id}}/deleteCard",
		    data: "flashcard_id=" + flashcard_id,
		    success: function(data){
					$("#"+flashcard_id).removeClass('displayyes');
		    }
		  });
	})


	$('.adduser').submit(function(event) {
		var formData = $(this).serializeArray();
		console.log(formData);

		var base_url = window.location.protocol + "//" + window.location.host;

		$.ajaxSetup({
			 headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
		});

		$.ajax({
				type: "POST", // or GET
				url: base_url + "/deck/{{$id}}/storeUser",
				dataType: 'json',
				data: formData,
				success: function(res){
					console.log(res);
					if(res[0] == 1){
						console.log("failure!!");
						$(".userfail").html('That user isn\'t currently registered on Podira');
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					console.log(errorThrown);
				}
			});

			event.preventDefault();
	})

})
</script>

<section name="main" class="bgmatte" style="height:auto;">
		<h1>Edit {{$deck -> name}}</h1>

		<div class="minichooser">
			<a class="chooser chooseractive" data-tab="data1" style="width:50%;">
				<i class="fa fa-plus-square-o"></i>
	Add Cards</a>
			<a class="chooser" data-tab="data2" style="width:50%;">
				<i class="fa fa-male"> </i>
				Add Users</a>
		</div>

		<form class="deck datanone data1 displayit" style="height:170px;" method="POST" action="/deck/{{$id}}/storeCard">
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


		<form class="deck datanone data2 adduser" style="height:170px;" id="data2">
			{!! csrf_field() !!}
			 <fieldset>Info</fieldset>
				<input placeholder="User Email" name="user_email">

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
				<div class="userfail" style=""></div>

		</form>


		<div class="cardoverview">{{$deck -> name}}'s Cards</div>
				<div style="width:80%;margin-left:10%;text-align:center;" class="">
					@if ($deck->flashcards->isEmpty())
						<br><br><br><br><br><br>
						You have no current cards in this deck.
					@else
							@foreach($deck->flashcards->reverse() as $card)
							<div class="card sidebyside bgbaige displaynone displayyes" id="{{$card -> id}}" style="-webkit-animation-duration:0s;margin-top:115px;text-align:left;">
									<div class="innercard">
											<div class="emblem">
													<div class="inneremblem">
															<img src="{!! URL::asset('assets/images/podira_watermark.png') !!}">
													</div>

											</div>
											<div class="displaynone displayyes car{{$card -> id}}" style="width:100%;">
												<h1 style="width:90%;"><span class="carquestion{{$card -> id}}">{{$card -> front}}</span></h1>
												<br>
												<h1 style="width:90%;">
														Answer: <i class="caranswer{{$card -> id}}">{{$card -> back}}</i>
												</h1>
											</div>
											<form class="editcardform displaynone editform caredit{{$card -> id}}" >
												<input value="{{$card -> id}}" name="flashcard_id" type="hidden">
												<input value="{{$card -> front}}" name="front" class="qanda">
												<span>Question</span>
												<br><br>
												<input value="{{$card -> back}}" name="back"  class="qanda">
												<span>Answer</span>
												<input class="bgmatte enter" value="Edit Card" type="submit">
											</form>

											<div  class="displaynone displayyes car{{$card -> id}}">
												<a class="skip deletecard" flashcardid="{{$card -> id}}" style="right:45px;">Delete</a><a class="enter editcard" card="{{$card -> id}}">Edit Card</a>
											</div>

											<div class="displaynone caredit{{$card -> id}}">
												<a class="skip cancelcard" card="{{$card -> id}}" style="right:50px;">Cancel</a>
											</div>


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
