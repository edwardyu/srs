@extends('layouts.master')
@section('title', 'Page Title')
@section('content')

<body>
<section name="main" class="bgmatte full">
		<h1>Create a Flashcard Deck</h1>
		<form class="deck">
			{!! csrf_field() !!}
			 <fieldset>General</fieldset>
				<input placeholder="Title" name="front">
				<input placeholder="Short Tagline" name="tagline">
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
				</select>
				<input type="submit" value="Create Deck">
		</form>



</section>
<!--
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
</html>-->
