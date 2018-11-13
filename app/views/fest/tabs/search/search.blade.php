<div id='searchcriteria'>
  <div>
    <h3>Search Criteria</h3>



    <div class="well">
      <div class="form-group radio-inline">
        Selecting "any" for models will return the <input type="number" maxlength="4" size="4" id="nummodels" name="nummodels" value="1" /> most cost effective festoon systems.
      </div>
    </div>
    <ul id="tabs-cable" class="nav nav-tabs" role="tablist">
      <li id="tab-crail" class="active"><a href="#crail" role="tab" data-toggle="tab">C-Rail</a></li>
      <li id="tab-ibeam"><a href="#ibeam" role="tab" data-toggle="tab">I-Beam</a></li>
      <li id="tab-pdq"><a href="#pdq" role="tab" data-toggle="tab">PDQ</a></li>
    </ul>
  </div>



  <div class="row tab-content">
    <div class="tab-pane active" id="crail">
      @include('fest.tabs.search.tabs.crail')
    </div>
    <div class="tab-pane" id="ibeam">
      @include('fest.tabs.search.tabs.ibeam')
    </div>
    <div class="tab-pane" id="pdq">
      @include('fest.tabs.search.tabs.pdq')
    </div>



    <div class="col-sm-4">
      <h3>Trolley Information</h3>
      <div>
        <label><input type="radio" name="comp" id="comp"/> Let computer select Trolley</label><br/>
        <label><input type="radio" name="comp" id="comp"/> Use parameters entered below</label>
      </div>
      <hr class="divider">
      <div class="form-group">
        <label class="control-label">Min. Window Height</label>
        <div>
          <div class="input-group">
            <input type="number" id="minwindow-h" name="minwindow-h" class="form-control" value="0" />

            <span class="input-group-addon">in</span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label">Min. Window Width</label>
        <div>
          <div class="input-group">
            <input type="number" id="minwindow-w" name="minwindow-w" class="form-control" value="0" />

            <span class="input-group-addon">in</span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label">Min. Saddle Diameter</label>
        <div>
          <div class="input-group">
            <input type="number" id="minSaddleD" name="minSaddleD" class="form-control" value="0" />

            <span class="input-group-addon">in</span>
          </div>
        </div>
      </div>


      <h3>Optimize On:</h3>
      <div class="btn-group row" data-toggle="buttons">
        <label class="btn btn-default **active**">
          <input type="radio" name="price" id="price" value="price" checked>
          Price </label>
        <label class="btn btn-default">
          <input type="radio" name="length" id="length" value="length">
          Length </label>
        <label class="btn btn-default">
          <input type="radio" name="width" id="width" value="width">
          Width </label>
      </div>

    </div>

  </div>






</div>
<div id='cablenotselected'>
  <h3>No cable/hose was selected!</h3>
</div>

<script type="text/javascript">
  $('#tabs-cable a').click(function (e) {

      $('.nav-tabs > .active').next('li').find('a').trigger('click');


  });




//$( document ).ready(function(){
//
//
//
//
//  $('#cablenotselected').show();
//  $('#searchcriteria').hide();
//
//  //changeTabs();
//  $( "#applicationSelect" ).change(function() {
//    changeTabs();
//  });
//
//  $("input:radio[name='anyornone']").change(function() {
//
//    $(":checkbox").attr('checked', false);
//    if($(this).val() == 'search') {
//      console.log('search');
//      $(":checkbox[value='any']").click();
//    }
//    else {
//      console.log('clear');
//      $(":checkbox[value='none']").click();
//    }
//  });
//});
//
//$('.nav li').on('click', function(e) {
//  if ($(this).hasClass('disabled')) {
//    e.preventDefault();
//    return false;
//  }
//});
//
//$('#none').click(function(event) {  //on click
//  $('.col-md-3 input').each(function() { //loop through each checkbox
//    this.checked = false;
//  });
//});
//
//$('#any').click(function(event) {  //on click
//  $('.col-md-3 input').each(function() { //loop through each checkbox
//    this.checked = true;
//  });
//});
//
//$( ".col-md-3 input" ).on( "click", function() {
//  var x = $( "input:checked" ).val();
//  var Sselected = [];
//  var MMDselected = [];
//  var SMselected = [];
//  $('#S-checkbox input:checked').each(function() {
//    Sselected.push($(this).attr('value'));
//  });
//
//  $('#MMD-checkbox input:checked').each(function() {
//    MMDselected.push($(this).attr('value'));
//  });
//
//  $('#SM-checkbox input:checked').each(function() {
//    SMselected.push($(this).attr('value'));
//  });
//  len = Sselected.length;
//  if(Sselected[0]){
//  alert(Sselected);
//  if(Sselected[len-1] == "Any" || Sselected[len-1] == "s32" || Sselected[len-1] == "None"){
//    $('#drumMaxS').val(28);
//  }
//  if(Sselected[len-1] == "s14"){$('#drumMax').val(10);}
//  if(Sselected[len-1] == "s16"){$('#drumMax').val(12);}
//  if(Sselected[len-1] == "s18"){$('#drumMax').val(14);}
//  if(Sselected[len-1] == "s21"){$('#drumMax').val(17);}
//  if(Sselected[len-1] == "s24"){$('#drumMax').val(20);}
//  if(Sselected[len-1] == "s28"){$('#drumMax').val(24);}
//  }
//  if(MMDselected[0]){
//  alert(MMDselected);
//  if(MMDselected[len-1] == "Any" || MMDselected[len-1] == "None"){$('#drumMaxMMD').val(28);
//  $('.col-md-3 input').attr('checked', false);
//  }
//  if(MMDselected[len-1] == "mmd21"){$('#drumMaxMMD').val(10);}
//  if(MMDselected[len-1] == "mmd24"){$('#drumMaxMMD').val(12);}
//  if(MMDselected[len-1] == "mmd28"){$('#drumMaxMMD').val(14);}
//  if(MMDselected[len-1] == "mmd32"){$('#drumMaxMMD').val(28);}
//  }
//
//});
</script>
