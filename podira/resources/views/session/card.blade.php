@extends('layouts.master')
@section('title', 'Your Current Decks')
@section('content')

<section name="main" class="" style="height:auto;min-height:80vh;">
	<h1 class="matte">Flashcard Review</h1>

		<div style="width:80%;margin-left:10%;text-align:center;" class="datanone data2 displayit">
				<div class="card sidebyside displaynone displayyes bgmatte" id="{{$deck->id}}" style="-webkit-animation-duration:0s;">
				<div class="innercard">
						<div class="emblem" style="border:none;">
								<div class="inneremblem" style="border:none;">
										<img src="{!! URL::asset('assets/images/podira_watermark.png') !!}">
								</div>

						</div>
						<h3>{{$card->front}}</h3>
						<h5 style="opacity:.5;">Answer: {{$card->back}}</h5>

						<br>




						<form method="POST" action="/deck/{{$deck->id}}/{{$type}}/next">
						    {!! csrf_field() !!}
						    	<input type="hidden" name="answer" value="{{$card->back}}">

										<button type="submit" style="border:none;" class="enter"> 	<i class="fa fa-bolt"></i> Next Card </button>

						</form>





				</div>

				</div>
		</div>


</section>
@endsection
<!--
<!DOCTYPE html>
<html>
<head>
	<title>Flashcard Review</title>
</head>
<body>
	<h1>{{$type}} this card.</h1>
	<p>{{$card->front}}</p>
	<p>{{$card->back}}</p>
	<form method="POST" action="/deck/{{$deck->id}}/{{$type}}/next">
	    {!! csrf_field() !!}
	    <div>
	    	<input type="hidden" name="answer" value="{{$card->back}}">
	        <button type="submit">Next</button>
	    </div>
	</form>
</body>
</html>
-->
