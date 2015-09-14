@extends('layouts.master')
@section('title', 'Page Title')
@section('content')

<body>
    <section name="main" class="bgmatte">
        <h1>Notecards That Learn With Students</h1>
        <h2>Utilizing spaced repetition techniques with classroom analytics to
        better enable teachers to improve thier curriculum.  <br>Podira provides
        educators with the smartest notecards available, optimized to provide feedback and helpful data.</h2>



    </section>
    <section name="card" class="bgpurple bgpink">
        <h1>Powerful Flashcard Data for Educators</h1>
        <div class="card_demo">
            <div class="card_group">
                <h3>FOR STUDENTS</h3>
                <div class="card">
                    <div class="innercard">
                        <div class="emblem">
                            <div class="inneremblem">
                                <img src="{!! URL::asset('assets/images/turkey.png') !!}">
                            </div>

                        </div>
                        <h1>What Empire Surpassed the <br><span class="highlight">Malmud     Empire</span> in Modern Day Turkey?</h1>
                        <form>
                            <input class="answer" placeholder="Enter Your Answer">
                        </form>



                    </div>

                </div>
            </div>

            <div class="card_group">
                <h3>FOR TEACHERS</h3>
                <div class="card bgmatte lightborder">
                    <h1>"What Empire Surpassed the Malmud Empire in Modern Day Turkey"</h1>
                    <h2>Answer: <span class="white unlight">Ottoman Empire</span></h2>

                    <div class="stat">
                        <h1>46%</h1>
                        <h2>correct on first try</h2>
                    </div>

                    <div class="stat">
                        <h1>2.4</h1>
                        <h2>average seconds to answer correctly</h2>
                    </div>


                    <div class="stat">
                        <h1>9%</h1>
                        <h2>took more than 5 tries to answer correctly</h2>
                    </div>

                    <div class="stat fullwidth">
                        <h1>"Seljuq Dynasty"</h1>
                        <h2>most common incorrect answer</h2>
                    </div>

                </div>
            </div>
        </div>

    </section>
</body>
@endsection
