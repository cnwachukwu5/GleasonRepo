@extends('layouts.master')

@section('page-title')
Festoon
@stop

@section('content')

@include('modal')

<form method="post" action="{{ Request::url() }}" class="form-horizontal">
<fieldset>
  <ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#customerinformation" role="tab" data-toggle="tab">Customer Information</a></li>
    <li><a href="#package" role="tab" data-toggle="tab">Cable/Hose Package</a></li>
    <li><a href="#application" role="tab" data-toggle="tab">Application</a></li>
    <li><a href="#search" role="tab" data-toggle="tab">Festoon Search Criteria</a></li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="customerinformation">
      <h3>Customer Information</h3>
      <div class="form-group">
        <div class="col-sm-1">
          <span id="cust-name">@if (isset($quote) && $quote->customer()->first() != null) {{ $quote->customer()->first()->name  }} @endif</span>
          <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal" href="{{ url('/customers/select') }}">Select customer</a>
        </div>
      </div>

    </div>

  
    <div class="tab-pane" id="package">
      <h3>Cables and Hoses</h3>
      <div>
        <strong>The table below displays the cables/hoses which make up your package</strong>
        <br><br>
        <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal" href="{{ url('/trak/cable/select') }}">Add CABLE</a>
        <a class="btn btn-primary btn-xs marginleft" data-toggle="modal" data-target="#modal" href="{{ url('/trak/hose/select') }}">Add HOSE</a>
      </div>
      <table id="cables-table" class="table table-striped table-responsive">
        <thead>
          <tr>
            <th>Quantity</th>
            <th>Style</th>
            <th>Type</th>
            <th>AWG</th>
            <th>Cond</th>
            <th>Volts</th>
            <th>PSI</th>
            <th>ID/Width</th>
            <th>OD/Thickness</th>
            <th>Bend Radius</th>
            <th>Weight</th>
            <th>$/Ft</th>
            <th>PN</th>
          </tr>
        </thead>
        <tbody>
          @if (isset($parts))
            @foreach ($parts->toArray() as $p)
            <tr>
              <td><input type="text" name="qty[]" value="{{ $p['quantity'] }}" class="form-control" /></td>
              <td><input type="text" name="part[]" value="{{ $p['number'] }}" class="form-control" /></td>
              <td><input type="text" name="desc[]" value="{{ $p['description'] }}" class="form-control" /></td>
              <td><select name="stk[]" class="form-control" class="form-control">
                  <option value="0" {{ $p['stocked']=="0"? 'selected="selected"' : '' }}>No</option>
                  <option value="1" {{ $p['stocked']=="1"? 'selected="selected"' : '' }}>Yes</option></select>
              </td>
              <td><input type="text" name="price[]" value="{{ $p['price'] }}" class="form-control" /></td>
              <td><select name="unit[]" class="form-control" class="form-control">
                <option value="EA" {{ $p['unit']=="EA"? 'selected="selected"' : '' }}>EA</option>
                <option value="FT" {{ $p['unit']=="FT"? 'selected="selected"' : '' }}>FT</option>
                <option value="IN" {{ $p['unit']=="IN"? 'selected="selected"' : '' }}>IN</option>
                </select>
              </td>
              <td>
                  <button type="button" class="btn-delete btn btn-default btn-xs"><span class="glyphicon glyphicon-trash"></span></button>
                  <input type="hidden" name="id[]" value="{{ $p['id'] }}" />
                  <input type="hidden" name="delete[]" value="false" />
              </td>
            </tr>
            @endforeach
          @endif
        
          <tr id="add-controls">
            <td><input data-name="qty" type="text" placeholder="Quantity" class="form-control"></td>
            <td><select data-name="style" class="form-control"><option value="cable">Cable</option><option value="hose">Hose</option></select></td>
            <td><select data-name="type" class="form-control">
                <option value="SO">SO</option>
                <option value="W">W</option>
                <option value="G">G</option>
                <option value="GGC">GGC</option>
                <option value="HV">HV</option>
                <option value="air">Air</option>
                <option value="water">Water</option>
                <option value="hydraulic">Hydraulic</option>
                </select>
            </td>
            <td><input data-name="awg" type="text" placeholder="AWG" class="form-control"></td>
            <td><input data-name="cond" type="text" placeholder="Conductors" class="form-control"></td>
            <td><input data-name="volts" type="text" placeholder="Volts" class="form-control"></td>
            <td><input data-name="psi" type="text" placeholder="PSI" class="form-control"></td>
            <td><input data-name="width" type="text" placeholder="ID/Width" class="form-control"></td>
            <td><input data-name="thickness" type="text" placeholder="OD/Thickness" class="form-control"></td>
            <td><input data-name="bend" type="text" placeholder="Bend Radius" class="form-control"></td>
            <td><input data-name="weight" type="text" placeholder="Weight" class="form-control"></td>
            <td><input data-name="cost" type="text" placeholder="$/Ft" class="form-control"></td>
            <td><input data-name="pn" type="text" placeholder="PN" class="form-control"></td>
            <td><button type="button" class="btn btn-success btn-xs add-btn">Add item</button></td>
          </tr>
        </tbody>
      </table>
    </div>

      <!-- This table is redundant. We only need one table. 
      <table id="hoses-table" class="table table-striped table-responsive">

        <thead>
          <tr>
            <th>Quantity</th>
            <th>Style</th>
            <th>Type</th>
            <th>AWG</th>
            <th>Cond</th>
            <th>Volts</th>
            <th>PSI</th>
            <th>ID/Width</th>
            <th>OD/Thickness</th>
            <th>Bend Radius</th>
            <th>Weight</th>
            <th>$/Ft</th>
            <th>PN</th>
          </tr>
        </thead>
        <tbody>

          @if (isset($parts))
              @foreach ($parts->toArray() as $p)
              <tr>
                <td><input type="text" name="qty[]" value="{{ $p['quantity'] }}" class="form-control" /></td>
                <td><input type="text" name="part[]" value="{{ $p['number'] }}" class="form-control" /></td>
                <td><input type="text" name="desc[]" value="{{ $p['description'] }}" class="form-control" /></td>
                <td><select name="stk[]" class="form-control" class="form-control">
                    <option value="0" {{ $p['stocked']=="0"? 'selected="selected"' : '' }}>No</option>
                    <option value="1" {{ $p['stocked']=="1"? 'selected="selected"' : '' }}>Yes</option></select>
                </td>
                <td><input type="text" name="price[]" value="{{ $p['price'] }}" class="form-control" /></td>
                <td><select name="unit[]" class="form-control" class="form-control">
                  <option value="EA" {{ $p['unit']=="EA"? 'selected="selected"' : '' }}>EA</option>
                  <option value="FT" {{ $p['unit']=="FT"? 'selected="selected"' : '' }}>FT</option>
                  <option value="IN" {{ $p['unit']=="IN"? 'selected="selected"' : '' }}>IN</option>
                  </select>
                </td>
                <td>
                    <button type="button" class="btn-delete btn btn-default btn-xs"><span class="glyphicon glyphicon-trash"></span></button>
                    <input type="hidden" name="id[]" value="{{ $p['id'] }}" />
                    <input type="hidden" name="delete[]" value="false" />
                </td>
              </tr>
              @endforeach
          @endif

          <tr id="hoses-controls">
            <td><input data-name="qty" type="text" placeholder="Quantity" class="form-control"></td>
            <td><select data-name="style" class="form-control"><option value="cable">Cable</option><option value="hose">Hose</option></select></td>
            <td><select data-name="type" class="form-control">
                <option value="SO">SO</option>
                <option value="W">W</option>
                <option value="G">G</option>
                <option value="GGC">GGC</option>
                <option value="HV">HV</option>
                <option value="air">Air</option>
                <option value="water">Water</option>
                <option value="hydraulic">Hydraulic</option>
                </select>
            </td>
            <td><input data-name="awg" type="text" placeholder="AWG" class="form-control"></td>
            <td><input data-name="cond" type="text" placeholder="Conductors" class="form-control"></td>
            <td><input data-name="volts" type="text" placeholder="Volts" class="form-control"></td>
            <td><input data-name="psi" type="text" placeholder="PSI" class="form-control"></td>
            <td><input data-name="width" type="text" placeholder="ID/Width" class="form-control"></td>
            <td><input data-name="thickness" type="text" placeholder="OD/Thickness" class="form-control"></td>
            <td><input data-name="bend" type="text" placeholder="Bend Radius" class="form-control"></td>
            <td><input data-name="weight" type="text" placeholder="Weight" class="form-control"></td>
            <td><input data-named="cost" type="text" placeholder="$/Ft" class="form-control"></td>
            <td><input data-name="pn" type="text" placeholder="PN" class="form-control"></td>
            <td><button type="button" class="btn btn-success btn-xs add-btn">Add item</button></td>
          </tr>

        </tbody>
      </table>-->


    <div class="tab-pane" id="application">  
      <h3>Application Data</h3>
      <input type="hidden" id="cust-id" name="customer" @if (isset($quote) && $quote->customer()->first() != null) {{ 'value="'.$quote->customer()->first()->id.'"'  }} @endif />
      <div>
          <div class="form-group">
              <label class="col-sm-2 control-label">Active Travel</label>
              <div class="col-sm-3">
                <div class="input-group"><input type="text" name="activetravel" class="form-control" value="5" />
                <span class="input-group-addon">ft</span></div>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-2 control-label">Travel Speed</label>
              <div class="col-sm-3">
                <div class="input-group"><input type="text" name="travelspeed" class="form-control" value="150" />
                <span class="input-group-addon">ft/min</span></div>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-2 control-label">Acceleration</label>
              <div class="col-sm-3">
                <div class="input-group"><input type="text" name="acceleration" class="form-control" value="1.0" />
                <span class="input-group-addon">ft/sec/sec</span></div>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-2 control-label">Applications</label>
              <div class="col-sm-3">
                <select class="form-control" name="application"><option value="standard">Standard</option><option value="opposed">Opposed</option><option value="vertical">Vert. w/ curve @ bottom</option></select>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-2 control-label">Minimum Ambient Temperature</label>
              <div class="col-sm-3">
                <div class="input-group"><input type="text" name="mintemp" class="form-control" value="40" />
                <span class="input-group-addon">F</span></div>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-2 control-label">Maximum Ambient Temperature</label>
              <div class="col-sm-3">
                <div class="input-group"><input type="text" name="mintemp" class="form-control" value="110" />
                <span class="input-group-addon">F</span></div>
              </div>
          </div>

          <div class="form-group">
              <label class="col-sm-2 control-label">Duty Cycles</label>
              <div class="col-sm-3">
                <div class="input-group"><input type="text" name="dutycycles" class="form-control" value="0" />
                <span class="input-group-addon">per year</span></div>
              </div>
          </div>
      </div>
    </div>

   
    <div class="tab-pane" id="search">
      <div>
        <h3>Search Criteria</h3>
      </div>
    </div>
  </div>
    
