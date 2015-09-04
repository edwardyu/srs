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