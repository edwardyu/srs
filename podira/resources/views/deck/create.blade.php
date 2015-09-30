@extends('layouts.master')
@section('title', 'Your Current Decks')
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


	$('.deletedeck').click(function(){
		var deckid = $(this).attr('deckid');
		console.log(deckid);

		var base_url = window.location.protocol + "//" + window.location.host;

		$.ajaxSetup({
			 headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
		});

		$.ajax({
				type: "POST", // or GET
				url: base_url + "/deck/" + deckid + "/delete",
				data: "id=" + deckid,
				success: function(data){
					$("#"+deckid).removeClass('displayyes');
				}
			});

	})

})
</script>


<section name="page" class="bgmatte">
	<h1>Your Current Decks</h1>

	<div class="minichooser">
		<a class="chooser chooseractive" style="width:50%;"  data-tab="data2">
			<i class="fa fa-th-large"></i>
			Current Decks</a>

		<a class="chooser" style="width:50%;" data-tab="data3">
			<i class="fa fa-plus-square"></i>

			Create Deck</a>
	</div>
</section>

<section name="main" style="padding-top:0px;margin-bottom:35px;" class="lightmain">
		<form class="deck datanone data3" style="background-color:#F5F5F5" method="POST" action="/deck/store">
			{!! csrf_field() !!}
			<fieldset class="title">Create a New Deck Below:</fieldset>
				<input placeholder="Title" name="name">
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
				<input type="submit" value="Create Deck">
		</form>

		<div style="width:80%;margin-left:10%;text-align:center;margin-bottom:20px;" class="datanone data2 displayit">
			@if(!$user->decks->isEmpty())
				@foreach($user->decks->reverse() as $deck)
				<div class="card sidebyside bgbaige displaynone displayyes" id="{{$deck->id}}" style="-webkit-animation-duration:0s;margin-top:10px;margin-bottom:0px;">
				<div class="innercard">
						<div class="emblem">
								<div class="inneremblem">
										<img src="{!! URL::asset('assets/images/podira_watermark.png') !!}">
								</div>

						</div>
						<h3 class="matte">{{$deck -> name}}</h3>
						<h5 class="matte" style="opacity:.5;margin-bottom:0px;">Created on {{date('F d, Y', strtotime($deck->created_at))}}</h5>
						<h5 class="matte" style="opacity:.5;margin-top:2px;margin-bottom:0px;">Learn: {{$numbers[$deck->id]['toLearn']}} | Review: {{$numbers[$deck->id]['toReview']}}</h5>
						<br>
						<a class="thirth bgbaige deletedeck matte" deckid="{{$deck->id}}">
							<i class="fa fa-trash-o"></i>
						</a>
						<a class="thirth bgblue"  href="/deck/{{$deck->id}}/add">
							<i class="fa fa-pencil"></i>
						</a>
						<a class="thirth bgmatte"  href="/deck/{{$deck->id}}/stats" style="padding-top:3px;padding-left:7px;padding-right:7px;">
							<i class="fa fa-pie-chart"></i> <span style="font-size:13px;">Statistics</span>
						</a>
						<a class="thirth bgpink"  href="/deck/{{$deck->id}}/review" style="padding-top:3px;padding-left:7px;padding-right:7px;" >
							<i class="fa fa-line-chart"></i>  <span style="font-size:13px;">Review</span>
						</a>
						<a class="thirth bgpurple"  href="/deck/{{$deck->id}}/learn" style="padding-top:3px;padding-left:7px;padding-right:7px;">
							<i class="fa fa-bolt"></i> <span style="font-size:13px;">Learn</span>
						</a>

				</div>

				</div>
				@endforeach
			@else
				<br><br><br><br><br>
				You have no current flashcards.
			@endif
		</div>

</section>
@endsection
<!--
<html>
	<head>
		<title>Create a new course.</title>
	</head>
	<body>
		<h1>Current courses.</h1>
		@if($user->decks)
			@foreach($user->decks as $deck)
			<p>
				{{$deck}}
				<a href="/deck/{{$deck->id}}/learn">Learn</a>
				<a href="/deck/{{$deck->id}}/review">Review</a>
			</p>
			@endforeach
		@endif
		<h1>Create a new course.</h1>
		<form method="POST" action="/deck/store">
		    {!! csrf_field() !!}
		    <div>
		        Name
		        <input type="text" name="name" value="{{ old('name') }}">
		    </div>

		    <div>
		        <button type="submit">Create</button>
		    </div>
		</form>
	</body>
</html>
-->
