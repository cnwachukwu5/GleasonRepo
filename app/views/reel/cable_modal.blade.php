@extends('layouts.modal')

@section('modal-title')
Select Cable
@stop

@section('modal-content')

<div class="table-responsive">
    <form id="cust-form" method = "post" action = "{{ url('/cable/add') }}" class="form-horizontal">
      <fieldset>
      <h3>Please enter the CABLE information for this item.</h3>
        <div class="form-group">
          <label class="col-sm-2 control-label">Quantity</label>
          <div class="col-sm-3">
            <div class="input-group"><input type="number" name="qty" id = "qty" class="form-control" value="1"/></div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Type</label>
          <div class="col-sm-3">
            <div class="input-group">
              <select name="type" id="type" class="form-control" onchange="selectedHV(this); searchForCable();">
                <option hidden disabled selected></option>
                <option value="SO">SO</option>
                <option value="W">W</option>
                <option value="G">G</option>
                <option value="GGC">GGC</option>
                <option value="HV">HV</option>
                <option value="OTHER">OTHER</option>
              </select>
            </div>
          </div>
          <div id="typeDesc" style="visibility: hidden">
            <label class="col-sm-2 control-label" >Description</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="typeDescription" id = "typeDescription" class="form-control" value=""/></div>
            </div>
          </div>
          </div>


        <div class="form-group">
          <label class="col-sm-2 control-label">AWG</label>
          <div class="col-sm-3">
            <div class="input-group">
              <select name="AWG" id = "awg" class="form-control" onchange="searchForCable();">
                <option hidden disabled selected></option>
                <option value="1">1</option><option value="2">2</option>
                <option value="3">3</option><option value="4">4</option>
                <option value="6">6</option><option value="8">8</option>
                <option value="10">10</option><option value="12">12</option>
                <option value="14">14</option><option value="16">16</option>
                <option value="18">18</option><option value="1/0">1/0</option>
                <option value="2/0">2/0</option>
              </select></div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Conductors (1-99)</label>
          <div class="col-sm-3">
            <div class="input-group">
              <input type="number" name="conductors" id="conductors" class="form-control" onchange="checkCond(this); searchForCable();" onkeypress="return isNumberKey(event)"></input>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Volts</label>
          <div class="col-sm-3">
            <div class="input-group">
              <select name="volts" class="form-control" id="volts">
                <option hidden disabled selected></option>
                <option id="removeHV" value="600">600</option>
                <option value="5000">5000</option>
                <option value="8000">8000</option>
                <option value="15000">15000</option>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Outside Diameter</label>
          <div class="col-sm-3">
            <div class="input-group"><input type="text" name="outsidediameter"  id="outsidediameter" class="form-control" />
            <span class="input-group-addon">inches</span></div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Min. Bend Radius</label>
          <div class="col-sm-3">
            <div class="input-group"><input  type="text" name="minbendradius" id="minbendradius" class="form-control" />
            <span class="input-group-addon">inches</span></div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Weight</label>
          <div class="col-sm-3">
            <div class="input-group"><input type="text" name="weight" id="weight" class="form-control" />
            <span class="input-group-addon">lbs/ft</span></div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Price</label>
          <div class="col-sm-3">
            <div class="input-group"><input type="text" name="price" id="price" class="form-control" />
            <span class="input-group-addon">per foot</span></div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Part Number</label>
          <div class="col-sm-3">
            <div class="input-group"><input disabled type="text" name="partnumber" id="partnumber" class="form-control" value="Special Part"/></div>
          </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Style</label>
            <div class="col-sm-3">
              <div class="input-group"><input disabled hidden type="text" id="style" class="form-control" value="Cable"/></div>
            </div>
        </div>
      </fieldset>
    </form>

</div>

<script type="text/javascript">
$('#cancel').on('click', function() {

  cancelledPackage = true;

});
</script>
@stop

