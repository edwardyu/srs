<html>
	<head>
		<title>View all cards.</title>
	</head>
	<body>
		@foreach($cards as $card)
		<p>{{ $card }}</p>
		@endforeach
	</body>
</html>