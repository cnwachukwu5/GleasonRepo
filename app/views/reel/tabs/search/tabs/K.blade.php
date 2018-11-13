<div class="container marginleft">
  <div class="col-lg-3">
    <h3>K Reels to consider</h3>
    <div id='k-checkboxes' class="marginleft">
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="k-checkboxes[]" value="none" checked>None</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="k-checkboxes[]" value="any">Any</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="k-checkboxes[]" value="18">K18</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="k-checkboxes[]" value="21">K21</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="k-checkboxes[]" value="24">K24</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="k-checkboxes[]" value="28">K28</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="k-checkboxes[]" value="32">K32</label>
        </div>
      </div>
    </div>
  </div>
  <div id='k-inputs' class="col-lg-4">
    <h3>K Reel Model Parameters</h3>
    <div class="marginleft">
      <div class="form-group">
        <label class="col-md-5 control-label">Spring Size</label>
        <div class="col-sm-4">
          <select name="k-springsize" class="form-control">
            <option value="all">All</option>
            <option value="351">351</option>
            <option value="601">601</option>
            <option value="621">621</option>
            <option value="622">622</option>
            <option value="623">623</option>
            <option value="624">624</option>
            <option value="62X">62X</option>
            <option value="751">751</option>
            <option value="752">752</option>
            <option value="753">753</option>
            <option value="754">754</option>
            <option value="75X">75X</option>
            <option value="801">801</option>
            <option value="802">802</option>
            <option value="803">803</option>
            <option value="804">804</option>
            <option value="80X">80X</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-5 control-label">Hose Code</label>
        <div class="col-sm-3">
          <div class="input-group"><input type="text" name="k-collectorcode" id="k-collectorcode" class="form-control" value="" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Pretension Turn Range Min.</label>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" name="k-pretensmin" class="form-control" value="1" />
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-5 control-label">Pretension Turn Range Max.</label>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" id="k-pretensmax" name="k-pretensmax" class="form-control" value="10"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    $('#k-checkboxes :checkbox').change(function() {

        if(this.value == 'none' || this.value == 'any') {
            var value = this.value;

            $('#k-checkboxes :checkbox').each(function() {
                if(value != this.value) {
                    $(this).attr('checked', false);
                }
            });
        }else{
            $("#k-checkboxes :checkbox[value='any']").attr('checked', false);
            $("#k-checkboxes :checkbox[value='none']").attr('checked', false);
        }
    });
</script>
