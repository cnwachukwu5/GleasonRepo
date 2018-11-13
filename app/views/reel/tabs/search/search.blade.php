<div id='searchcriteria'>
  <div>
    <h3>Search Criteria</h3>
    <div class="well">
      <label class="radio-inline"><input type="radio" name="anyornone" value='search'>Search All Reel Series</label>
      <label class="radio-inline"><input type="radio" name="anyornone" value='clear'>Clear All Reel Series</label>
    </div>
    <ul id="tabs-cable" class="nav nav-tabs" role="tablist">
      <li id="tab-s" class="active"><a href="#s" role="tab" data-toggle="tab">S</a></li>
      <li id="tab-mmd"><a href="#mmd" role="tab" data-toggle="tab">MMD</a></li>
      <li id="tab-sm"><a href="#sm" role="tab" data-toggle="tab">SM</a></li>
      <li id="tab-sho"><a href="#sho" role="tab" data-toggle="tab">SHO</a></li>
      <li id="tab-tmr"><a href="#tmr" role="tab" data-toggle="tab">TMR</a></li>
      <li id="tab-cm"><a id="cmlink" href="#cm" role="tab" data-toggle="tab">CM</a></li>
      <li id="tab-uc"><a href="#u" role="tab" data-toggle="tab">U</a></li>
      <li id="tab-pendant"><a href="#pendant" role="tab" data-toggle="tab">Pendant</a></li>
    </ul>
    <ul id="tabs-hose" class="nav nav-tabs" role="tablist">
      <li id="tab-k"><a id="klink" href="#k" role="tab" data-toggle="tab">K</a></li>
      <li id="tab-uh"><a id="uhlink" href="#uh" role="tab" data-toggle="tab">U</a></li>
      <li id="tab-hm"><a id="hmlink" href="#hm" role="tab" data-toggle="tab">HM</a></li>
    </ul>
  </div>

  <div class="tab-content" id="tab-content">
    <div class="tab-pane active" id="s">
      @include('reel.tabs.search.tabs.s')
    </div>
    <div class="tab-pane" id="mmd">
      @include('reel.tabs.search.tabs.mmd')
    </div>
    <div class="tab-pane" id="sm">
      @include('reel.tabs.search.tabs.sm')
    </div>
    <div class="tab-pane" id="sho">
      @include('reel.tabs.search.tabs.sho')
    </div>
    <div class="tab-pane" id="tmr">
      @include('reel.tabs.search.tabs.tmr')
    </div>
    <div class="tab-pane" id="cm">
      @include('reel.tabs.search.tabs.cm')
    </div>
    <div class="tab-pane" id="k">
      @include('reel.tabs.search.tabs.k')
    </div>
    <div class="tab-pane" id="u">
      @include('reel.tabs.search.tabs.u')
    </div>
    <div class="tab-pane" id="pendant">
      @include('reel.tabs.search.tabs.pendant')
    </div>
    <div class="tab-pane" id="uh">
      @include('reel.tabs.search.tabs.uh')
    </div>
    <div class="tab-pane" id="hm">
      @include('reel.tabs.search.tabs.hm')
    </div>
  </div>
</div>

<div id='cablenotselected'>
  <h3>No cable/hose was selected!</h3>
</div>

<script type="text/javascript">






$( document ).ready(function(){




  $('#cablenotselected').show();
  $('#searchcriteria').hide();

  //changeTabs();
  $( "#applicationSelect" ).change(function() {
    changeTabs();
  });

  $("input:radio[name='anyornone']").change(function() {

    $(":checkbox").attr('checked', false);
    if($(this).val() == 'search') {
      console.log('search');
      $(":checkbox[value='any']").click();
    }
    else {
      console.log('clear');
      $(":checkbox[value='none']").click();
    }
  });
});

$('.nav li').on('click', function(e) {
  if ($(this).hasClass('disabled')) {
    e.preventDefault();
    return false;
  }
});

$('#none').click(function(event) {  //on click
  $('.col-md-3 input').each(function() { //loop through each checkbox
    this.checked = false;
  });
});

$('#any').click(function(event) {  //on click
  $('.col-md-3 input').each(function() { //loop through each checkbox
    this.checked = true;
  });
});

