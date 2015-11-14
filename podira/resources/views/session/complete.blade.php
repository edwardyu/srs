@extends('layouts.master')
@section('title', 'Page Title')
@section('content')

<body>
    <section name="main" class="bgmatte" style="height:auto;">
        <h1> Stats for <i>{{$deck -> name}}</i></h1>
        <h2>Below is the data from the flashcard deck.</h2>
				<div class="statflow">
					<h1 style="margin-bottom:14px;">GENERAL</h1>
					<div class="dataquad">
						<h3><i class="fa fa-male"></i> </h3>
						<h1>{{$cardsInteractedWith}}</h1>
						<h2>Number of Cards Interacted With</h2>
					</div>
					<div class="dataquad">
						<h3><i class="fa fa-clock-o"></i> </h3>
						<h1> {{$time}} secs</h1>
						<h2>Time Spent</h2>
					</div>
					<div class="dataquad">
						<h3><i class="fa fa-bullseye"></i> </h3>
						<h1>{{round($accuracy*100)}} %</h1>
						<h2>Average Accuracy</h2>
					</div>
				</div>

    </section>

</body>
@endsection