<!--
    <div class="well">

        <div class="form-group">
            <label class="col-sm-2 control-label">Customer</label>
            <div class="col-sm-1">
              <span id="cust-name">@if (isset($quote) && $quote->customer()->first() != null) {{ $quote->customer()->first()->name  }} @endif</span>
              <a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal" href="{{ url('/customers/select') }}">Select customer</a>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Quote prepared by</label>
            <div class="col-sm-3">
              <input type="text" class="form-control" name="employee" @if (isset($quote)) {{ 'value="'.$quote->employee.'"'  }} @endif />
            </div>
        </div>

        <div class="form-group">
            <label for="notes" class="col-sm-2 control-label">Notes</label>
            <div class="col-sm-3">
              <textarea class="form-control" name="notes">@if(isset($quote)){{$quote->notes}}@endif</textarea>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Parts discount</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="discount1" class="form-control" @if (isset($quote)) {{ 'value="'.$quote->discount1.'"'  }} @endif />
              <span class="input-group-addon">%</span></div>
              <span>with an additional</span>
              <div class="input-group"><input type="text" name="discount2" class="form-control" @if (isset($quote)) {{ 'value="'.$quote->discount2.'"'  }} @endif />
              <span class="input-group-addon">%</span></div>
            </div>
        </div>

        <div class="form-group">
          <div class="col-sm-2">
          </div>
          <div class="col-sm-2">
            <input type="submit" class="btn btn-success"/>
          </div>
        </div>
   </div>