@section('modal-footer')

  <button type="submit" class="btn btn-default" data-dismiss="modal" id="submitItem" >Submit</button>
  <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">Cancel</button>


  <script type="text/javascript">
  $( document ).ready( function(){

    if(existingPackage && cableSet) {
      //getCable(pnx, qtyx);
      setCable();
    }
  });

  $(function(){
  $('#cancel').on("click", function () {
    var r = confirm("Are you sure you wish to cancel?");
    if(!r){
      event.stopImmediatePropagation();
    }
  });
  });

  $('#outsidediameter').on('change', function() {
    $('#minbendradius').val(calcBend($('#outsidediameter').val()));
  });

  $('#type').on('change', function(){
      if(this.value === 'OTHER'){
          $('#typeDesc').css('visibility', 'visible');
      }else{
          $('#typeDesc').css('visibility', 'hidden');
      }
  });

//  $('#typeDescription').on('input', function(){
//      alert(this.value);
//  });

  function searchForCable() {
    var values = {};
    $.each($("form").serializeArray(), function (i, field) {
        values[field.name] = field.value;
    });

    type = values["type"];
    if(type === "SO") type = "S";
    else if(type === "GGC") type = "C";
    else if(type === "HV") type = "H";


    var sendData = type + '/' + values["AWG"] + '/' + values["conductors"];
    //alert(sendData);
    $.getJSON("{{ url('/cables/get').'/' }}" + sendData, function(data) {
      if(data.length > 0)
      {
        //$('#style').val(data[0].STYLE);
        $('#outsidediameter').val(data[0].OD);
        $('#weight').val(data[0].WGT);
        $('#volts').val(data[0].VOLTS);
        $('#minbendradius').val(calcBend(data[0].OD));
        $('#partnumber').val(appendGR(data[0].PN));
        $('#price').val(data[0].REEL_PRICE);
      }
      else
      {
        //$('#style').val("R");
        $('#outsidediameter').val("");
        $('#weight').val("");
        $('#volts').val("0");
        $('#minbendradius').val("");
        $('#partnumber').val("Special Part");
        $('#price').val("");
        console.log("No rows returned.");
      }
     });
  }

  function getCable(packageid) {
    var qty, pn, style, type;
    $.getJSON("{{ url('/package/get').'/' }}" + packageid, function(data) {
      //console.log(data);
      qty = data[0].quantity;
      pn = data[0].pn;
      style = data[0].style;
      type = data[0].type;
    });

    console.log(pn);

    $.getJSON("{{ url('package/cable/get').'/' }}" + packageid, function(data) {
      if(data.length > 0) {
        if(pn == "Special Part") {
          $('#qty').val(qty);
          $('#style').val(style);
          $('#type').val(type);
          $('#awg').val(data[0].awg);
          $('#conductors').val(data[0].cond)
          $('#outsidediameter').val(data[0].odiameter);
          $('#weight').val(data[0].wgt);
          $('#volts').val(data[0].volts);
          $('#minbendradius').val(data[0].mbr);
          $('#partnumber').val(appendGR(pn));
          $('#price').val(data[0].reel_price);
        }
        else {
          $('#qty').val(qty);
          $('#style').val(style);
          $('#type').val(type);
          $('#awg').val(data[0].AWG);
          $('#conductors').val(data[0].COND)
          $('#outsidediameter').val(data[0].OD);
          $('#weight').val(data[0].WGT);
          $('#volts').val(data[0].VOLTS);
          $('#minbendradius').val(calcBend(data[0].OD));
          $('#partnumber').val(appendGR(pn));
          $('#price').val(data[0].REEL_PRICE);
        }

      }
      else {
        console.log("No rows returned.");
      }
    });
  }

  function setCable() {
    $('#qty').val($('#identifier0').text());
    $('#style').val($('#identifier1').text());
    $('#type').val($('#identifier2').text());
    $('#awg').val($('#identifier3').text());
    $('#conductors').val($('#identifier4').text());
    $('#volts').val($('#identifier5').text());
    $('#outsidediameter').val($('#identifier8').text());
    $('#minbendradius').val(calcBend($('#identifier8').text()));
    $('#weight').val($('#identifier10').text());
    $('#price').val($('#identifier11').text());
    $('#partnumber').val($('#identifier12').text())
  }

  </script>
@stop

@section('scripts')


@stop
