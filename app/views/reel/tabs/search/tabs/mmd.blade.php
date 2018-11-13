<div class="container marginleft">
  <div class="col-lg-3">
    <h3>MMD Reels to consider</h3>
    <div id='mmd-checkboxes' class="marginleft">
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="mmd-checkboxes[]" value="none" checked>None</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="mmd-checkboxes[]" value="any">Any</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="mmd-checkboxes[]" value="21">MMD21</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="mmd-checkboxes[]" value="24">MMD24</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="mmd-checkboxes[]" value="28">MMD28</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="mmd-checkboxes[]" value="32">MMD32</label>
        </div>
      </div>
    </div>
  </div>
  <div id='mmd-inputs' class="col-lg-4">
    <h3>MMD Reel Model Parameters</h3>
    <div class="marginleft">
      <div class="form-group">
        <label class="col-md-5 control-label">Spring Size</label>
        <div class="col-sm-4">
          <select name="mmd-springsize" class="form-control">
            <option value="all">All</option>
            <option value="1001">1001</option>
            <option value="1002">1002</option>
            <option value="1003">1003</option>
            <option value="1004">1004</option>
            <option value="100X">100X</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-5 control-label">Collector Code</label>
        <div class="col-sm-3">
          <div class="input-group"><input type="text" name="mmd-collectorcode" id="mmd-collectorcode" class="form-control" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Drum Diameter Range Min.</label>
        <div class="col-md-3">
          <div class="input-group">
            <input type="text" name="mmd-drummin" class="form-control" value="8" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Drum Diameter Range Max.</label>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" id="mmd-drummax" name="mmd-drummax" class="form-control" value="28" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Gear Ratio</label>
        <div class="col-sm-5">
          <select class="form-control" name="mmd-gearratio">
            <option value="all" class="active">All</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Pretension Turn Range Min.</label>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" name="mmd-pretensmin" class="form-control" value="1" />
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-5 control-label">Pretension Turn Range Max.</label>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" name="mmd-pretensmax" class="form-control" value="6"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$("#mmd-inputs select[name='mmd-springsize']").change(function() {
  showValidGearMMD();
});

getValidSpringMMD();

$('#mmd-checkboxes :checkbox').change(function() {
  drumMax = $("#mmd-inputs input[name='mmd-drummax']");

  if(this.value == 'none' || this.value == 'any') {
    var value = this.value;

    drumMax.val(28);

    $('#mmd-checkboxes :checkbox').each(function() {
      if(value != this.value) {
        $(this).attr('checked', false);

      }
    });
  }
  else {
    var highest = null;

    $('#mmd-checkboxes :checkbox').each(function() {
      if(this.checked) {
        highest = this;
      }
    });

    $("#mmd-checkboxes :checkbox[value='any']").attr('checked', false);
    $("#mmd-checkboxes :checkbox[value='none']").attr('checked', false);


    if(highest === null) {
      drumMax.val('');
    }
    else {
      switch(highest.value) {
        case '21':
          drumMax.val(17);
          break;
        case '24':
          drumMax.val(20);
          break;
        case '28':
          drumMax.val(24);
          break;
        case '32':
        default:
          drumMax.val(28);
          break;
      }
    }
  }
  getValidSpringMMD();
  showValidGearMMD();
});
</script>
