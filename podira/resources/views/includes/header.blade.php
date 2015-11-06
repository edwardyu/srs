@if (Auth::check())
<div id="header" class="bgmatte">
    <a href="/"><img class="logo" src="{!! URL::asset('assets/images/podira_matte.png') !!}"></a>
    <div class="links">
        <span><a href="/auth/logout">Sign Out</a></span>

        @if((Auth::user() -> stripe_active) == 0)
        <span><a href="/pro">Go Pro</a></span>
        @else
        <span><a href="/pro">Pro Settings</a></span>
        @endif


        <span><a href="/">My Decks</a></span>
        <span style="opacity:.5;cursor:auto;">Logged in as <i>{{Auth::user() -> name}}</i></span>
    </div>
</div>
@else
<div id="header" class="bgpurple">
    <a href="/"><img class="logo" src="{!! URL::asset('assets/images/podira.png') !!}"></a>
    <div class="links">
        <span><a href="/auth/register" class="signup">Sign Up</a></span>
        <span><a href="/auth/login">Sign In</a></span>
    </div>
</div>
@endif
