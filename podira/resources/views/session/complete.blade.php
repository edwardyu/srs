@extends('layouts.master')
@section('title', 'Page Title')
@section('content')

<body>

    <section name="main" class="bgmatte full">
        <h1>You Completed {{$deck -> name}} Successfully!</h1>
        <h2>Great job!</h2>
        <h1>Session Stats</h1>
        <p>Time spent: {{$time}} seconds</p>
        <p>Number of cards interacted with: {{$cardsInteractedWith}}</p>
        <p>Accuracy: {{round($accuracy*100)}} %</p>
    </section>
</body>
@endsection
