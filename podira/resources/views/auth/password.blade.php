<!-- resources/views/auth/login.blade.php -->
@extends('layouts.master')
@section('title', 'Sign In')
@section('content')

<body>
  <section name="main" class="bgmatte full">
      <h1>Reset Password</h1>
      <form  method="POST" action="/password/email">
        {!! csrf_field() !!}
          <input placeholder="Email" name="email" value="{{ old('email') }}">
          <input type="submit" value="Sign In">
          <a href="/auth/register">Remember Password </a>
      </form>
  </section>
</body>
@endsection
