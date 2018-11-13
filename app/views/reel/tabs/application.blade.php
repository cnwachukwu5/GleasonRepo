 <h3>Application Data</h3>
<fieldset>
<input type="hidden" id="cust-id" id="customer" @if (isset($quote) && $quote->customer()->first() != null) {{ 'value="'.$quote->customer()->first()->id.'"'  }} @endif />
<div>
<div class="form-group">
  <label class="col-sm-2 control-label">Application</label>
  <div class="col-sm-3">
    <select id="applicationSelect" name="appl" class="form-control" ><option value="lift">Lift</option><option value="stretch">Stretch</option><option value="retrieve">Retrieve</option><option value="hand">Hand Pull</option></select>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Active Travel</label>
  <div class="col-sm-3">
    <div class="input-group">
      <input type="number" id="activetravel" name="activetravel" class="form-control" value="5" />
      <span class="input-group-addon">ft</span>
    </div>
  </div>
</div>

<div class="form-group">
  <label id="changinglabel" class="col-sm-2 control-label">Pendant Weight</label>
  <div class="col-sm-3">
    <div id="changinginput" class="input-group">
      <input  type="number" name="pendantweight" class="form-control" value="0" />
      <span class="input-group-addon">lbs</span>
    </div>
    <!-- <div id="cablesag" class="input-group" style="display: none;">
      <input  type="number" name="cablesag" class="form-control" value="1" />
      <span class="input-group-addon">%</span>
    </div>
    <div id="centerline" class="input-group" style="display: none;">
      <input type="number" name="centerline" class="form-control" value="3" />
      <span class="input-group-addon">ft</span>
    </div> -->
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Travel Speed</label>
  <div class="col-sm-3">
    <div class="input-group"><input type="number" id="travelspeed" name="travelspeed" class="form-control" value="150" />
    <span class="input-group-addon">ft/min</span></div>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Acceleration</label>
  <div class="col-sm-3">
    <div class="input-group"><input type="number" id="acceleration" name="accel" class="form-control" value=".5" step="any"/>
    <span class="input-group-addon">ft/sec/sec</span></div>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Ambient Temperature:</label>
</div>
<div class="form-group">
  <label class="col-sm-2 control-label">Min</label>
  <div class="col-sm-3">
    <div class="input-group"><input type="number" id="mintemp" name="mintemp" class="form-control" value="40" />
    <span class="input-group-addon">F</span></div>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Max</label>
  <div class="col-sm-3">
    <div class="input-group"><input type="number" id="maxtemp" name="maxtemp" class="form-control" value="110" />
    <span class="input-group-addon">F</span></div>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Spring Turns To Use</label>
  <div class="col-sm-3">
    <div class="input-group"><input type="number" id="springturns" name="springturns" class="form-control" value="0" />
    <span class="input-group-addon">%</span></div>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Dead Wraps</label>
  <div class="col-sm-3">
    <input type="number" id="deadwraps" name="deadwraps" class="form-control" value="1" />
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Cable Clearance Factor</label>
  <div class="col-sm-3">
    <div class="input-group"><input type="number" name="ccf" class="form-control" value="0" />
    <span class="input-group-addon">%</span></div>
  </div>
</div>
</div>
</fieldset>
<script type="text/javascript">

$( document ).ready(function() {
  $("#applicationSelect").change(function() {

    // $('#pendantweight').hide();
    // $('#cablesag').hide();
    // $('#centerline').hide();

    if($("#applicationSelect").val() == "lift")
    {
      $("#changinglabel").text("Pendant Weight");
      $('#changinginput span').text('kg');
      // $('#pendantweight').show().find('input').val(5);
      $('#changinginput').find('input').attr('name', 'pendantweight').val(5);
      $("#acceleration").val(0.5);
    }
    else if($("#applicationSelect").val() == "stretch")
    {
      $("#changinglabel").text("Cable Sag");
      $('#changinginput').find('input').attr('name', 'cablesag');
      $('#changinginput span').text('%');
      $("#acceleration").val(0.75);
    }
    else if($("#applicationSelect").val() == "retrieve")
    {
      $("#changinglabel").text("Height to Centerline");
      // $('#centerline').show().find('input').val(3);
      $('#changinginput').find('input').attr('name', 'centerline').val(3);
      $('#changinginput span').text('ft');
      $("#acceleration").val(1.0);
    }
    else if($('#applicationSelect').val() == 'hand')
    {
      $("#changinglabel").text("Height to Centerline");
      // $('#centerline').show().find('input').val(1);
      $('#changinginput').find('input').attr('name', 'centerline').val(1);
      $('#changinginput span').text('ft');
      $("#acceleration").val(1.0);
    }
    else if($('#applicationSelect').val() == 'magnet') {
      $("#changinglabel").text("Pendant Weight");
      // $('#pendantweight').show().find('input').val(5);
      $('#changinginput').find('input').attr('name', 'pendantweight').val(0);
      $('#changinginput span').text('kg');
      $("#acceleration").val(0.5);
    }

  });
});

</script>
