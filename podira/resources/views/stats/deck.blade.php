<!DOCTYPE html>
<html>
<head>
	<title>Deck stats.</title>
</head>
<body>
	<h1>Stats for {{$deck->name}}</h1>
	<p>Number of users learning course: {{$numUsers}} </p>
	<p>Total time spent learning course: {{$totalTime}} seconds </p>
	<p>Total number of cards interacted with: {{$totalInteractions}}</p>

	<p>Top 5 most difficult Cards:</p>
	<ol>
		@foreach($mostDifficultCards as $card)
		<li>{{$card}} {{$mostDifficultConcepts[$card->id]}}</li>
		@endforeach
	</ol>

	<p>Top 5 most intuitive Cards:</p>
	<ol>
		@foreach($mostIntuitiveCards as $card)
		<li>{{$card}} {{$mostIntuitiveConcepts[$card->id]}}</li>
		@endforeach
	</ol>
</body>
</html>