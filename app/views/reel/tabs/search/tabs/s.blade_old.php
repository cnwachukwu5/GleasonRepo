<div class="container marginleft">
  <div class="col-lg-3">
    <h3>S Reels to consider</h3>
    <div id='s-checkboxes' class="marginleft">
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="s-checkboxes[]" value="none" checked>None</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="s-checkboxes[]" value="any">Any</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="s-checkboxes[]" value="14">S14</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="s-checkboxes[]" value="16">S16</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="s-checkboxes[]" value="18">S18</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="s-checkboxes[]" value="21">S21</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="s-checkboxes[]" value="24">S24</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="s-checkboxes[]" value="28">S28</label>
        </div>
      </div>
      <div class="form-group">
        <div class="checkbox">
          <label><input type="checkbox" name="s-checkboxes[]" value="32">S32</label>
        </div>
      </div>
    </div>
  </div>
  <div id='s-inputs' class="col-lg-4">
    <h3>S Reel Model Parameters</h3>
    <div class="marginleft">
      <div class="form-group">
        <label class="col-md-5 control-label">Spring Size</label>
        <div class="col-sm-4">
          <select name="s-springsize" class="form-control">
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
          <div class="input-group"><input type="text" name="s-collectorcode" id="s-collectorcode" class="form-control" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Drum Diameter Range Min.</label>
        <div class="col-md-3">
          <div class="input-group">
            <input type="text" name="s-drummin" class="form-control" value="8" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Drum Diameter Range Max.</label>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" name="s-drummax" id="s-drummax" class="form-control" value="28" />
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Gear Ratio</label>
        <div class="col-sm-5">
          <select class="form-control" name="s-gearratio">
            <option value="all" class="active">None</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-5 control-label">Pretension Turn Range Min.</label>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" name="s-pretensmin" class="form-control" value="1" />
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-5 control-label">Pretension Turn Range Max.</label>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" name="s-pretensmax" class="form-control" value="6"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>

$("#s-inputs select[name='s-springsize']").change(function() {
  showValidGearS();
});

$('#s-checkboxes :checkbox').change(function() {

  if(this.value == 'none' || this.value == 'any') {
    var value = this.value;

    $("#s-drummax").val(28);

    $('#s-checkboxes :checkbox').each(function() {
      if(value != this.value) {
        $(this).attr('checked', false);

      }
    });
  }
  else {
    var highest = null;
    $('#s-checkboxes :checkbox').each(function() {
      if(this.checked) {
        highest = this;
      }
    });

    $("#s-checkboxes :checkbox[value='any']").attr('checked', false);
    $("#s-checkboxes :checkbox[value='none']").attr('checked', false);


    if(highest == null) {
        $("#s-drummax").val('');
    }
    else {
      switch(highest.value) {
        case '14':
            $("#s-drummax").val(10);
          break;
        case '16':
            $("#s-drummax").val(12);
          break;
        case '18':
            $("#s-drummax").val(14);
          break;
        case '21':
            $("#s-drummax").val(17);
          break;
        case '24':
            $("#s-drummax").val(20);
          break;
        case '28':
            $("#s-drummax").val(24);
          break;
        case '32':
        default:
            $("#s-drummax").val(28);
          break;

      }
    }
  }
  console.log("about to get valid spring");
  getValidSpringS(this.value);
  showValidGearS();
});


//Get the Cable properties (Conductor and AWG) and application type and use that to compute the
//value for the collectorCode
var COND = 0;
var AWG = null;
var appType = null;
var cableType = null;
var grndQty = 0;//Ground property of cable
var grndChkQty = 0; //Ground Check property
var collectorAMP = 0;
var collectorCODE = 0;
var numCOLLECTORconductors = 0;
var qtyCONDUCTORSlessGRNDCHK = 0;
var qtyCONDUCTORSlessGRNDCHK_grndChkQty = 0;

