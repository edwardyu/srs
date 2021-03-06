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

	$('.cardchooser').click(function(){
		var tab_id = $(this).attr('data-tab');
		$('.cardtype').removeClass('displayit');
		$(".cardtype"+tab_id).addClass('displayit');
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
      var formData = $(this).serializeArray();
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
			    }
			  });
				var card = formData[0].value;
				$('.caredit' + card).removeClass('displayyes');
				$('.car' + card).addClass('displayyes');
				$('.carquestion' + card).html(formData[1].value);
				$('.caranswer' + card).html(formData[2].value);
      event.preventDefault();
  });



	$('.deletecard').click(function(){
		var flashcard_id = $(this).attr('flashcardid');
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
					if(res[0] == 1){
						$(".userfail").html('That user isn\'t currently registered on Podira or has been already added!');
					}
					if(res[0] == 2){
						$(".userfail").html('You currently cannot add users.  Upgrade to Pro to add new users!');
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
				}
			});
			event.preventDefault();
	})


	$('.deletedeck').click(function(){
		var deckid = $(this).attr('deckid');
		var base_url = window.location.protocol + "//" + window.location.host;

		$.ajaxSetup({
			 headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
		});
		$.ajax({
				type: "POST", // or GET
				url: base_url + "/deck/" + deckid + "/delete",
				data: "id=" + deckid,
				success: function(data){
					// redirect to deck pages
					window.location = '/'
				}
			});

	})

	$('.deleteuser').click(function(){
		var userid = $(this).attr('userid');
		var deckid = $(this).attr('deckid');
		var base_url = window.location.protocol + "//" + window.location.host;

		$.ajaxSetup({
			 headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
		});
		$.ajax({
				type: "POST", // or GET
				url: base_url + "/deck/" + deckid + "/deleteUser",
				data: "user_email=" + userid,
				success: function(data){
					// redirect to deck pages
					window.location = '/'
				}
			});
	})
})
</script>



<section name="page" class="bgpurple" >
	<h1>Edit <i>{{$deck -> name}}</i></h1>

	<div style="width:100%;text-align:center;margin-bottom:20px;">
			<a class="thirth bgblue outwhite optionbutton"  href="/deck/{{$deck->id}}/learn" >
				<i class="fa fa-bolt"></i> <span style="font-size:13px;">Learn Deck</span>
			</a>
			<a class="thirth bgpink outwhite optionbutton"  href="/deck/{{$deck->id}}/review"  >
				<i class="fa fa-line-chart"></i>  <span style="font-size:13px;">Review Deck</span>
			</a>
			<a class="thirth bgmatte outwhite optionbutton"  href="/deck/{{$deck->id}}/stats" style="border: 1px rgba(255,255,255,.3) solid;">
				<i class="fa fa-pie-chart"></i> <span style="font-size:13px;">View Statistics</span>
			</a>
			<a class="thirth bgbaige deletedeck matte outwhite optionbutton" deckid="{{$deck->id}}">
				<i class="fa fa-trash-o"></i> <span style="font-size:13px;">Delete Deck</span>
			</a>
	</div>

	<div class="minichooser">
		<a class="chooser chooseractive" data-tab="data1" >
			<i class="fa fa-plus-square-o"></i>
Add Cards</a>
		<a class="chooser" data-tab="data2">
			<i class="fa fa-male"> </i>
			Add Users</a>
	</div>

</section>