$( ".col-md-3 input" ).on( "click", function() {
  var x = $( "input:checked" ).val();
  var Sselected = [];
  var MMDselected = [];
  var SMselected = [];
  $('#S-checkbox input:checked').each(function() {
    Sselected.push($(this).attr('value'));
  });

  $('#MMD-checkbox input:checked').each(function() {
    MMDselected.push($(this).attr('value'));
  });
  $('#SM-checkbox input:checked').each(function() {
    SMselected.push($(this).attr('value'));
  });
  len = Sselected.length;
  if(Sselected[0]){
  alert(Sselected);
  if(Sselected[len-1] == "Any" || Sselected[len-1] == "s32" || Sselected[len-1] == "None"){
    $('#drumMaxS').val(28);
  }
  if(Sselected[len-1] == "s14"){$('#drumMax').val(10);}
  if(Sselected[len-1] == "s16"){$('#drumMax').val(12);}
  if(Sselected[len-1] == "s18"){$('#drumMax').val(14);}
  if(Sselected[len-1] == "s21"){$('#drumMax').val(17);}
  if(Sselected[len-1] == "s24"){$('#drumMax').val(20);}
  if(Sselected[len-1] == "s28"){$('#drumMax').val(24);}
  }
  if(MMDselected[0]){
  alert(MMDselected);
  if(MMDselected[len-1] == "Any" || MMDselected[len-1] == "None"){$('#drumMaxMMD').val(28);
  $('.col-md-3 input').attr('checked', false);
  }
  if(MMDselected[len-1] == "mmd21"){$('#drumMaxMMD').val(10);}
  if(MMDselected[len-1] == "mmd24"){$('#drumMaxMMD').val(12);}
  if(MMDselected[len-1] == "mmd28"){$('#drumMaxMMD').val(14);}
  if(MMDselected[len-1] == "mmd32"){$('#drumMaxMMD').val(28);}
  }

});
//Hide Reels for Cable and show only hose.
var calcDrumMinR; var calcDrumMin; var style; var hoseIDinInches; var uReelWidth; var uReelWithInp;
var cableOrHose; var calcDrumMinU; var calcDrumMax; var hoseIDcode; var cableThick; var turnsUsedPercent;
var maxTurnsFromUspring; var maxTurnsFromKspring; var maxTurnsFromHMspring;
$(function(){
    $(document).on('click', '#step3', function () {
         style = $("input[name=identifier1]").val();

        if(style == "Single Hose" || $("#applicationSelect").val() == "hand"){
            $('#klink').hide();
            $('#k').addClass("disabled");
            $('#klink').show();
            //$('#uh').show();
        }else{
            $('#uhlink').addClass("disabled");
            $('#uh').addClass("disabled");
            $('#hmlink').addClass("disabled");
            $('#hm').addClass("disabled");
            $('#klink').addClass("enabled");
            $('#k').addClass("enabled");
        }

        var metricDefault;
        metricDefault = false;
        var selValue = $('input[name=measureUnit]:checked').val();
        if(selValue == "METRIC"){
            metricDefault = true;
        }

        var id = $("input[name=identifier7]").val();
        hoseIDinInches = 0;

        switch (metricDefault){
            case true:
                hoseIDinInches = Number(id) * 0.03937
                //alert("MetricValue - true with hoseIDinInches: " + hoseIDinInches);
                break;
            case false:
                hoseIDinInches = Number(id)
                //alert("MetricValue - false with ID: " + hoseIDinInches);
                break;
        }

        if(hoseIDinInches > 0.5){
            $('#hmlink').addClass("disabled");
            $('#hm').addClass("disabled");
            //If securityCODE <> 99 Then MsgBox "Based on the hose entered, the HM reel is not an option for this application."
        }

        hoseIDcode = 0;
        //alert("MetricValue - false with ID: " + hoseIDinInches);

        if(hoseIDinInches < 0.3){
            hoseIDcode = "4";
        }else if(hoseIDinInches < 0.4){
            hoseIDcode = "6";
        }else if(hoseIDinInches < 0.6){
            hoseIDcode = "8";
        }else if(hoseIDinInches < 0.8){
            hoseIDcode = "12";
        }else if(hoseIDinInches < 1.1){
            hoseIDcode = "16";
        }else if(hoseIDinInches < 1.3){
            hoseIDcode = "20";
        }else if(hoseIDinInches < 1.6){
            hoseIDcode = "24";
        }else{
            hoseIDcode = "ER";
        }
        //alert("MetricValue - false with ID: " + hoseIDcode);
        $("#uh-collectorcode").val(hoseIDcode);
        $("#hm-collectorcode").val(hoseIDcode);
        $("#k-collectorcode").val(hoseIDcode);

        calcDRUMminMAX(hoseIDinInches);
        calcUreelWidth();
        //alert("uReelWidth: " + uReelWidth);
        $("#uh-spoolwidth").val(uReelWidth);

        //Check pretension turns values
        turnsUsedPercent = Number($("#springturns").val())
        if (turnsUsedPercent != 0){
            maxTurnsFromUspring = 29 * (Number(turnsUsedPercent) / 100);
            maxTurnsFromKspring = 29 * (Number(turnsUsedPercent) / 100);
            maxTurnsFromHMspring = 33 * (Number(turnsUsedPercent) / 100);
        }else{
            maxTurnsFromUspring = 29;
            maxTurnsFromKspring = 29;
            maxTurnsFromHMspring = 33;
        }
        checkPretensionMax();
    });//Event propagation handler for step3 button (moving from application to reel search)

    $(document).on('click', '#hmlink', function () {
        if($("#applicationSelect").val() == "hand"){
            $('#uh').hide();
        }
    });

    $(document).on('click', '#uhlink', function () {
        if($("#applicationSelect").val() == "hand"){
            $('#k').hide();
            $('#uh').show();
        }
    });
});

