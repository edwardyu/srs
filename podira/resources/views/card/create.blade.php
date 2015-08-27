<html>
	<head>
		<title>Create a flashcard.</title>
	</head>
	<body>
		<h1>Create a flashcard.</h1>
		<form method="POST" action="/card/store">
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
		        <button type="submit">Create</button>
		    </div>
		</form>
	</body>
</html>