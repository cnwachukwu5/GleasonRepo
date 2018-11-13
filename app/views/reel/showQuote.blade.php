@extends('layouts.master')
@include('modal')

@section('content')


  <div id="subpage">


    <h2>Quote</h2>
    <br>
    <div>

      <a > {{ link_to($out['pdfPath'], 'CLICK HERE TO VIEW QUOTE', array('id'=>'viewQuote', 'target'=>'_blank') ) }}</a>
    </div>
    <div>
      Are you finished with this quote?

      <input type="checkbox" name="vehicle" value="finished" id="finished">Yes
      <br>
      <br>
      <br>
      <p>
        If you aren't done, you can go back to search results.
      </p>

    </div>

  <div style="position:absolute; margin-right:auto; margin-left:auto; bottom:40px; right:40px;" id="finishedYes">
    <a class="btn btn-primary" href="{{url('/reel')}}" >Return to Reels</a>
  </div>

    <div style="position:absolute; margin-right:auto; margin-left:auto; bottom:40px; right:40px;" id="finishedNo">
      <a class="btn btn-primary" href="{{url('/reel/returnResults')}}" >Return to Search Results</a>
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