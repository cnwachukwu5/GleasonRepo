@extends('layouts.master')

@section('page-title')
Festoon
@stop

@section('content')

@include('modal')
<fieldset class="form-horizontal">
  <ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#customerinformation" role="tab" data-toggle="tab" id="custInfoTab">Customer Information</a></li>
    <li><a href="#package" role="tab" data-toggle="tab" id="cableTab">Cable/Hose Package</a></li>
    <li><a href="#application" role="tab" data-toggle="tab">Application</a></li>
    <li><a href="#search" role="tab" data-toggle="tab">Festoon Search Criteria</a></li>
  </ul>
  <form method="post" action="{{ url('/fest/results/') }}">
  <div class="tab-content" id="subpage">
    <div class="tab-pane active" id="customerinformation">
      @include('fest.tabs.customerinfo')
      <hr class="hr">
      <a class="btn btn-primary btn-xs btn-nxt" id="step1" href="#">Next</a>
    </div>

    <div class="tab-pane" id="package">
      @include('fest.tabs.package')
      <hr class="hr">
      <a class="btn btn-primary btn-xs btn-nxt" id="step2" href="#">Next</a>
    </div>

    <div class="tab-pane" id="application">
      @include('fest.tabs.application')
      <hr class="hr">
      <a class="btn btn-primary btn-xs btn-nxt" id="step3">Next</a>
    </div>

    <div class="tab-pane" id="search">
      @include('fest.tabs.search.search')
      <hr class="hr">
      <input type="submit" class="btn btn-primary btn-xs btn-nxt" id="step4"/>
    </div>
  </div>
  </form>
  <br>
</fieldset>


@stop

@section('scripts')

<script type="text/javascript">

var customerid;
/* Mark existing rows as deleted if the remove button is clicked */
var onCableTab = false;
var cancelledPackage = false;



$('.btn-delete').on('click', function() {
    $(this).parent().parent().hide();
    $(this).parent().find('input[name="delete[]"]').val(true);
});



$('#part').on('keyup paste change', function() {

   var val = $.trim($('#part').val());

   $.getJSON("{{ url('/parts/get').'/' }}" + val, function(data) {
        if(data.length > 0) {

            $('#desc').val(data[0].description);
            $('#price').val(data[0].price);
            $('#stk').val(data[0].stocked);
            $('#unit').val(data[0].unit);


        }
   });

});



$('#select-customer').on('click', function() {
    $.get("{{ url('/customers/select') }}", function(data) {
        $('body').append($('<div>').attr('id', 'modal').html(data));

        var options = {
            "backdrop" : "static"
        }

        $('#modal').modal(options);
    });
});

$('#modal').on('hidden.bs.modal', function (e) {
    var cust = $('.cust-selected:first');
    $('#cust-name').text(cust.children('td:nth-child(3)').text());
    $('#cust-id').val(cust.children('td:nth-child(1)').children(':first').val());
    $(e.target).removeData('bs.modal');
});



$('.btn-nxt').click(function(){

  var nextId = $(this).parents('.tab-pane').next().attr("id")||'step1';
  $('[href=#'+nextId+']').tab('show');

});

function checkRequired()
{
  if($("#style").selectedIndex > 0) $("#type").selectedIndex = 2;
}

function checkType()
{
  var style = $('#style').val();
  if(style == "Single Hose")
  {
    $('#insidediameter')
      .empty();
    $('#insidediameter')
      .append("<option disabled hidden selected value=''></option><option value='0.188'>0.188</option><option value='0.250'>0.250</option><option value='0.375'>0.375</option><option value='0.500'>0.500</option><option value='0.625'>0.625</option><option value='0.750'>0.750</option><option value='0.875'>0.875</option><option value='1.000'>1.000</option><option value='1.125'>1.125</option><option value='1.250'>1.250</option><option value='1.375'>1.375</option><option value='1.500'>1.500</option><option value='1.625'>1.625</option><option value='1.750'>1.750</option>"
      );
    $('#psiDiv').show();
  }
  else
  {
    $('#insidediameter')
      .empty();
    $('#insidediameter')
      .append("<option disabled hidden selected value=''></option><option value='0.25'>0.25</option><option value='0.375'>0.375</option><option value='0.50'>0.50</option><option value='0.75'>0.75</option>"
      );
    $('#psiDiv').hide();
  }

}



</script>

@stop
