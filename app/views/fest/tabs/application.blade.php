<h3>Application Data</h3>
<fieldset>
<input type="hidden" id="cust-id" id="customer" @if (isset($quote) && $quote->customer()->first() != null) {{ 'value="'.$quote->customer()->first()->id.'"'  }} @endif />
<div>


<div class="form-group">
    <label class="col-sm-2 control-label">Active Travel</label>
    <div class="col-sm-3">
      <div class="input-group">
        <input type="number" id="activetravelft" name="activetravelft" class="form-control" value="10" />

        <span class="input-group-addon">ft</span>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="input-group">
        <input type="number" id="activetravelin" name="activetravelin" class="form-control" value="0" />

        <span class="input-group-addon">in</span>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 control-label">Loop Depth</label>
    <div class="col-sm-3">
      <div class="input-group">
        <input type="number" id="loopdepthft" name="loopdepthft" class="form-control" value="5" />

        <span class="input-group-addon">ft</span>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="input-group">
        <input type="number" id="loopdepthin" name="loopdepthin" class="form-control" value="0" />

        <span class="input-group-addon">in</span>
      </div>
    </div>
  </div>

  <div class="form-group">

    <label class="col-sm-2 control-label">Optimize Loop Depth</label>

      <input type="checkbox"/>


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
    <div class="input-group"><input type="number" id="acceleration" name="accel" class="form-control col-sm-3" value=".5" step="any"/>
    <span class="input-group-addon">ft/sec</span></div>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-2 control-label">Ambient Temperature:</label>

<div class="form-group">

  <div class="col-sm-3">
    <div class="input-group"><input type="number" id="mintemp" name="mintemp" class="form-control" value="40" />
    <span class="input-group-addon">F</span></div>
  </div>
  <label class="col-sm-1 control-label">Min</label>

  <div class="col-sm-3">
    <div class="input-group"><input type="number" id="maxtemp" name="maxtemp" class="form-control" value="110" />
      <span class="input-group-addon">F</span></div>
  </div>
  <label class="col-sm-1 control-label">Max</label>
</div>
</div>
<div class="form-group">

</div>


<div class="form-group">
  <label class="col-sm-2 control-label">Duty Cycles</label>
  <div class="col-sm-3">
    <div class="input-group"><input type="number" name="ccf" class="form-control" value="0" />
    <span class="input-group-addon">/year</span></div>
  </div>
</div>
</div>
</fieldset>
<script type="text/javascript">


</script>