function calcDRUMminMAX(hoseIDinInches){
    //var calcDrumMinR; var calcDrumMin;
    //var cableOrHose; var calcDrumMinU; var calcDrumMax;

    var style = $("input[name=identifier1]").val();

    if(style = "Single Hose"){
        cableOrHose = "HS";
    }else if(style == "Dual Hose (Vinyl)" || style == "Dual Hose (Braided Steel)") {
        cableOrHose = "HD";
    }else{
        cableOrHose = "C";
    }

    if(cableOrHose == "HD" || cableOrHose == "HS"){
        if(hoseIDinInches > 0.5){
            if(hoseIDinInches < 0.8){
                calcDrumMinU = 10; calcDrumMax = 10;
            }

            if(hoseIDinInches < 1.1){
                calcDrumMinU = 12; calcDrumMax = 12;
            }

            if(hoseIDinInches < 1.3){
                calcDrumMinU = 14; calcDrumMax = 14;
            }

            if(hoseIDinInches < 1.6){
                calcDrumMinU = 16; calcDrumMax = 16;
            }
        }else{
            var cableBend = $("input[name=identifier9]").val();
            //alert("cable bend " + cableBend);
            calcDrumMinR = (2 * cableBend) + 1;
            calcDrumMin = Math.round(calcDrumMinR);
            if(calcDrumMin % 2 == 0){
                calcDrumMin = calcDrumMin + 1;
            }
            if (calcDrumMin < 10){
                calcDrumMinU = 10;
            }else{
                calcDrumMinU = calcDrumMin;
            }

            calcDrumMax = 26;
            $("#uh-drummin").val(calcDrumMinU);
            $("#uh-drummax").val(calcDrumMax);
        }

        /*The other code in calcDrumMinMax in ReelMod.bas not relevant to hose implementation */
    }
}//End of function calcDrumMinMax

  function calcUreelWidth() {
    cableThick = $("input[name=identifier8]").val();
      switch (cableOrHose){
          case "HD":
          case "HS":
              switch (hoseIDcode){
                  case "4":
                     uReelWidth = 6; uReelWithInp = "06";
                     break;
                  case "6":
                      uReelWidth = 6; uReelWithInp = "06";
                      break;
                  case "8":
                      uReelWidth = 6; uReelWithInp = "06";
                      break;
                  case "12":
                      uReelWidth = 8; uReelWithInp = "08";
                      break;
                  case "16":
                      uReelWidth = 8; uReelWithInp = "08";
                      break;
                  case "20":
                      uReelWidth = 10; uReelWithInp = "10";
                      break;
                  case "24":
                      uReelWidth = 10; uReelWithInp = "10";
                      break;
              }
              //alert("CableOrHose: " + cableOrHose + " uReelWidth: " + uReelWidth + " uReelWidthInp: " + uReelWithInp);
              break;
          default:
              if(Number(cableThick) < 1){
                  uReelWidth = 7 * Number(cableThick);
              }else{
                  uReelWidth = 5 * Number(cableThick);
              }

              if(uReelWidth != Math.round(uReelWidth)){
                  uReelWidth = Math.round(uReelWidth + 1);
              }

              if(uReelWidth /2 != Math.round(uReelWidth / 2)){
                  uReelWidth = uReelWidth + 1;
              }

              uReelWithInp = uReelWidth.toString().trim();
              if(uReelWithInp.length == 1){
                  uReelWithInp = "0" + uReelWithInp;
              }
              //alert("CableOrHose: " + cableOrHose + " uReelWidth: " + uReelWidth + " uReelWidthInp: " + uReelWithInp);
      }

  }//End of calcUreelWidth
function checkPretensionMax() {
  var k_pretensMax = Number($("#k-pretensmax").val());
  var uh_pretensMax = Number( $("#uh-pretensmax").val());
  var hm_pretensMax = Number($("#hm-pretensmax").val());

    if(k_pretensMax > maxTurnsFromKspring){
        $("#k-pretensmax").val(maxTurnsFromKspring);
    }

    if(uh_pretensMax > maxTurnsFromUspring){
        $("#uh-pretensmax").val(maxTurnsFromUspring);
    }

    if(hm_pretensMax > maxTurnsFromHMspring){
        $("#hm-pretensmax").val(maxTurnsFromHMspring);
    }

}

</script>
