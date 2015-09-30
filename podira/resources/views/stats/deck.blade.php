@extends('layouts.master')
@section('title', $deck -> name . ' Stats')
@section('content')

<body>


	<script>
	$(document).ready(function(){

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

	})
	</script>

	<script>
		var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

		var barChartData = {
			labels : ["Aztec Empire's Growth","WWII","The Turbulent 60s"],
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,0.8)",
					highlightFill: "rgba(220,220,220,0.75)",
					highlightStroke: "rgba(220,220,220,1)",
					data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
				},
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,0.8)",
					highlightFill : "rgba(151,187,205,0.75)",
					highlightStroke : "rgba(151,187,205,1)",
					data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
				}
			]

		}
		window.onload = function(){
			var ctx = document.getElementById("canvas").getContext("2d");
			window.myBar = new Chart(ctx).Bar(barChartData, {
				responsive : true
			});
		}

		</script>

    <section name="main" class="bgpurple" style="height:auto;">
        <h1> Stats for <i>{{$deck -> name}}</i></h1>
        <h2>Below is the data from the flashcard deck.</h2>

				<div class="statflow">
					<h1 style="margin-bottom:14px;">GENERAL</h1>
					<div class="dataquad">
						<h3><i class="fa fa-male"></i> </h3>
						<h1>{{$numUsers}}</h1>
						<h2>Number of users learning the deck</h2>
					</div>
					<div class="dataquad">
						<h3><i class="fa fa-clock-o"></i> </h3>

						<h1> {{$totalTime}}</h1>
						<h2>Total seconds spent learning course</h2>

					</div>
					<div class="dataquad">
						<h3><i class="fa fa-th"></i> </h3>

						<h1>{{$totalInteractions}}</h1>
						<h2>Total number of cards interacted with</h2>

					</div>
					<div class="dataquad">
						<h3><i class="fa fa-bullseye"></i> </h3>
						<h1>{{$accuracy}}%</h1>
						<h2>Average Accuracy</h2>

					</div>

					<h1 style=>TOP 4 MOST DIFFICULT CARDS</h1>
					<div style="width:80%;margin-left:10%;text-align:center;margin-top:-80px;padding-top:0px;">
							@foreach($mostDifficultCards as $card)
							<div class="card sidebyside bgbaige displaynone displayyes" id="{{$card -> id}}" style="-webkit-animation-duration:0s;margin-top:55px;margin-bottom:-40px;text-align:left;float:left;width:48%;margin-left:1%;margin-right:1%;">
									<div class="innercard">
											<div class="emblem">
													<div class="inneremblem">
															<img src="{!! URL::asset('assets/images/podira_watermark.png') !!}">
													</div>

											</div>
											<div class="displaynone displayyes car{{$card -> id}}">
												<h1 style="width:90%;"><span class="carquestion{{$card -> id}}">{{$card -> front}}</span></h1>
												<br>
												<h1 style="width:90%;">
														Answer: <i class="caranswer{{$card -> id}}">{{$card -> back}}</i><br>
														Memory retention: {{$mostDifficultConcepts[$card->id]}}%.

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
					</div>

					<h1 style="margin-top:60px;">TOP 4 MOST INTUITIVE CARDS</h1>
					<div style="width:80%;margin-left:10%;text-align:center;margin-top:-40px;padding-top:0px;">
							@foreach($mostIntuitiveCards as $card)
							<div class="card sidebyside bgbaige displaynone displayyes" id="{{$card -> id}}" style="-webkit-animation-duration:0s;margin-top:55px;margin-bottom:-40px;text-align:left;float:left;width:48%;margin-left:1%;margin-right:1%;">
									<div class="innercard">
											<div class="emblem">
													<div class="inneremblem">
															<img src="{!! URL::asset('assets/images/podira_watermark.png') !!}">
													</div>

											</div>
											<div class="displaynone displayyes car{{$card -> id}}">
												<h1 style="width:100%;"><span class="carquestion{{$card -> id}}">{{$card -> front}}</span></h1>
												<br>
												<h1 style="width:100%;">
														Answer: <i class="caranswer{{$card -> id}}">{{$card -> back}}</i>
														<br>
														Memory retention: {{$mostIntuitiveConcepts[$card->id]}}%.
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
					</div>
				</div>
		<!--
				<p>Top 5 most difficult Cards:</p>
				<ol>
					@foreach($mostDifficultCards as $card)
					<li>{{$card}} {{$mostDifficultConcepts[$card->id]}}</li>
					@endforeach
				</ol>

				<p>Top 5 most intuitive Cards:</p>
				<ol>
					@foreach($mostIntuitiveCards as $card)
					<li>{{$card}} {{$mostIntuitiveConcepts[$card->id]}}</li>
					@endforeach
				</ol>
			-->
    </section>
</body>
@endsection
<!--<!DOCTYPE html>
<html>
<head>
	<title>Deck stats.</title>
</head>
<body>
	<h1>Stats for {{$deck->name}}</h1>
	<p>Number of users learning course: {{$numUsers}} </p>
	<p>Total time spent learning course: {{$totalTime}} seconds </p>
	<p>Total number of cards interacted with: {{$totalInteractions}}</p>

	<p>Top 5 most difficult Cards:</p>
	<ol>
		@foreach($mostDifficultCards as $card)
		<li>{{$card}} {{$mostDifficultConcepts[$card->id]}}</li>
		@endforeach
	</ol>

	<p>Top 5 most intuitive Cards:</p>
	<ol>
		@foreach($mostIntuitiveCards as $card)
		<li>{{$card}} {{$mostIntuitiveConcepts[$card->id]}}</li>
		@endforeach
	</ol>
</body>
</html>
-->
