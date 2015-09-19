<div class="card sidebyside bgbaige displaynone displayyes" id="{{$card -> id}}" style="margin-top:115px;text-align:left;{{$style}}">
    <div class="innercard">
        <div class="emblem">
            <div class="inneremblem">
                <img src="{!! URL::asset('assets/images/podira_watermark.png') !!}">
            </div>

        </div>
        <div class="displaynone displayyes car{{$card -> id}}" style="width:100%;">
          <h1 style="width:90%;">
            @if(strlen($card -> front) < 150)
            <span class="carquestion{{$card -> id}}">{{$card -> front}}</span>
            @else
            <span class="carquestion{{$card -> id}}" style="font-size:10px;">{{$card -> front}}</span>
            @endif
          </h1>
          <br>
          <h1 style="width:90%;">
              Answer: <i class="caranswer{{$card -> id}}">{{$card -> back}}</i>
          </h1>
        </div>


        @if($edit = true)
        <form class="editcardform displaynone editform caredit{{$card -> id}}" >
          <input value="{{$card -> id}}" name="flashcard_id" type="hidden">
          <input value="{{$card -> front}}" name="front" class="qanda">
          <span>Question</span>
          <br><br>
          <input value="{{$card -> back}}" name="back"  class="qanda">
          <span>Answer</span>
          <input class="bgmatte enter" value="Edit Card" type="submit">
        </form>
        @endif


        <div  class="displaynone displayyes car{{$card -> id}}">
          <a class="skip deletecard" flashcardid="{{$card -> id}}" style="right:45px;">Delete</a><a class="enter editcard" card="{{$card -> id}}">Edit Card</a>
        </div>

        <div class="displaynone caredit{{$card -> id}}">
          <a class="skip cancelcard" card="{{$card -> id}}" style="right:50px;">Cancel</a>
        </div>


    </div>

</div>