<section name="main" class="lightmain" style="height:auto;">


		<form class="deck datanone data1 displayit" style="background-color:#F5F5F5" method="POST" action="/deck/{{$id}}/storeCard">
			<fieldset class="title">Add a New Card</fieldset>
			{!! csrf_field() !!}


				<input type="radio" id="choices" name="cardtype" value="choices" checked>
				<label class="cardchooser" data-tab="1" for="choices"><i class="fa fa-align-justify"></i> Four Choices</label>

				<input type="radio" id="tof" name="cardtype" value="tof">
				<label class="cardchooser" data-tab="3" for="tof"><i class="fa fa-check-square-o"></i> True or False</label>

				<input type="radio" id="fill" name="cardtype" value="fill">
				<label class="cardchooser" data-tab="2" for="fill"><i class="fa fa-pencil"></i> Write In</label>


			  <!--
				<input type="radio" id="blank" name="cardtype">
				<label class="cardchooser" data-tab="4" for="blank"><i class="fa fa-pencil-square-o"></i> Fill In the Blank</label>


				<input type="radio" id="math" name="cardtype">
				<label class="cardchooser" data-tab="5" for="math">% Math</label>
				-->


				<fieldset class="bgpurple info cardtype cardtype4" style="font-weight:300;margin-bottom:10px;color:white;padding-bottom:16px;border-radius:3px;">Type in the full sentence for the question and the words that will be replaced by the blank in the answer (e.g.: [<b>Question:</b> Salt goes with Pepper, <b>Answer:</b> Salt] for <i>_________ goes with Pepper</i>).</fieldset>
				<textarea placeholder="Question" name="front"></textarea>
				<textarea placeholder="Answer" class="cardtype cardtype1 cardtype2 displayit" name="back"></textarea>

				<!--
				<input class="displayit cardtype cardtype1" placeholder="Fake Answer 1 (Optional)" name="fake-answer-1"></input>
				<input class="displayit cardtype cardtype1" placeholder="Fake Answer 2 (Optional)" name="fake-answer-2"></input>
				<input  class="displayit cardtype cardtype1" placeholder="Fake Answer 3 (Optional)" name="fake-answer-3"></input>
			  -->
				<input  class="cardtype cardtype4" placeholder="Answer" name="fillin"></input>

				<input type="radio" id="true" name="back" value="True">
				<label class="cardtype cardtype3" for="true"><i class="fa fa-check"></i> True</label>

				<input type="radio" id="false" name="back" value="False">
				<label class="cardtype cardtype3" for="false"><i class="fa fa-close"></i> False</label>



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


		<form class="deck datanone data2 adduser" style="background-color:#F5F5F5" id="data2">
			<fieldset class="title">Add a New User</fieldset>
			{!! csrf_field() !!}
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
		</form>
<br>

		<div class="cardoverview datanone data1 displayit">{{$deck -> name}}'s Cards</div>
				<div style="width:60%;margin-left:20%;text-align:center;" class="datanone data1 displayit">
					@if ($deck->flashcards->isEmpty())
						<br><br><br><br><br><br>
						You have no current cards in this deck.
					@else
							@foreach($deck->flashcards->reverse() as $card)
							<div class="card sidebyside bgbaige displaynone displayyes" id="{{$card -> id}}" style="-webkit-animation-duration:0s;margin-top:115px;text-align:left;float:left;width:48%;margin-left:1%;margin-right:1%;">
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
							@if(count($deck->flashcards) %2 == 0)
							<div class="card sidebyside displaynone displayyes" style="-webkit-animation-duration:0s;margin-top:10px;margin-bottom:0px;visibility:hidden !important;">
							<div class="innercard" style="border-style:dashed;">
									<div class="emblem">
											<div class="inneremblem">
													<img src="{!! URL::asset('assets/images/podira_watermark.png') !!}">
											</div>

									</div>
									<h3 class="matte">  <!-- BLANK --> </h3>
									<h5 class="matte" style="opacity:.5;margin-bottom:0px;"> &nbsp </h5>
									<h5 class="matte" style="opacity:.5;margin-top:2px;margin-bottom:0px;"> &nbsp </h5>


									<br>


							</div>

							</div>
							@endif
					@endif
				</div>

			<div class="datanone data2  matte" style="width:40%;margin-left:30%;margin-top:40px;">
				<div class="userfail purple" style="margin-bottom:10px;"></div>
				@foreach($deck -> users as $user)
					<div class="user"><span class="name">{{$user -> name}}</span><span class="email">{{$user -> email}}</span>

						<span style="float:right;color:#FF6632;cursor:pointer;" class="deleteuser" deckid="{{$deck->id}}" userid="{{$user->email}}">Delete</span>
					</div>
				@endforeach
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
