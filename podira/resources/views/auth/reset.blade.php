<!-- resources/views/auth/login.blade.php -->
@extends('layouts.master')
@section('title', 'Sign In')
@section('content')

<body>
  <section name="main" class="bgmatte full">
      <h1>Reset Password</h1>
      <form  method="POST" action="/password/reset">
        {!! csrf_field() !!}
          <input type="hidden" name="token" value="{{ $token }}">

          <input placeholder="Email" name="email" value="{{ old('email') }}">
          <input placeholder="Password" name="password" type="password">
          <input placeholder="Password Confirmation" name="password_confirmation" type="password">


          <input type="submit" value="Sign In">
          <a href="/auth/register">Remember Password </a>

      </form>



  </section>
</body>
@endsection
