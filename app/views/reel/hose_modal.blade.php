@extends('layouts.modal')

@section('modal-title')
Select Cable
@stop

@section('modal-content')
<div class="table-responsive">
    <form id="cust-form" method = "post" action = "{{ url('/customers/add') }}" class="form-horizontal">
      <fieldset>
        <h4>Please enter the HOSE information for this item.</h4>
        <div class="form-group">
            <label class="col-sm-2 control-label">Quantity</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="number" name="qty" id = "qty" class="form-control" value="1"/></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Hose Type</label>
            <div class="col-sm-3">
              <div class="input-group">
                <select id="style" class="form-control" onchange="checkType()">
                  <option disabled hidden selected value="singleHose"></option>
                  <option value="Single Hose">Single Hose</option>
                  <option value="Dual Hose (Vinyl)">Dual Hose (Vinyl)</option>
                  <option value="Dual Hose (Braided Steel)">Dual Hose (Braided Steel)</option>
                  <option value="Dual Hose, Other">Dual Hose, Other</option>
                </select>
              </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Hose Contents</label>
            <div class="col-sm-3">
              <div class="input-group">
                <select id="type" class="form-control" onchange="searchForHose()">
                  <option disabled hidden selected value="-1"></option>
                  <option value="Air">Air</option>
                  <option value="Water">Water</option>
                  <option value="Hydraulic">Hydraulic</option>
                  <option value="Other">Other</option>
                </select></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Hose Inside Diameter</label>
            <div class="col-sm-3">
              <div class="input-group">
                <select name="insidediameter" id="insidediameter" class="form-control" onchange="searchForHose()">
                  <option disabled hidden selected value=""></option>
                  <option value="0.188">0.188</option><option value="0.250">0.250</option>
                  <option value="0.375">0.375</option><option value="0.500">0.500</option>
                  <option value="0.625">0.625</option><option value="0.750">0.750</option>
                  <option value="0.875">0.875</option><option value="1.000">1.000</option>
                  <option value="1.125">1.125</option><option value="1.250">1.250</option>
                  <option value="1.375">1.375</option><option value="1.500">1.500</option>
                  <option value="1.625">1.625</option><option value="1.750">1.750</option>
                </select>
                <span class="input-group-addon">inches</span>
              </div>
            </div>
        </div>

        <div class="form-group" id="psiDiv">
            <label class="col-sm-2 control-label">Hose Pressure</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="psi" id="psi" class="form-control" />
              <span class="input-group-addon">PSI</span>
              </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Outside Diameter</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="outsidediameter" id="outsidediameter" class="form-control" />
              <span class="input-group-addon">inches</span></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Bend Radius</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="bendradius" id="minbendradius" class="form-control" />
              <span class="input-group-addon">inches</span></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Hose Weight</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="weight" id="weight" class="form-control" />
              <span class="input-group-addon">lbs/ft</span></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Hose Price</label>
            <div class="col-sm-3">
              <div class="input-group"><input type="text" name="price" id="price" class="form-control" />
              <span class="input-group-addon">per foot</span></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Part Number</label>
            <div class="col-sm-3">
              <div class="input-group"><input disabled type="text" name="partnumber" id="partnumber" class="form-control" value=""/></div>

            </div>
        </div>

        <!-- <div class="form-group">
            <label class="col-sm-2 control-label">Style</label>
            <div class="col-sm-3">
              <div class="input-group"><input disabled type="text" id="style" class="form-control" value=""/></div>
            </div>
        </div> -->
      </fieldset>
    </form>
