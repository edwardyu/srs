@extends('layouts.master')
@section('title', 'Your Current Decks')
@section('content')
<script>
$("html").keydown(function(e) {
	e.keyCode; // this value
	console.log(e.keyCode);
			if(e.keyCode == 83){
				$('form#formcard').submit();
				return false;
				//skip
			}
			if(e.keyCode == 13){
				$('form#formcard').submit();
				return false;
				//enter
			}
})
</script>
<section name="main" class="" style="height:auto;min-height:80vh;">
	@if($previouslyCorrect == 1)
		<div class="success flipInX animated">
		 <i class="fa fa-check-circle-o"></i> Correct!
		</div>
	@endif

	@if($previouslyCorrect == 0 && isset($previouslyCorrect))
		<div class="success flipInX animated" style="background-color: #FF6632">
		 <i class="fa fa-times-circle-o"></i> Incorrect!
		</div>
	@endif



	<h1 class="matte">Flashcard Review


	</h1>

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




						<form method="POST" id="formcard" action="/deck/{{$deck->id}}/{{$type}}/next">
						    {!! csrf_field() !!}
						    	<input type="hidden" name="answer" value="{{$card->back}}">

										<button type="submit" style="border:none;" class="enter"> 	<i class="fa fa-bolt"></i> Next Card </button>

						</form>





				</div>

				</div>
		</div>


</section>
@endsection
