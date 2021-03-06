<div class="progress bgpurple">
    <h1>PROGRESS
      @if(count($totalFlashcards) != 0)
      {{count($totalFlashcards) - $remainingFlashcards + 1}}/{{count($totalFlashcards)}}
      @endif

    </h1>
    <div class="progressbar">
      <div class="startdiode bgpurple"></div>
      @foreach($totalFlashcards as $index)
        @if(count($totalFlashcards) != 0)
          @if($index > (count($totalFlashcards) - $remainingFlashcards + 1))
          <div class="diode" style="left:{{ (100 / count($totalFlashcards)) * $index }}%;
          left: calc({{ (100 / count($totalFlashcards)) * $index }}% - 10px);"></div>
          @else
          <div class="diode bgpurple" style="left:{{ (100 / count($totalFlashcards)) * $index }}%;
          left: calc({{ (100 / count($totalFlashcards)) * $index }}% - 10px);"></div>
          @endif
        @endif
      @endforeach
      <div class="enddiode"></div>
      @if(count($totalFlashcards) != 0)
      <div class="innerbar bgpurple" style="width: {{ (100 / count($totalFlashcards)) * (count($totalFlashcards) - $remainingFlashcards + 1) }}%"></div>
      @endif

    </div>
</div>
