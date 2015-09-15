@if (Auth::check())
<div id="header" class="">
    <a href="/"><img class="logo" src="{!! URL::asset('assets/images/podira_purp.png') !!}"></a>
    <div class="links">
        <span><a href="/auth/logout" class="purple">Sign Out</a></span>
        <span><a href="/home" class="purple">My Decks</a></span>
        <span class="purple" style="opacity:.5;cursor:auto;">Logged in as <i>{{Auth::user() -> name}}</i></span>
    </div>
</div>
@else
<div id="header" class="bgpurple">
    <a href="/"><img class="logo" src="{!! URL::asset('assets/images/podira.png') !!}"></a>
    <div class="links">
        <span><a href="/auth/register">Sign Up</a></span>
        <span><a href="/auth/login">Sign In</a></span>
    </div>
</div>
@endif
