<!DOCTYPE html>
<html>
<head>
	<title>Sessions</title>
</head>
<body>
	<p>User: {{$user}} </p>
	<h3>This session.</h3>
	<p>{{$session}}</p>

	<h3>All sesssion from this user.</h3>
	<p>{{$user_sessions}}</p>

	<h3>All sesssions from this deck.</h3>
	<p>{{$deck_sessions}}</p>
</body>
</html>