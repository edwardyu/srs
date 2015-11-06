@extends('layouts.master')
@section('title', 'Your Current Decks')
@section('content')
<script>

$(document).ready(function(){

$('.contactform').submit(function(event) {

    // get the form data
    // there are many ways to get this data using jQuery (you can use the class or id also)
    var formData = $(this).serializeArray();

    console.log(formData);
    // process the form
    var base_url = window.location.protocol + "//" + window.location.host;

    $.ajaxSetup({
       headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });

    $.ajax({
        type: "POST", // or GET
        url: base_url + "/contact",
        dataType: 'json',
        data: formData,
        success: function(data){
          console.log("sucess!!");
          console.log(data);
          $('.fo').val("");
          $("h1").html('Email Sent!');
        }
      });

    // stop the form from submitting the normal way and refreshing the page
    event.preventDefault();
});
})
</script>


<section name="main" class="bgmatte full">
    <h1>Have a Question?  Feel Free to Contact Us Below.</h1>
    <form method="POST" class="contactform">
      {!! csrf_field() !!}
        <input placeholder="Full Name" name="name" class="fo">
        <input placeholder="Email" name="email" class="fo">
        <input placeholder="Subject" name="subject" class="fo">
        <textarea placeholder="Message" name="message" class="fo"></textarea>
        <input type="submit" value="Send" >
        <a style="width:auto;padding-left:5px;padding-right:5px;">Or Email Us at Team@Podira.com </a>
    </form>

</section>


@endsection