-->


</fieldset>
</form>

@stop

@section('scripts')
<script type="text/javascript">
/* Mark existing rows as deleted if the remove button is clicked */
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

$('.add-btn').on('click', function() {


    var btn = $('<button>').addClass('btn btn-default btn-xs').attr('type', 'button')
    .append($('<span>').addClass('glyphicon glyphicon-trash'))
    .on('click', function() {
        $(this).parent().parent().remove();
    });


    var inputs = [];
    var self = $(this);

    $(this).parent().parent().find($('input, select')).each(function() {
        
        var name = $(this).attr('data-name') + "[]";
        var val = $(this).val();
        var element = $(this).clone(true, true).attr('name', name).val(val);

        if($(this).is('input')) {
          $(this).val('');
        } else {
          $(this)[0].selectedIndex = 0;
        }

        inputs.push(element);
           
    });

    var idInput = $('<input>').attr('name', 'id[]').attr('type', 'hidden').val("-1");
    var delInput = $('<input>').attr('name', 'delete[]').attr('type', 'hidden').val(false);

    var row = $('<tr>');

    $(inputs).each(function() {

      row.append($('<td>').append($(this)));

    });

    row.append($('<td>').append(btn).append(idInput).append(delInput));
    row.insertBefore($(this).parent().parent());

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
    //$(e.target).removeData('bs.modal');
});

</script>
@stop