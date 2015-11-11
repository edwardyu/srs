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
