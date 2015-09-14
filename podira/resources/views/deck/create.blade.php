@extends('layouts.master')
@section('title', 'Page Title')
@section('content')

<section name="main" class="bgmatte full">
		<h1>Create a Flashcard Deck</h1>
		<form class="deck" method="POST" action="/deck/store">
			{!! csrf_field() !!}
			 <fieldset>General</fieldset>
				<input placeholder="Title" name="name">
				<!--<input placeholder="Short Tagline" name="tagline">
				<fieldset>Class</fieldset>
				<select>
						<option>Arabic History</option>
						<option>AP World History</option>
				</select>
				<select>
						<option>All Sections</option>
						<option>1st Period</option>
						<option>2nd Period</option>
						<option>6th Period</option>
				</select>-->
				<input type="submit" value="Create Deck">
		</form>



</section>
@endsection
<!--
<html>
	<head>
		<title>Create a new course.</title>
	</head>
	<body>
		<h1>Current courses.</h1>
		@if($user->decks)
			@foreach($user->decks as $deck)
			<p>
				{{$deck}}
				<a href="/deck/{{$deck->id}}/learn">Learn</a>
				<a href="/deck/{{$deck->id}}/review">Review</a>
			</p>
			@endforeach
		@endif
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
-->
