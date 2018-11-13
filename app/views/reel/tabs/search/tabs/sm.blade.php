<div class="container marginleft">
  <div class="col-lg-3">
    <h3>SM Reels to consider</h3>
    <div id='sm-checkboxes' class="marginleft">
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="sm-checkboxes[]" value="none" checked>None</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="sm-checkboxes[]" value="any">Any</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="sm-checkboxes[]" value="21">SM21</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="sm-checkboxes[]" value="24">SM24</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="sm-checkboxes[]" value="28">SM28</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="sm-checkboxes[]" value="32">SM32</label>
        </div>
      </div>
    </div>
  </div>
  <div id='sm-inputs' class="col-lg-4">
    <h3>SM Reel Model Parameters</h3>
    <div class="marginleft">
      <div class="form-group">
        <label class="col-md-5 control-label">Spring Size</label>
        <div class="col-sm-4">
          <select name="sm-springsize" class="form-control">
            <option value="all">All</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-5 control-label">Collector Code</label>
        <div class="col-sm-3">
          <div class="input-group"><input type="text" name="sm-collectorcode" id="sm-collectorcode" class="form-control" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Drum Diameter Range Min.</label>
        <div class="col-md-3">
          <div class="input-group">
            <input type="text" name="sm-drummin" class="form-control" value="8" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Drum Diameter Range Max.</label>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" name="sm-drummax" class="form-control" value="28" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Gear Ratio</label>
        <div class="col-sm-5">
          <select class="form-control" name="sm-gearratio">
            <option value="all" class="active">All</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Pretension Turn Range Min.</label>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" name="sm-pretensmin" class="form-control" value="1" />
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-5 control-label">Pretension Turn Range Max.</label>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" name="sm-pretensmax" class="form-control" value="6"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$("#sm-inputs select[name='sm-springsize']").change(function() {
  showValidGearSM();
});

getValidSpringSM();

$('#sm-checkboxes :checkbox').change(function() {
  drumMax = $("#sm-inputs input[name='sm-drummax']");
  if(this.value == 'none' || this.value == 'any') {
    var value = this.value;

    drumMax.val(28);

    $('#sm-checkboxes :checkbox').each(function() {
      if(value != this.value) {
        $(this).attr('checked', false);
      }
    });
  }
  else {
    var highest = null;
    $('#sm-checkboxes :checkbox').each(function() {
      if(this.checked) {
        highest = this;
      }
    });

    $("#sm-checkboxes :checkbox[value='any']").attr('checked', false);
    $("#sm-checkboxes :checkbox[value='none']").attr('checked', false);


    if(highest == null) {
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
  getValidSpringSM();
  showValidGearSM();
});
</script>