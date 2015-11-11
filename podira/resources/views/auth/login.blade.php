<!-- resources/views/auth/login.blade.php -->
@extends('layouts.master')
@section('title', 'Sign In')
@section('content')


<body>
  <section name="main" class="bgmatte full">
      <h1>Sign In</h1>
      <form  method="POST" action="/auth/login" class="signin">
        <div style="color:#ff6632;text-align:center;margin-bottom:5px;" class="error"></div>

        {!! csrf_field() !!}

          <input placeholder="Email" name="email" value="{{ old('email') }}">
          <input placeholder="Password" name="password" type="password" id="password">
          <input type="submit"  value="Sign In">
          <a href="/auth/password"> Forgot Password </a>
      </form>



  </section>
  <script>
  $('.signin').submit(function(event) {
      var formData = $(this).serializeArray();
			var base_url = window.location.protocol + "//" + window.location.host;
			$.ajaxSetup({
			   headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
			});
			$.ajax({
			    type: "POST", // or GET
			    url: base_url + "/auth/login",
					dataType: 'json',
			    data: formData,
			    success: function(data, event){
            if(data.responseText.includes("login.blade.php")){
              $('.error').html("Those Login Details Did Not Work!");
            }
			    },
          error: function(data, event){
            if(data.responseText.includes("login.blade.php")){
              $('.error').html("Those Login Details Did Not Work!");
            } else {
              location.reload();
            }
          }
			  });
        event.preventDefault();

    });
  </script>
</body>


@endsection