</div>
<script type="text/javascript">


  $( document ).ready( function(){
  if(existingPackage && cableSet) {
    console.log(packageid);
    setHose();
    //getHose(packageid);
  }
  });

  $(function(){
  $('#cancel').on("click", function () {
    var r = confirm("Are you sure you wish to cancel?");
    if(!r){
    event.stopImmediatePropagation();
    }
    else{
    }
  });
  });

  $('#outsidediameter').on('change', function() {
    $('#minbendradius').val(calcBend($('#outsidediameter').val()));
  });

  function searchForHose()
  {
    var values = {};
    $.each($("form").serializeArray(), function (i, field) {
        values[field.id] = field.value;
    });

    var style = $('#style').val();
    switch(style) {
      case "Single Hose":
        var sendData = $('#insidediameter').val();

        $.getJSON("{{ url('/hoses/get').'/' }}" + sendData, function(data)
        {

          if(data.length > 0)
          {
            console.log(data.length + " row(s) returned.");
            //$('#style').val(data[0].STYLE);
            $('#psi').val(data[0].PSI);
            $('#outsidediameter').val(data[0].OD);
            $('#weight').val(fluidWGTft(type, data[0].ID));
            $('#minbendradius').val(calcBend(data[0].OD));
            $('#partnumber').val(appendGR(data[0].PN));
            $('#price').val(data[0].REEL_PRICE);
          }
          else
          {
            //$('#style').val("");
            $('#psi').val("")
            $('#outsidediameter').val("");
            $('#weight').val("");
            $('#minbendradius').val("");
            $('#partnumber').val("Special Part");
            $('#price').val("");
            console.log("No rows returned.");
          }
        });
        break;
      case "Dual Hose (Vinyl)":
        var id = $('#insidediameter').val();
        switch(id) {
          case "0.25":
            $('#outsidediameter').val(0.498);
            $('#minbendradius').val(calcBend($('#outsidediameter').val()));
            $('#weight').val(0.066);
            $('#price').val(24.30);
            $('#partnumber').val("GR046787xx");
            break;
          case "0.375":
            $('#outsidediameter').val(0.765);
            $('#minbendradius').val(calcBend($('#outsidediameter').val()));
            $('#weight').val(0.148);
            $('#price').val(28.40);
            $('#partnumber').val("GR046788xx");
            break;
          case "0.50":
            $('#outsidediameter').val(0.890);
            $('#minbendradius').val(calcBend($('#outsidediameter').val()));
            $('#weight').val(0.190);
            $('#price').val(36.4);
            $('#partnumber').val("GR046789xx");
            break;
          case "0.75":
            break;
          default:
        }
        break;

      case "Dual Hose (Braided Steel)":
        var id = $('#insidediameter').val();
        switch(id) {
          case "0.25":
            $('#outsidediameter').val(0.690);
            $('#minbendradius').val(calcBend($('#outsidediameter').val()));
            $('#weight').val(0.330);
            $('#price').val("");
            $('#partnumber').val("Special");
            break;
          case "0.375":
            $('#outsidediameter').val(0.840);
            $('#minbendradius').val(calcBend($('#outsidediameter').val()));
            $('#weight').val(0.450);
            $('#price').val("");
            $('#partnumber').val("Special");
            break;
          case "0.50":
            $('#outsidediameter').val(0.970);
            $('#minbendradius').val(calcBend($('#outsidediameter').val()));
            $('#weight').val(0.560);
            $('#price').val("");
            $('#partnumber').val("Special");
            break;
          case "0.75":
            $('#outsidediameter').val(1.25);
            $('#minbendradius').val(calcBend($('#outsidediameter').val()));
            $('#weight').val(0.);
            $('#price').val("");
            $('#partnumber').val("Special");
            break;
          default:
        }
      default:
    }
  }


  function getHose(packageid) {
    var qty;
    var pn;
    var style;
    var type;

    $.getJSON("{{ url('/package/get').'/' }}" + packageid, function(data) {
      console.log("Loading package to edit:");
      qty = data[0].quantity;
      pn = data[0].pn;
      console.log(pn);
      style = data[0].style;
      type = data[0].type;
      $('#qty').val(qty);
      $('#style').val(style);
      $('#type').val(type);
      $('#partnumber').val(appendGR(pn));
      checkType();
      console.log(pn);
      //if(style.indexOf("Dual Hose") != -1)

      $.getJSON("{{ url('package/cable/get').'/' }}" + packageid, function(data) {
        console.log(data);
        if(data.length > 0) {
          if(pn == "Special Part" || style.indexOf("Dual Hose") != -1) {
            $('#psi').val(data[0].psi);
            $('#insidediameter').val(data[0].idiameter);
            $('#outsidediameter').val(data[0].odiameter);
            $('#weight').val(fluidWGTft(type, data[0].idiameter));
            $('#minbendradius').val(calcBend(data[0].odiameter));
            $('#price').val(data[0].reel_price);
          }
          else {
            $('#psi').val(data[0].PSI);
            $('#insidediameter').val(data[0].ID);
            $('#outsidediameter').val(data[0].OD);
            $('#weight').val(fluidWGTft(type, data[0].ID));
            $('#minbendradius').val(calcBend(data[0].OD));
            $('#price').val(data[0].REEL_PRICE);
          }
        }
        else {
          console.log("No rows returned.");
        }
      });
    });
  }

  function setHose() {
    $('#qty').val($('#identifier0').text());
    $('#style').val($('#identifier1').text());
    $('#type').val($('#identifier2').text());
    checkType();
    $('#psi').val($('#identifier6').text());
    $('#insidediameter').val($('#identifier7').text());
    $('#outsidediameter').val($('#identifier8').text());
    $('#minbendradius').val(calcBend($('#identifier8').text()));
    $('#weight').val($('#identifier10').text());
    $('#price').val($('#identifier11').text());
    $('#partnumber').val($('#identifier12').text())
  }

</script>
@stop

@section('modal-footer')
  <button type="submit" class="btn btn-default" data-dismiss="modal" id="submitItem" >Submit</button>
  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
@stop
