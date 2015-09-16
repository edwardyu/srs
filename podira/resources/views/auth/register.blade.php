<!-- resources/views/auth/register.blade.php -->
@extends('layouts.master')
@section('title', 'Sign Up')
@section('content')

<section name="main" class="bgmatte full">
    <h1>Sign Up</h1>
    <form method="POST" action="/auth/register">
      {!! csrf_field() !!}
        <input placeholder="First Name" name="name" class="half_1">
        <input placeholder="Last Name" name="lastname" class="half_2">
        <input placeholder="Email" name="email">
        <input placeholder="Password" name="password" type="password">
        <input placeholder="Confirm Password" name="password_confirmation" type="password">
        <input type="submit" value="Sign Up">
        <a> Already Have Account </a>
    </form>
</section>
@endsection
