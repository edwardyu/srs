@extends('layouts.master')
@section('title', 'Page Title')
@section('content')

<body>

    <section name="main" class="bgmatte full">
        <h1>You have no current cards to {{$type}}!</h1>
        <h2>Either you have finished this deck or should start learning it</h2>

    </section>
</body>
@endsection
