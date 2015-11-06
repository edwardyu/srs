@extends('layouts.master')
@section('title', 'Your Current Decks')
@section('content')
<script>
$(document).ready(function(){


	$('label').click(function(){
		$('.enterb').addClass('displayyes');
		$('.skipb').removeClass('displayyes');
		if($(this).attr('choiceid') == 'A'){
			$('.extra_block').removeClass('extra_chosen');
			$('.block1').addClass('extra_chosen');
		}
		if($(this).attr('choiceid') == 'B'){
			$('.extra_block').removeClass('extra_chosen');
			$('.block2').addClass('extra_chosen');
		}
		if($(this).attr('choiceid') == 'C'){
			$('.extra_block').removeClass('extra_chosen');
			$('.block3').addClass('extra_chosen');
		}
		if($(this).attr('choiceid') == 'D'){
			$('.extra_block').removeClass('extra_chosen');
			$('.block4').addClass('extra_chosen');
		}
	})

	$('.extra_block').click(function(){
		console.log($(this).attr('choiceid'))
		$('.extra_text').html("<b>My Answer:</b> " + $(this).html());

		if($(this).attr('choiceid') == 1){
			$(".halfform:nth-of-type(2)").prop('checked', true);
			$(".halfform:nth-of-type(3)").prop('checked', false);
			$(".halfform:nth-of-type(4)").prop('checked', false);
			$(".halfform:nth-of-type(5)").prop('checked', false);
			$('.enterb').addClass('displayyes');
			$('.skipb').removeClass('displayyes');
			$('.extra_block').removeClass('extra_chosen');
			$(this).addClass('extra_chosen');
			console.log('true');
		}
		if($(this).attr('choiceid') == 2){
			$(".halfform:nth-of-type(3)").prop('checked', true);
			$(".halfform:nth-of-type(2)").prop('checked', false);
			$(".halfform:nth-of-type(4)").prop('checked', false);
			$(".halfform:nth-of-type(5)").prop('checked', false);
			$('.enterb').addClass('displayyes');
			$('.skipb').removeClass('displayyes');
			$('.extra_block').removeClass('extra_chosen');
			$(this).addClass('extra_chosen');
		}
		if($(this).attr('choiceid') == 3){
			$(".halfform:nth-of-type(4)").prop('checked', true);
			$(".halfform:nth-of-type(3)").prop('checked', false);
			$(".halfform:nth-of-type(2)").prop('checked', false);
			$(".halfform:nth-of-type(5)").prop('checked', false);
			$('.enterb').addClass('displayyes');
			$('.skipb').removeClass('displayyes');
			$('.extra_block').removeClass('extra_chosen');
			$(this).addClass('extra_chosen');
		}
		if($(this).attr('choiceid') == 4){
			$(".halfform:nth-of-type(5)").prop('checked', true);
			$(".halfform:nth-of-type(3)").prop('checked', false);
			$(".halfform:nth-of-type(4)").prop('checked', false);
			$(".halfform:nth-of-type(2)").prop('checked', false);
			$('.enterb').addClass('displayyes');
			$('.skipb').removeClass('displayyes');
			$('.extra_block').removeClass('extra_chosen');
			$(this).addClass('extra_chosen');
		}
	})

	$("html").keydown(function(e) {
    e.keyCode; // this value
		console.log(e.keyCode);
		if(e.keyCode == 49){
			$(".halfform:nth-of-type(2)").prop('checked', true);
			$(".halfform:nth-of-type(3)").prop('checked', false);
			$(".halfform:nth-of-type(4)").prop('checked', false);
			$(".halfform:nth-of-type(5)").prop('checked', false);
			$('.enterb').addClass('displayyes');
			$('.skipb').removeClass('displayyes');
			$('.extra_block').removeClass('extra_chosen');
			$('.block1').addClass('extra_chosen');
			$('.extra_text').html("<b>My Answer:</b> " + $('.block1').html());
			console.log('true');
		}
		if(e.keyCode == 50){
			$(".halfform:nth-of-type(3)").prop('checked', true);
			$(".halfform:nth-of-type(2)").prop('checked', false);
			$(".halfform:nth-of-type(4)").prop('checked', false);
			$(".halfform:nth-of-type(5)").prop('checked', false);
			$('.enterb').addClass('displayyes');
			$('.skipb').removeClass('displayyes');
			$('.extra_block').removeClass('extra_chosen');
			$('.block2').addClass('extra_chosen');
			$('.extra_text').html("<b>My Answer:</b> " + $('.block2').html());

		}
		if(e.keyCode == 51){
			$(".halfform:nth-of-type(4)").prop('checked', true);
			$(".halfform:nth-of-type(3)").prop('checked', false);
			$(".halfform:nth-of-type(2)").prop('checked', false);
			$(".halfform:nth-of-type(5)").prop('checked', false);
			$('.enterb').addClass('displayyes');
			$('.skipb').removeClass('displayyes');
			$('.extra_block').removeClass('extra_chosen');
			$('.block3').addClass('extra_chosen');
			$('.extra_text').html("<b>My Answer:</b> " + $('.block3').html());

		}
		if(e.keyCode == 52){
			$(".halfform:nth-of-type(5)").prop('checked', true);
			$(".halfform:nth-of-type(3)").prop('checked', false);
			$(".halfform:nth-of-type(4)").prop('checked', false);
			$(".halfform:nth-of-type(2)").prop('checked', false);
			$('.enterb').addClass('displayyes');
			$('.skipb').removeClass('displayyes');
			$('.extra_block').removeClass('extra_chosen');
			$('.block4').addClass('extra_chosen');
			$('.extra_text').html("<b>My Answer:</b> " + $('.block4').html());

		}
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

	});

})
</script>
<section name="main" class="" style="height:auto;min-height:80vh;">
	<h1 class="matte">Review {{$deck -> name}}</h1>

		<div style="width:80%;margin-left:10%;text-align:center;" class="datanone data2 displayit">
				<div class="card sidebyside bgbaige displaynone displayyes" id="{{$deck->id}}" style="margin-bottom:20px;">
				<div class="innercard">
						<div class="emblem">
								<div class="inneremblem">
										<img src="{!! URL::asset('assets/images/podira_watermark.png') !!}">
								</div>

						</div>
						<h1>{{$question}}</h1>
						 <form  method="POST" id="formcard" action="/deck/{{$deck->id}}/review/next">
							 {!! csrf_field() !!}
							 @if(strlen($answers[0]) < 44 && strlen($answers[1]) < 44 && strlen($answers[2]) < 44 && strlen($answers[3]) < 44)
								@foreach($answers as $answer)
									 <input type="radio" name="answer" id="{{ $answer }}" class="halfform"  value="{{ $answer }}">
									 <label for="{{ $answer }}"  style="width:100%;display: block;text-align: left;"><span></span>{{ $answer }}</label>
								@endforeach
							 @else
								 @foreach([[1,'A'],[2,'B'],[3,'C'],[4,'D']] as $index)
										<input type="radio" name="answer" id="{{ $answers[$index[0] - 1] }}" class="halfform" style="display:none;"  value="{{ $answers[$index[0] - 1] }}">
										<label for="{{ $answers[$index[0] - 1] }}"  style="display:none;" choiceid="{{$index[1]}}" style="width:100%;display: block;text-align: left;"><span></span>{{ $index[1] }}</label>
								 @endforeach
								 <div class="extra_text"><span style="color:#aaa">Click Below to Answer</span></div>
							  @endif
							<button type="submit" style="border:none;" class="displaynone enterb enter">Enter </button>
							<button type="submit" style="border:none;" class="displayyes displaynone bgpink skipb enter">Skip </button>
						 </form>






				</div>

				</div>
				<div style="width:100%;clear:both;"></div>
				@if(!strlen($answers[0]) < 44 || !strlen($answers[1]) < 44 || !strlen($answers[2]) < 44 || !strlen($answers[3]) < 44)
				 @foreach([1,2,3,4] as $index)
				 		<div class="extra_block block{{$index}}" choiceid="{{$index}}">
							@if($index == 1)
								(A)
							@elseif($index == 2)
								(B)
							@elseif($index == 3)
								(C)
							@else($index == 4)
								(D)
							@endif

							{{$answers[$index - 1]}}</div>
				 @endforeach
				@endif

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
