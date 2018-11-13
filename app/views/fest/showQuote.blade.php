@extends('layouts.master')
@include('modal')

@section('content')


  <div id="subpage">


    <h2>Quote</h2>
    <br>
    <div>

      <a > {{ link_to('/images/tempQuote/'.$out['outputName'].'.pdf', 'CLICK HERE TO VIEW PDF', array('id'=>'viewQuote', 'target'=>'_blank') ) }}</a>
    </div>
    <div>
      Are you finished with this quote?

      <input type="checkbox" name="vehicle" value="finished" id="finished">Yes
      <br>
      <br>
      <br>
      <p>
        If you aren't done, you can go back to search results or modify the accessories included in the quote.
      </p>

    </div>


  <div style="position:absolute; margin-right:auto; margin-left:auto; bottom:40px; right:40px;" id="finishedYes">
    <button type="button" class="btn btn-primary">Return to Reels</button>
    <button type="button" class="btn btn-primary">Create another Quote</button>
    <button type="button" class="btn btn-danger">Delete this quote [Will not be stored]</button>
  </div>

    <div style="position:absolute; margin-right:auto; margin-left:auto; bottom:40px; right:40px;" id="finishedNo">
      <button type="button" class="btn btn-primary">Return to Search Results</button>
      <button type="button" class="btn btn-primary">Modify quote</button>
    </div>



  </div>


@stop
@section('scripts')
  <script>
    $( "#finishedYes" ).hide();
    $("#viewQuote").click(function(){


    });

    $('#finished').on('change', function() {

      if($('#finishedNo').is(":visible")){
        $( "#finishedNo" ).hide();
        $( "#finishedYes" ).show();
      }
      else{
        $( "#finishedNo" ).show();
        $( "#finishedYes" ).hide();
      }
    }
    );


  </script>
@stop