<!-- resources/views/auth/register.blade.php -->
@extends('layouts.master')
@section('title', 'Sign Up')
@section('content')

<section name="main" class="bgmatte full">
    <h1>Sign Up</h1>
    <form method="POST" action="/auth/register">
      {!! csrf_field() !!}
        <input placeholder="Full Name" name="name">
        <input placeholder="Email" name="email">
        <input placeholder="Password" name="password" type="password">
        <input placeholder="Confirm Password" name="password_confirmation" type="password">
        <input type="submit" value="Sign Up">
        <a href="/auth/login"> Already Have Account </a>
    </form>
</section>
@endsection
