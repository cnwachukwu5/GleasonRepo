<div class="container marginleft">
  <div class="col-lg-3">
    <h4>Pendant Reels to consider</h4>
    <div id='p-checkboxes' class="marginleft">
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="p-checkboxes[]" value="none" checked>None</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="p-checkboxes[]" value="any">Any</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="p-checkboxes[]" value="14">P14</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="p-checkboxes[]" value="16">P16</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="p-checkboxes[]" value="18">P18</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="p-checkboxes[]" value="21">P21</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="p-checkboxes[]" value="24">P24</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="p-checkboxes[]" value="28">P28</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="p-checkboxes[]" value="32">P32</label>
        </div>
      </div>
    </div>
  </div>
  <div id='p-inputs' class="col-lg-4">
    <h4>Pendant Reel Model Parameters</h4>
    <div class="marginleft">
      <div class="form-group">
        <label class="col-md-5 control-label">Motor Size</label>
        <div class="col-sm-4">
          <select name="p-motorsize" class="form-control">
            <option value="all">All</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="75">75</option>
            <option value="150">150</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-5 control-label">Collector Code</label>
        <div class="col-sm-3">
          <div class="input-group"><input type="text" name="p-collectorcode" id="p-collectorcode" class="form-control" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Drum Diameter Range Min.</label>
        <div class="col-md-3">
          <div class="input-group">
            <input type="text" name="p-drummin" class="form-control" value="8" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Drum Diameter Range Max.</label>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" name="p-drummax" id="p-drummax" class="form-control" value="28" />
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>

$('#p-checkboxes :checkbox').change(function() {
  if(this.value == 'none' || this.value == 'any') {
    var value = this.value;
      $("#p-drummax").val(28);

    $('#p-checkboxes :checkbox').each(function() {
      if(value != this.value) {
        $(this).attr('checked', false);

      }
    });
  }
  else {
    var highest = null;
    $('#p-checkboxes :checkbox').each(function() {
      if(this.checked) {
        highest = this;
      }
    });

    $("#p-checkboxes :checkbox[value='any']").attr('checked', false);
    $("#p-checkboxes :checkbox[value='none']").attr('checked', false);


    if(highest == null) {
        $("#p-drummax").val('');
    }
    else {
      switch(highest.value) {
        case '14':
            $("#p-drummax").val(10);
          break;
        case '16':
            $("#p-drummax").val(12);
          break;
        case '18':
            $("#p-drummax").val(14);
          break;
        case '21':
            $("#p-drummax").val(17);
          break;
        case '24':
            $("#p-drummax").val(20);
          break;
        case '28':
            $("#p-drummax").val(24);
          break;
        case '32':
        default:
            $("#p-drummax").val(28);
          break;

      }
    }
  }
});

</script>
