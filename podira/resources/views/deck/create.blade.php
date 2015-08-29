<html>
	<head>
		<title>Create a new course.</title>
	</head>
	<body>
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