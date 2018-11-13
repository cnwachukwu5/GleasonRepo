<script>

//    function populateSelectBox(selectbox, dataArray) {
//        dataArray.forEach(function (data) {
//            selectbox.append("<option>" + data + "</option>");
//        });
//    };




</script>
<h3>
    SHO Reels To Consider:
</h3>
    <div id='sho-checkboxes' class="marginleft">
        <div class="form-group">
                <div class="checkbox">
                    <input type="radio" name="sho-checkboxes[]" value="none"><label for="sho-reels-none">None</label>
                </div>
        </div>

        <div class="form-group">
                <div class="checkbox">
                    <input type="radio" name="sho-checkboxes[]" value="any"><label for="sho-reels-any">Any</label>
                </div>
        </div>
    </div>

<h3>
    SHO Reels Model Parameters:
</h3>


<div class="form-group">
        <label class="col-sm-2 control-label">Spooling Method</label>
        <div class="col-sm-3">
          <select class="form-control" name="sho-reels-spooling" onchange="switchShoReel()" id="shoReelSpooling">
            <option value="random">Random wrap</option>
            <option value="monospiral">Monospiral</option>
          </select>
        </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">Spring Size</label>
    <div class="col-sm-3">
      <select class="form-control" name="sho-reels-spring-size">
      	<option value="all">All</option>
      	<option value="801">801</option>
      	<option value="802">802</option>
      	<option value="803">803</option>
      	<option value="804">804</option>
      	<option value="80X">80X</option>
          <option value="1001">1001</option>
          <option value="1002">1002</option>
          <option value="1003">1003</option>
          <option value="1004">1004</option>
          <option value="100X">100X</option>
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Spool Width</label>
    <div class="col-sm-3">
      <select class="form-control" name="sho-reels-spool-width" id="sho-reels-spool-width">
          {{--<option value="7">7</option>--}}
          {{--<option value="4">4</option>--}}
          {{--<option value="all" selected="selected">all</option>--}}
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Spool Diameter</label>
    <div class="col-sm-3">
      <select class="form-control" name="sho-reels-spool-diameter">
          <option value="all">all</option>
        <?php for($i = 30; $i <= 72; $i+=6 ) echo "<option value=\"$i\">$i</option>";  ?>
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Collector Code</label>
    <div class="col-sm-3">
      <div class="input-group"><input type="text" name="sho-reels-code" id="sho-reels-code" class="form-control" value="212" /></div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Min. Drum Diameter</label>
    <div class="col-sm-3">
      <div class="input-group"><input type="text" id="sho-reels-min-range" name="sho-reels-min-range" class="form-control" value="14" /></div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Max Drum Diameter</label>
    <div class="col-sm-3">
      <div class="input-group"><input type="text" id="sho-reels-max-range" name="sho-reels-max-range" class="form-control" value="36" /></div>
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">Chain Ratio code</label>
    <div class="col-sm-3">
      <select class="form-control" name="sho-reels-chain">
          <option value="all">all</option>
        <option value="aa">AA - (gr: 3.0)</option>
        <option value="ab">AB - (gr: 2.5)</option>
        <option value="ac">AC - (gr: 2.0)</option>
        <option value="ad">AD - (gr: 1.5)</option>
      	<option value="ae">AE - (gr: 1.5)</option>
      </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Min. Pretension Turn</label>
    <div class="col-sm-3">
      <div class="input-group"><input type="text" name="sho-reels-min-turn" class="form-control" value="1" /></div>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Max Pretension Turn</label>
    <div class="col-sm-3">
      <div class="input-group"><input type="text" name="sho-reels-max-turn" class="form-control" value="6" /></div>
    </div>
</div>
