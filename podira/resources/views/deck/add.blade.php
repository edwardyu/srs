<html>
	<head>
		<title>{{$deck->name}}</title>
	</head>
	<body>
		<h1>{{$deck->name}}</h1>
		@foreach($deck->flashcards as $card)
		<p>{{ $card }}</p>
		@endforeach

		<h3>Add a flashcard.</h3>
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
		</form>	
	</body>
</html>