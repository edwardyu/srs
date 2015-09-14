@if (Auth::check())
<div id="header" class="">
    <a href="/"><img class="logo" src="{!! URL::asset('assets/images/podira_purp.png') !!}"></a>
    <div class="links">
        <span><a href="/auth/logout" class="purple">Sign Out</a></span>
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