$(function(){
    //Use event propagation to get the values submitted in different forms
    $(document).on("click","#step3" , function (){
        COND = $("input[name=identifier4]").val();
        AWG = $("input[name=identifier3]").val();
        cableType = $("input[name=identifier2]").val();
    });

$(function() {
    //Use event propagation to get the values submitted in different forms
    appType = $("#applicationSelect").val();

    $(document).on("change", "#applicationSelect", function () {
        appType = $("#applicationSelect").val();
    });
});
$(function(){

    //Compute the collector code
    $(document).on("click","#step3" , function () {
        $('#tabs-hose').hide();
        //alert("Conductor value: " + COND);
        //alert("AWG value: " + AWG);
        //alert("Application value: " + appType);
        //alert("Cable value: " + cableType);
        //Declare variables to hold the Ground and Ground Check Quantities properties of the cable

        //cabletype possible values ("SO", "W", "G", "GGC", "HV", "PVC", "NEOPRENE")

        if(cableType == "G"){//Check that the selected Cable type is "G"
            grndQty = 1;
            grndChkQty = 0;
        }else if (cableType == "HV" || cableType == "GGC"){
            grndQty = 1;
            grndChkQty = 1;
        }else{
            grndQty = 0;
            grndChkQty = 0;
        }

        //Set qtyCONDUCTORSlessGRNDCHK - holds the value of sum of conductor and Ground properties

        qtyCONDUCTORSlessGRNDCHK = Number(COND) + Number(grndQty);

        //Set the value of collectorAMP, collectorCODE and numCOLLECTORconductors base on appType as follows
        if(appType == "Magnet"){
            collectorAMP = 200;
            collectorCODE = "220";
            numCOLLECTORconductors = 2;
        }

        //Set the value for collectorAMP based on the value of AWG

            if(AWG ==  "18" || AWG == "16" || AWG == "14" || AWG ==  "12" || AWG == "10") {
                collectorAMP = 35;
            }else if(AWG == "8" || AWG == "6") {
                collectorAMP = 75;
            }else if(AWG == "4" || AWG == "3" || AWG == "2") {
                collectorAMP = 125;
            }else if(AWG == "1" || AWG == "1/0") {
                collectorAMP = 200;
            }else if(AWG == "2/0") {
                collectorAMP = 400;
            }else if(AWG == "3/0" || AWG == "4/0" || AWG == "250" || AWG == "300" || AWG == "350" || AWG == "400" || AWG == "450" || AWG == "500") {
                collectorCODE = "Bad";
            }else {
                collectorCODE = "Bad";
            }//End of Switch AWG

        //Set the collectorCode and numCOLLECTORconductors for the selected cable based on value of collectorAMP
        qtyCONDUCTORSlessGRNDCHK_grndChkQty = Number(qtyCONDUCTORSlessGRNDCHK) + Number(grndChkQty);
        //alert("qtyCONDUCTORSlessGRNDCHK: " + qtyCONDUCTORSlessGRNDCHK + " grndChkQty: " + grndChkQty);
        //alert("qtyCONDUCTORSlessGRNDCHK_grndChkQty: " + qtyCONDUCTORSlessGRNDCHK_grndChkQty);
        //alert("AWG: " + AWG + " collectorAMP: " + collectorAMP);

            if(collectorAMP == 35)
            {
                if (Number(qtyCONDUCTORSlessGRNDCHK_grndChkQty) > 36) {
                    collectorCODE = "Bad";
                } else if (qtyCONDUCTORSlessGRNDCHK_grndChkQty > 30 && qtyCONDUCTORSlessGRNDCHK_grndChkQty <= 36) {
                    collectorCODE = "363";
                    numCOLLECTORconductors = 36;
                } else if (qtyCONDUCTORSlessGRNDCHK_grndChkQty > 24 && qtyCONDUCTORSlessGRNDCHK_grndChkQty <= 30) {
                    collectorCODE = "303";
                    numCOLLECTORconductors = 30;
                } else if (qtyCONDUCTORSlessGRNDCHK_grndChkQty > 20 && qtyCONDUCTORSlessGRNDCHK_grndChkQty <= 24) {
                    collectorCODE = "243";
                    numCOLLECTORconductors = 24;
                } else if (qtyCONDUCTORSlessGRNDCHK_grndChkQty > 16 && qtyCONDUCTORSlessGRNDCHK_grndChkQty <= 20) {
                    collectorCODE = "203";
                    numCOLLECTORconductors = 20;
                } else if (qtyCONDUCTORSlessGRNDCHK_grndChkQty > 14 && qtyCONDUCTORSlessGRNDCHK_grndChkQty <= 16) {
                    collectorCODE = "163";
                    numCOLLECTORconductors = 16;
                } else if (qtyCONDUCTORSlessGRNDCHK_grndChkQty > 12 && qtyCONDUCTORSlessGRNDCHK_grndChkQty <= 14) {
                    collectorCODE = "143";
                    numCOLLECTORconductors = 14;
                } else if (qtyCONDUCTORSlessGRNDCHK_grndChkQty > 10 && qtyCONDUCTORSlessGRNDCHK_grndChkQty <= 12) {
                    collectorCODE = "123";
                    numCOLLECTORconductors = 12;
                } else if (qtyCONDUCTORSlessGRNDCHK_grndChkQty > 8 && qtyCONDUCTORSlessGRNDCHK_grndChkQty <= 10) {
                    collectorCODE = "103";
                    numCOLLECTORconductors = 10;
                } else if (qtyCONDUCTORSlessGRNDCHK_grndChkQty > 6 && qtyCONDUCTORSlessGRNDCHK_grndChkQty <= 8) {
                    collectorCODE = "83";
                    numCOLLECTORconductors = 8;
                } else if (qtyCONDUCTORSlessGRNDCHK_grndChkQty > 4 && qtyCONDUCTORSlessGRNDCHK_grndChkQty <= 6) {
                    collectorCODE = "63";
                    numCOLLECTORconductors = 6;
                } else if (qtyCONDUCTORSlessGRNDCHK_grndChkQty > 3 && qtyCONDUCTORSlessGRNDCHK_grndChkQty <= 4) {
                    collectorCODE = "43";
                    numCOLLECTORconductors = 4;
                } else if (qtyCONDUCTORSlessGRNDCHK_grndChkQty > 2 && qtyCONDUCTORSlessGRNDCHK_grndChkQty <= 3) {
                    collectorCODE = "33";
                    numCOLLECTORconductors = 3;
                } else if (qtyCONDUCTORSlessGRNDCHK_grndChkQty > 0 && qtyCONDUCTORSlessGRNDCHK_grndChkQty <= 2) {
                    collectorCODE = "33";
                    numCOLLECTORconductors = 3;
                } else {

                }
            }else if(collectorAMP == 75) {
                if(qtyCONDUCTORSlessGRNDCHK > 8) {
                    collectorCODE = "Bad";
                }else if(qtyCONDUCTORSlessGRNDCHK > 6 && qtyCONDUCTORSlessGRNDCHK <= 8) {
                    collectorCODE = "87"; numCOLLECTORconductors = 8;
                }else if (qtyCONDUCTORSlessGRNDCHK > 4 && qtyCONDUCTORSlessGRNDCHK <= 6) {
                    collectorCODE = "67"; numCOLLECTORconductors = 6;
                }else if (qtyCONDUCTORSlessGRNDCHK > 3 && qtyCONDUCTORSlessGRNDCHK <= 4) {
                    collectorCODE = "47";numCOLLECTORconductors = 4;
                }else if (qtyCONDUCTORSlessGRNDCHK > 2 && qtyCONDUCTORSlessGRNDCHK <= 3) {
                    collectorCODE = "37"; numCOLLECTORconductors = 3;
                }else if (qtyCONDUCTORSlessGRNDCHK > 0 && qtyCONDUCTORSlessGRNDCHK <= 2){
                    collectorCODE = "27"; numCOLLECTORconductors = 2;
                }else{

                }
            }else if(collectorAMP == 125) {
                if (qtyCONDUCTORSlessGRNDCHK > 4) {
                    collectorCODE = "Bad";
                }else if (qtyCONDUCTORSlessGRNDCHK > 3 && qtyCONDUCTORSlessGRNDCHK <= 4) {
                    collectorCODE = "412"; numCOLLECTORconductors = 4;
                }else if (qtyCONDUCTORSlessGRNDCHK > 2 && qtyCONDUCTORSlessGRNDCHK <= 3) {
                    collectorCODE = "312"; numCOLLECTORconductors = 3;
                }else if (qtyCONDUCTORSlessGRNDCHK > 0 && qtyCONDUCTORSlessGRNDCHK <= 2){
                    collectorCODE = "212"; numCOLLECTORconductors = 2;
                }else{

                }
            }else if(collectorAMP == 200) {
                if (qtyCONDUCTORSlessGRNDCHK > 4) {
                    collectorCODE = "Bad";
                }else if (qtyCONDUCTORSlessGRNDCHK > 3 && qtyCONDUCTORSlessGRNDCHK <= 4) {
                    collectorCODE = "420"; numCOLLECTORconductors = 4;
                }else if (qtyCONDUCTORSlessGRNDCHK > 2 && qtyCONDUCTORSlessGRNDCHK <= 3) {
                    collectorCODE = "320"; numCOLLECTORconductors = 3;
                }else if (qtyCONDUCTORSlessGRNDCHK > 0 && qtyCONDUCTORSlessGRNDCHK <= 2) {
                    collectorCODE = "220"; numCOLLECTORconductors = 2;
                }else{

                }
            }else if (collectorAMP == 400){
                if (qtyCONDUCTORSlessGRNDCHK > 2) {
                    collectorCODE = "Bad";
                }else if (qtyCONDUCTORSlessGRNDCHK > 0 && qtyCONDUCTORSlessGRNDCHK <= 2){
                        collectorCODE = "240"; numCOLLECTORconductors = 2;
                }else{

                }
        }
        //alert("collectorCode: " + collectorCODE + " and numCOLLECTORconductors: " + numCOLLECTORconductors);
        if(grndChkQty == 1 && collectorAMP > 35 && collectorCODE != "Bad"){
            collectorCODE = collectorCODE + "-13";
        }
        $('#s-collectorcode').val(collectorCODE);
        $('#mmd-collectorcode').val(collectorCODE);
        $('#sm-collectorcode').val(collectorCODE);
        $('#tmr-reels-code').val(collectorCODE);
        $('#u-collectorcode').val(collectorCODE);
        $('#sho-reels-code').val(collectorCODE);
        $('#p-collectorcode').val(collectorCODE);
    });//End of anonymous function to compute the CollectorCode
    //$('#s-collectorcode').val(collectorCODE);
});
    //Disable the CM tab if the cable property matches any of the criteria below.
    $(function(){
        $(document).on("click","#step3" , function () {
            var cableTypes = $("input[name=identifier2]").val();
            var CONDs = $("input[name=identifier4]").val();
            var AWGs = $("input[name=identifier3]").val();
            //alert("CableType: " + cableTypes + " COND: " + CONDs + " AWG: " + AWGs);

            if(cableTypes == "GGC" || Number(CONDs) > 12 || Number(AWGs) < 8 || Number(AWGs) > 18){
                $("#cmlink").addClass("disabled");
                alert("Based on the cable entered, the CM reel is not an option for this application");
                //$( "#dialog" ).dialog( "open" );
            }else{//Generate the Wire Size Code for CM reels
                //alert("I'm in this block");
                var wireSIZE = null;
                var slipRINGpoles = null;
                var roundingVALUE = 0;
                var wireSIZEcode = null;
                //Set the value of wireSIZE
                if(Number(AWGs) == 18){
                    wireSIZE = "Z";
                }
                if(Number(AWGs) == 16){
                    wireSIZE = "A";
                }
                if(Number(AWGs) == 14){
                    wireSIZE = "B";
                }
                if(Number(AWGs) == 12){
                    wireSIZE = "C";
                }
                if(Number(AWGs) == 10){
                    wireSIZE = "D";
                }
                if(Number(AWGs) == 8){
                    if(cableTypes == "W"){
                        wireSIZE = "E";
                    }else{
                        wireSIZE = "F";
                    }
                }
                //alert("AWG: " + AWG + " wireSIZE: " + wireSIZE + " qtyCONDUCTORSlessGRNDCHK_grndChkQty: " + qtyCONDUCTORSlessGRNDCHK_grndChkQty);
                //qtyCONDUCTORSlessGRNDCHK_grndChkQty: Stores the value of qtyCONDUCTORSlessGRNDCHK + grndchkQTY
                //Set the value of roundingVALUE based on the value of qtyCONDUCTORSlessGRNDCHK_grndChkQty
                if(qtyCONDUCTORSlessGRNDCHK_grndChkQty == 5 || qtyCONDUCTORSlessGRNDCHK_grndChkQty == 7 || qtyCONDUCTORSlessGRNDCHK_grndChkQty == 9 || qtyCONDUCTORSlessGRNDCHK_grndChkQty == 11){
                    roundingVALUE = 1;
                    //alert("AWG: " + AWG + " wireSIZE: " + wireSIZE + " qtyCONDUCTORSlessGRNDCHK_grndChkQty: " + qtyCONDUCTORSlessGRNDCHK_grndChkQty);
                }else {
                    roundingVALUE = 0;
                    //alert("AWG: " + AWG + " wireSIZE: " + wireSIZE + " qtyCONDUCTORSlessGRNDCHK_grndChkQty: " + qtyCONDUCTORSlessGRNDCHK_grndChkQty);
                }
                var x = Number(qtyCONDUCTORSlessGRNDCHK_grndChkQty) + Number(roundingVALUE);
                //alert("Value of X: " + x);
                if(x < 10 ){
                    slipRINGpoles = "0" + x;
                    //alert("slipRINGpoles: " + slipRINGpoles);
                }else{
                    slipRINGpoles = x;
                }
                wireSIZEcode = wireSIZE + slipRINGpoles;
                $('#cm-wire-size-code').val(wireSIZEcode);
            }

        })
    });

});
</script>
