@extends('layouts.master')
@section('title', 'Smart Flashcards')

@section('content')
<body>
  <script>
    var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

    var barChartData = {
      labels : ["Set 1", "Set 2", "Set 3", "Set 4"],
      datasets : [
        {
          fillColor : "rgba(220,220,220,0.5)",
          strokeColor : "rgba(220,220,220,0.8)",
          highlightFill: "rgba(220,220,220,0.75)",
          highlightStroke: "rgba(220,220,220,1)",
          data : [60,69,63,79]
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
    <section name="main"  style="background-image: url({!! URL::asset('assets/images/p.png'); !!})">
        <h1>Notecards That Learn With Students</h1>
        <h2 style="font-weight:600;">We use spaced repetition techniques with classroom analytics to
        better enable teachers to improve their curriculums.  <br>Podira provides
        educators with the smartest notecards available, optimized to provide feedback and helpful data.</h2>

        <div class="statflow">
					<h1 style="margin-bottom:14px;">Statistics for <i>AP World History</i> (Example)</h1>
					<div class="dataquad" style="background:rgba(146,167,252,.9)">
						<h3><i class="fa fa-male"></i> </h3>
						<h1>45</h1>
						<h2>Number of users learning the deck</h2>
					</div>
          <div class="dataquad" style="background:rgba(146,167,252,.9)">
						<h3><i class="fa fa-clock-o"></i> </h3>

						<h1> 48</h1>
						<h2>Average minutes spent learning course</h2>

					</div>
          <div class="dataquad" style="background:rgba(146,167,252,.9)">
						<h3><i class="fa fa-th"></i> </h3>

						<h1>184</h1>
						<h2>Total number of cards interacted with</h2>

					</div>
          <div class="dataquad" style="background:rgba(146,167,252,.9)">
						<h3><i class="fa fa-bullseye"></i> </h3>
						<h1>72%</h1>
						<h2>Average Accuracy</h2>

					</div>
        </div>

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


    <section name="card" class="bgpurple" style="height:290px;">
        <h1>Data that helps improve your model and class</h1>
        <div style="width:80%;height:150px;margin-left:10%;padding-top:65px;">
          <center style="opacity:.7">Memory Retention of Concepts Learned in AP World History over Time</center>
          <canvas id="canvas" height="90"></canvas>
        </div>
    </section>

    <section name="card" class="" style="height:0px;">
        <h1 class="matte">Ready to get started with Podira's technology?</h1>
        <br><br><br>
        <h2 style="text-align:center;"><a href="/auth/register" class="bigsignup bgpurple">Get Started</a></h2>
    </section>

</body>
@endsection
