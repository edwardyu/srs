<!-- resources/views/auth/login.blade.php -->
@extends('layouts.master')
@section('title', 'Page Title')
@section('content')

<body>
  <section name="main" class="bgmatte full">
      <h1>Sign In</h1>
      <form  method="POST" action="/auth/login">
        {!! csrf_field() !!}
          <input placeholder="Email" name="email" value="{{ old('email') }}">
          <input placeholder="Password" name="password" type="password" id="password">
          <input type="submit" value="Sign In">
          <a> Forgot Password </a>

      </form>



  </section>
</body>
@endsection
