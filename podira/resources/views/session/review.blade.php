@extends('layouts.master')
@section('title', 'Your Current Decks')
@section('content')
<script>
$(document).ready(function(){


	$('label').click(function(){

		$('.enterb').addClass('displayyes');
		$('.skipb').removeClass('displayyes');

	})

})
</script>
<section name="main" class="" style="height:auto;min-height:80vh;">
	<h1 class="matte">Review {{$deck -> name}}</h1>

		<div style="width:80%;margin-left:10%;text-align:center;" class="datanone data2 displayit">
				<div class="card sidebyside bgbaige displaynone displayyes" id="{{$deck->id}}" >
				<div class="innercard">
						<div class="emblem">
								<div class="inneremblem">
										<img src="{!! URL::asset('assets/images/podira_watermark.png') !!}">
								</div>

						</div>
						<h1>{{$question}}</h1>
						 <form  method="POST" action="/deck/{{$deck->id}}/review/next">
							 {!! csrf_field() !!}
							@foreach($answers as $answer)
							<fieldset class="halfform">
								 <input type="radio" name="answer" id="{{ $answer }}" value="{{ $answer }}">
										 <label for="{{ $answer }}"  style="width:100%;"><span></span>{{ $answer }}</label>
							</fieldset>
							@endforeach

							<button type="submit" style="border:none;" class="displaynone enterb enter">Enter </button>
							<button type="submit" style="border:none;" class="displayyes displaynone bgpink skipb enter">Skip </button>

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
	<title> {{$type}} {{$deck->name}}</title>
</head>
<body>
	<h1>Review {{$deck->name}}</h1>
	<p>{{$question}}</p>
	<form method="POST" action="/deck/{{$deck->id}}/review/next">
	    {!! csrf_field() !!}
	    @foreach($answers as $answer)
	    <div>
	        <input type="radio" name="answer" value="{{ $answer }}">
	        {{$answer}}
	    </div>
	    @endforeach
	    <div>
	        <button type="submit">Next</button>
	    </div>
	</form>
</body>
</html>
-->
