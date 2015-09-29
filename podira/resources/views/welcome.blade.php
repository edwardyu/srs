@extends('layouts.master')
@section('title', 'Smart Flashcards')

@section('content')
<body>
  <script>
    var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

    var barChartData = {
      labels : ["Set 1", "Succesful Set", "Problem Identified", "Set 4"],
      datasets : [
        {
          fillColor : "rgba(63,169,245,0.2)",
          strokeColor : "rgba(63,169,245,0.3)",
          highlightFill: "rgba(220,220,220,0.75)",
          highlightStroke: "rgba(220,220,220,1)",
          data : [60,70,63,79]
        }
      ]
    }
    window.onload = function(){
      var ctx = document.getElementById("canvas").getContext("2d");
      window.myBar = new Chart(ctx).Line(barChartData, {
        responsive : true
      });

      var legend = myBar.generateLegend();
      $('#legend').html(legend);

    }

    </script>
    <section name="main"  style="max-height:300px;background-image: url({!! URL::asset('assets/images/brain.png'); !!});background-size:35%;background-position: 50% 170px">
        <h1 class="matte">Memory Retention Tech for Teachers</h1>
        <h2 style="font-weight:600;" class="matte">Podira utilizes spaced repetition to optimize learning cycles
        for students by using data and neuroscience. <br>Our 21st century approach to learning allows students
        to work with things like Flashcards in smarter ways than before.</h2>
        <h3 style="width:120%;margin-left:-4%;">
          <canvas id="canvas" height="100"></canvas>

        </h3>


    </section>
    <section name="card" class="bgpurple bgpink">
        <h1>Want Data on Your Teaching Techniques?  We Got You Covered</h1>
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

<!--
    <section name="card" class="bgpurple" style="height:290px;">
        <h1>Data that helps improve your model and class</h1>
        <div style="width:80%;height:150px;margin-left:10%;padding-top:65px;">
          <center style="opacity:.7">Memory Retention of Concepts Learned in AP World History over Time</center>
        </div>
    </section>
-->
    <section name="card" class="" style="height:0px;">
        <h1 class="matte">Ready to get started with Podira's technology?</h1>
        <br><br><br>
        <h2 style="text-align:center;"><a href="/auth/register" class="bigsignup bgpurple">Get Started</a></h2>
    </section>

</body>
@endsection
