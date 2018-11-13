@extends('layouts.master')

@section('page-title')
    Price Check
@stop

@section('content')
    <br/>
    <span style="font-weight: bold">This screen provides a convenient way to get a reel price. You cannot generate a quote using this screen. To generate a quote, select Reel from the side bar</span>

    <form>
    <div class="content" style="margin-left: 10%">

        <div class="row">
            <div class="col-sm-12">
                <br/> <br/>
                <div id="reel-radio">
                <fieldset class = "form-group reels">
                    <legend>Select Reel Type: </legend>
                    <div class="form-group radio-inline">
                        <div class="radio">
                            <label class="radio-inline">
                                <input class="reel-class" type="radio" name="reels" value="S"> S
                            </label>
                        </div>
                    </div>
                    <div class="form-group radio-inline">
                        <div class="radio">
                            <label class="radio-inline">
                                <input class="reel-class" type="radio" name="reels" value="MMD"> MMD
                            </label>
                        </div>
                    </div>
                    <div class="form-group radio-inline">
                        <div class="radio">
                            <label class="radio-inline">
                                <input class="reel-class" type="radio" name="reels" value="SM"> SM
                            </label>
                        </div>
                    </div>
                    <div class="form-group radio-inline">
                        <div class="radio">
                            <label class="radio-inline">
                                <input class="reel-class" type="radio" name="reels" value="SHO"> SHO
                            </label>
                        </div>
                    </div>
                    <div class="form-group radio-inline">
                        <div class="radio">
                            <label class="radio-inline">
                                <input class="reel-class" type="radio" name="reels" value="TMR"> TMR
                            </label>
                        </div>
                    </div>
                    <div class="form-group radio-inline">
                        <div class="radio">
                            <label class="radio-inline">
                                <input class="reel-class" type="radio" name="reels" value="UE"> UE
                            </label>
                        </div>
                    </div>
                    <div class="form-group radio-inline">
                        <div class="radio">
                            <label class="radio-inline">
                                <input class="reel-class" type="radio" name="reels" value="UH"> UH
                            </label>
                        </div>
                    </div>
                    <div class="form-group radio-inline">
                        <div class="radio">
                            <label class="radio-inline">
                                <input class="reel-class" type="radio" name="reels" value="C"> CM
                            </label>
                        </div>
                    </div>
                    <div class="form-group radio-inline">
                        <div class="radio">
                            <label class="radio-inline ">
                                <input class="reel-class" type="radio" name="reels" value="HM"> HM
                            </label>
                        </div>
                    </div>
                    <div class="form-group radio-inline">
                        <div class="radio">
                            <label class="radio-inline">
                                <input class="reel-class" type="radio" name="reels" value="P"> P
                            </label>
                        </div>
                    </div>
                    <div class="form-group radio-inline">
                        <div class="radio">
                            <label class="radio-inline">
                                <input class="reel-class" type="radio" name="reels" value="K"> K
                            </label>
                        </div>
                    </div>
                </fieldset>
                </div>
            </div>
        </div>
        <div class="row" id="row2" style="width: 100%; overflow:hidden">
            <br/>
            <div class="col-sm-12" style="width: 100%">
                <div class="inline" id="showFrame">
                    Frame: <select name="frames" id="frames" style="margin-right: 5%">
                        <option value="">Select frame</option>
                    </select>
                </div>
                <div class="inline" id="showSpoolType" >
                    Spool Type: <select name="spoolType" id="spoolType" style="margin-right: 5%">
                        <option value="">Select Spool type</option>
                        <option value="M">Monospiral</option>
                        <option value="R">Random Wrap</option>
                    </select>
                </div>
                <div class="inline" id="showSpring">
                    Spring: <select name="spring" id="springsForReel" style="margin-right: 5%">
                        <option value="">Select spring</option>
                    </select>
                </div>
                <div class="inline" id="showMotor">
                    Motor: <select name="motor" id="motorTMR" style="margin-right: 5%">
                        <option value="">Select Motor</option>
                    </select>
                </div>
                <div class="inline" id="showCollector">
                    Collector: <select name="collector" id="collectorReel" style="margin-right: 5%">
                        <option value="">Select collector</option>
                    </select>
                </div>
                <div class="inline" id="showHose">
                    Hose Code: <select name="hose" id="hose" style="margin-right: 5%">
                        <option value="">Select hose code</option>
                    </select>
                </div>
                <div class="inline" id="showWireCode">
                    Wire Code: <select name="wireCode" id="wireCode" style="margin-right: 5%">
                        <option value="">Select Wire Code</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="row" id="row3" style="clear: both">
            <br/><fieldset class="row3Cover">
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4" id="gearedReel">
                        <fieldset class = "geared-reels" style="margin-right: 5%">
                            <legend>Geared Reel? </legend>
                            <div class="radio-inline">

                                    <label class="radio-inline">
                                        <input class="reel-class" type="radio" name="geared-reels" value="No"> No
                                    </label>

                            </div>
                            <div class="radio-inline">

                                    <label class="radio-inline">
                                        <input class="reel-class" type="radio" name="geared-reels" value="Yes"> Yes
                                    </label>

                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-4" id="reverseRotate">
                        <fieldset class = "geared-reels" style="">
                            <legend>Reverse Rotate? </legend>
                            <div class="radio-inline">

                                    <label class="radio-inline">
                                        <input class="reel-class" type="radio" name="reverse-rotate" value="No"> No
                                    </label>

                            </div>
                            <div class="radio-inline">

                                    <label class="radio-inline">
                                        <input class="reel-class" type="radio" name="reverse-rotate" value="Yes"> Yes
                                    </label>

                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-4" id="harzardDuty">
                        <fieldset class = "geared-reels">
                            <legend>Harzadous Duty? </legend>
                            <div class="radio-inline">

                                    <label class="radio-inline">
                                        <input class="reel-class" type="radio" name="harzard-duty" value="No"> No
                                    </label>

                            </div>
                            <div class="radio-inline">

                                    <label class="radio-inline">
                                        <input class="reel-class" type="radio" name="harzard-duty" value="Yes"> Yes
                                    </label>

                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-4" id="chainRatiodiv">
                        Chain Ratio: <select name="chainRatio" id="chainRatio">
                            <option value="">Select Chain Ratio</option>
                        </select>
                    </div>
                    <div class="col-sm-4" id="gearRatiodiv">
                        Gear Ratio: <select name="gearRatio" id="gearRatio">
                            <option value="">Select Gear ratio</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                        </select>
                    </div>
                    <div class="col-sm-4" id="spoolWidthdiv">
                        Spool Width: <select name="springWidth" id="springWidth">
                            <option value="">Select spool width</option>
                            <option value="6">6</option>
                            <option value="8">8</option>
                            <option value="10">10</option>
                            <option value="12">12</option>
                            <option value="14">14</option>
                        </select>
                    </div>
                    <div class="col-sm-4" id="spooldiamdiv">
                        Spool Diam: <select name="spooldiam" id="spooldiam">
                            <option value="">Select spool diam</option>
                        </select>
                    </div>
                </div>
            </div>
            </fieldset>
            <div class="col-sm-6">

            </div>

        </div> <br/>
        <span style="text-decoration-line: underline; font-weight: bold">Price:</span> <span style="color: red; font-weight: bold"> Note: Pricing for reels does NOT include options, accessories, cable/hose, etc</span>
        <div class="row">
            <br/>
            <div class="col-sm-12">
                Number of reels required: <input type="number" name="qty" id="qty" class="form-group"  max="100" min="1" step="1" value="1"/>  <span style="margin-left: 2%">X </span> <span style="margin-right: 2%">&nbsp;&nbsp;&nbsp;Cost per Reel:</span> $ <input type="text" class="form-group amount" name="perReel" id="perReel" disabled style="margin-right: 5%; border: 0;"/> =  <span style=" margin-left: 4%">$</span> <input type="text" class="form-group amount" style="border: 0; width: 7.5%" name = "totalPriceReel" id="totalPriceReel" disabled  />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-6" style="margin-left: 24%">
                Discounts: <input type="number" name="discount1" id="discount1" class="form-group" max="100" min="0" step="1" value="0" style="width: 10%"/> % <span style="margin-right: 2%; margin-left: 1%; width: 10%">and</span> <input type="number" name="discount2" id="discount2" class="form-group" max="100" min="0" step="1" value="0" style="width: 10%;"/>% <span style="margin-left: 18%">-$ </span> <input type="text" class="form-group amount" id="displayDiscount" disabled style="margin-right: 2%; border: 0; width: 15%"/>
                <br/>
                <span style="margin-left: 45%">FINAL PRICE: </span> <span style="margin-left: 2%">$ </span> <input type="text" class="form-group amount" id="finalPrice" disabled style="margin-right: 2%; border: 0; width: 15%"/>
            </div>
        </div>
    </div>
    </form>
@stop
@section('scripts')
    <script>
        var reelVal; var frameValue; var spoolType; var springs_Reel; var motorTMR; var collectorReel; var hoseValue;
        var wireCode; var chainRatio; var gearChoice; var springWidth; var spoolDiam; var geared_reels; var param;
        var reverse_rotate; var harzard_duty; var quantity; var firstDiscount; var secondDiscount; var reelPrice;
        $(document).ready(function () {
            $("#showSpoolType").hide();
            $("#spoolWidthdiv").hide();
            $("#spooldiamdiv").hide();
            $("#chainRatiodiv").hide();
            $("#showMotor").hide();
            $("#gearRatiodiv").hide();
            $("#showHose").hide();
            $("#showWireCode").hide();
            $("#discount2").prop('disabled', true);
            $("#discount1").prop('disabled', true);
        });

        function frameValueForSAndPReels(){
            $("#frames")
                .find('option')
                .end()
                .append('<option value="14" id="opt-14">14</option>'
                    + '<option value="16" id="opt-16">16</option>'
                    + '<option value="18" id="opt-18">18</option>'
                    + '<option value="21" id="opt-21">21</option>'
                    + '<option value="24" id="opt-24">24</option>'
                    + '<option value="28" id="opt-28">28</option>'
                    + '<option value="32" id="opt-32">32</option>');
        }

        function removeOption(){
            $("#opt-14").remove();
            $("#opt-16").remove();
            $("#opt-18").remove();
            $("#opt-19").remove();
            $("#opt-21").remove();
            $("#opt-24").remove();
            $("#opt-28").remove();
            $("#opt-32").remove();
        }
        function remove1416(){
            $("#opt-14").remove();
            $("#opt-16").remove();
        }
        function remove18_32(){
            $("#opt-18").remove();
            $("#opt-21").remove();
            $("#opt-24").remove();
            $("#opt-28").remove();
            $("#opt-32").remove();
        }
        function remove60_72(){
            $("#opt-60").remove();
            $("#opt-66").remove();
            $("#opt-72").remove();
        }

        function populateFrame4Reels(reelVal){
            if(reelVal === "S"){
                removeOption();
                frameValueForSAndPReels();
            }else if(reelVal === "P"){
                removeOption();
                frameValueForSAndPReels();
            }else if(reelVal === "MMD"){
                removeOption();
                frameValueForSAndPReels();
                remove1416();
                $("#opt-18").remove();
            }else if(reelVal === "SM"){
                removeOption();
                frameValueForSAndPReels();
                remove1416();
                $("#opt-18").remove();
            }else if(reelVal === "UE" || reelVal === "UH" || reelVal === "K"){
                removeOption();
                frameValueForSAndPReels();
                remove1416();
            }else if(reelVal === "C" || reelVal === "HM"){
                removeOption();
                frameValueForSAndPReels();
                remove18_32();
                $("#frames")
                    .find('option')
                    .end()
                    .append('<option value="19" id="opt-19">19</option>');
            }
        }

        function populateSpoolDiam() {
            $("#spooldiam")
                .find("option")
                .end()
                .append('<option value="30" id="opt-30">30</option>'
                + '<option value="36" id="opt-36">36</option>'
                + '<option value="42" id="opt-42">42</option>'
                + '<option value="48" id="opt-48">48</option>'
                + '<option value="54" id="opt-54">54</option>'
                + '<option value="60" id="opt-60">60</option>'
                + '<option value="66" id="opt-66">66</option>'
                + '<option value="72" id="opt-72">72</option>');
        }

        function populateGearRatio(){
            $("#chainRatio")
                .find("option")
                .end()
                .append('<option id="opt-AA" value="AA">AA</option>'
                + '<option id="opt-AB" value="AB">AB</option>'
                + '<option id="opt-AC" value="AC">AC</option>'
                + '<option id="opt-AD" value="AD">AD</option>'
                + '<option id="opt-AE" value="AE">AE</option>'
                + '<option id="opt-BA" value="BA">BA</option>'
                + '<option id="opt-BB" value="BB">BB</option>'
                + '<option id="opt-BC" value="BC">BC</option>'
                + '<option id="opt-BD" value="BD">BD</option>'
                + '<option id="opt-BE" value="BE">BE</option>');
        }

        function populateSpoolWidth(reelType) {

            $("#springWidth").find("option:gt(0)").remove();

            if(reelType === "R") {
                $("#springWidth")
                    .find("option")
                    .end()
                    .append('<option value="4" id="opt-4">4</option>'
                        + '<option value="7" id="opt-7">7</option>');
            }else if(reelType === "M"){
                $("#springWidth")
                    .find("option")
                    .end()
                    .append('<option value="MX" id="opt-MX">MX</option>');
            }
        }

        function populateSpoolWidthForUHandUE() {
            $("#springWidth").find("option:gt(0)").remove();
            $("#springWidth")
                .find("option")
                .end()
                .append('<option value="6" id="opt-6">6</option>'
                    + '<option value="8" id="opt-8">8</option>'
                + '<option value="10" id="opt-10">10</option>'
                + '<option value="12" id="opt-12">12</option>'
                + '<option value="14" id="opt-14">14</option>');
        }

        function populateHoseCode(){
            $('#hose').find("option:gt(0)").remove();
            $('#hose')
                .find("option")
                .end()
                .append('<option value="6" id="opt-6">6</option>'
                + '<option value="8" id="opt-8">8</option>'
                + '<option value="12" id="opt-12">12</option>'
                + '<option value="16" id="opt-16">16</option>'
                + '<option value="20" id="opt-20">20</option>'
                + '<option value="24" id="opt-24">24</option>');
        }

        function reset(){
            $("#frames").val("");
            $("#springsForReel").val("");
            $("#collectorReel").val("");
            $("#qty").val(1);
            $("#discount1").val(0);
            $("#discount2").val(0);
            $("#perReel").val("");
            $("#totalPriceReel").val("");
            $("#finalPrice").val("");
            $('input[name="geared-reels"][value="No"]').prop('checked', true);
            $('input[name="reverse-rotate"][value="No"]').prop('checked', true);
            $('input[name="harzard-duty"][value="No"]').prop('checked', true);
        }

        $("#reel-radio :radio").change(function(){
           reelVal = this.value;

           if(reelVal === "S" || reelVal === "MMD" || reelVal === "SM"){
               $("#row2").show();
               $("#row3").show();
               $("#showCollector").show();
               $("#gearRatiodiv").hide();
               $("#showHose").hide();
               $("#showWireCode").hide();
               reset();

               if(reelVal === "S" || reelVal === "MMD"){
                   $('input[name="geared-reels"][value="Yes"]').prop('disabled', true);
                   $('input[name="geared-reels"][value="No"]').prop('checked', true);
                   $('input[name="reverse-rotate"][value="No"]').prop('checked', true);
                   $('input[name="harzard-duty"][value="No"]').prop('checked', true);
                   $("#gearedReel").show();
                   $("#chainRatiodiv").hide();
                   $("#showMotor").hide();
                   $("#showSpring").show();
                   $("#harzardDuty").show();
               }else{
                   $("#gearedReel").hide();
                   $("#harzardDuty").hide();
               }
               if(reelVal === "S"){
                   populateFrame4Reels(reelVal);
               }
               if(reelVal === "MMD"){
                   populateFrame4Reels(reelVal);
               }

               if(reelVal === "SM"){
                   populateFrame4Reels(reelVal);
                   $("#gearedReel").hide();
                   $("#harzardDuty").hide();
                   $("#showMotor").hide();
                   $("#showSpring").show();
                   $("#chainRatiodiv").hide();
               }else{
                   $("#gearedReel").show();
                   $("#harzardDuty").show();
               }
           }else{
               $("#row2").hide();
               $("#row3").hide();
           }

            if(reelVal === "SHO" || reelVal === "TMR"){
                $("#row2").show();
                $("#row3").show();
                $("#showFrame").hide();
                $("#showSpoolType").show();
                $("#spoolWidthdiv").show();
                $("#spooldiamdiv").show();
                $("#showCollector").show();
                $("#reverseRotate").hide();
                $("#harzardDuty").hide();
                $("#showHose").hide();
                $("#showWireCode").hide();
                if(reelVal === "SHO"){
                    $("#gearedReel").hide();
                    $("#chainRatiodiv").hide();
                }
                if(reelVal === "TMR"){
                    $("#gearedReel").hide();
                    $("#chainRatiodiv").show();
                    $("#showMotor").show();
                    $("#showSpring").hide();
                    populateGearRatio();
                }
                else{
                    $("#showMotor").hide();
                    $("#showSpring").show();
                    $("#gearedReel").hide();
                }
            }else{
                $("#showFrame").show();
                $("#showSpoolType").hide();
                $("#reverseRotate").show();
                $("#spoolWidthdiv").hide();
                $("#spooldiamdiv").hide();
            }

           if(reelVal === "P"){
               populateFrame4Reels(reelVal);
               $("#showWireCode").hide();
           }

           if(reelVal === "UE" || reelVal === "UH"){
               populateFrame4Reels(reelVal);
               populateSpoolWidthForUHandUE();
               $("#row2").show();
               $("#row3").show();
               $("#chainRatiodiv").hide();
               $("#showSpring").show();
               $("#showMotor").hide();
               $("#gearedReel").hide();
               $("#harzardDuty").hide();
               $("#reverseRotate").hide();
               $("#spoolWidthdiv").show();
               $("#showWireCode").hide();

               if(reelVal === "UE"){
                   $("#showHose").hide();
                   $("#showCollector").show();
               }

               if(reelVal === "UH"){
                   $("#showHose").show();
                   $("#showSpring").show();
                   $("#showCollector").hide();
                   populateHoseCode();
               }
           }

            if(reelVal === "C" || reelVal === "HM"){
                populateFrame4Reels(reelVal);
                $("#row2").show();
                $("#row3").hide();
                $("#showCollector").hide();
                $("#showSpring").show();
                $("#showMotor").hide();

                if(reelVal === "C"){
                    $("#showWireCode").show();
                    $("#showHose").hide();
                }
                if (reelVal === "HM"){
                    $("#showHose").show();
                    $("#showWireCode").hide();
                }
            }

            if(reelVal === "P"){
                populateFrame4Reels(reelVal);
                $("#row2").show();
                $("#row3").hide();
                $("#showSpring").hide();
                $("#showCollector").show();
                $("#showMotor").show();
                $("#showHose").hide();
            }

            if(reelVal === "K"){
                populateFrame4Reels(reelVal);
                $("#row2").show();
                $("#row3").hide();
                $("#showSpring").show();
                $("#showCollector").hide();
                $("#showMotor").hide();
                $("#showHose").show();
            }

        });

        function formatAndDisplayPrice(reelPrice){
            var reelQty = Number($("#qty").val());
            $("#perReel").val(reelPrice.toFixed(2));
            $("#totalPriceReel").val((reelQty * Number($("#perReel").val())).toFixed(2));
            var totalCost = Number($("#totalPriceReel").val());
            var firstDisc = Number($("#discount1").val());
            var secondDisc = Number($("#discount2").val());

            if(firstDisc > 0){
                var firstDiscAmt = Number($("#totalPriceReel").val()) * (firstDisc / 100);
                totalCost = totalCost - firstDiscAmt;
                var totalDiscountAmount = Number(firstDiscAmt);
                if(secondDisc > 0){
                    var secondDiscAmt = totalCost * (secondDisc / 100);
                    totalCost = totalCost - secondDiscAmt;
                    totalDiscountAmount = totalDiscountAmount + Number(secondDiscAmt);
                }

                $("#displayDiscount").val(totalDiscountAmount.toFixed(2));
            }
            $("#finalPrice").val(totalCost.toFixed(2));

        }

        function getReelPrice(param){

            $.getJSON("{{url('/getReelPrice').'/'}}" + param,  function(price) {
                console.log(price.price);
                reelPrice = price.price;
                formatAndDisplayPrice(reelPrice);
            });

        }
        function getSpringCollector(param){

            $.getJSON("{{url('/getSpringCollector').'/'}}" + param,  function(springAndCollector){

                var springs = springAndCollector.springs;
                var collector = springAndCollector.collectr;

                $("#springsForReel").find("option:gt(0)").remove();
                $("#collectorReel").find("option:gt(0)").remove();
                $("#motorTMR").find("option:gt(0)").remove();

                $.each(springs, function (index, spring) {
                    if(reelVal === "TMR"){
                        $("#motorTMR").append($('<option>', {
                            value: spring.Motor,
                            text : spring.Motor
                        }));
                    }else if(reelVal === "P"){
                        $("#motorTMR").append($('<option>', {
                            value: spring.Motor,
                            text : spring.Motor
                        }));
                    }else{
                        $("#springsForReel").append($('<option>', {
                            value: spring.Springs,
                            text : spring.Springs
                        }));
                    }

                });

                if(reelVal === "C"){
                    $.each(collector, function (index, collectors) {
                        $("#wireCode").append($('<option>', {
                            value: collectors.Wire,
                            text: collectors.Wire
                        }));

                    });
                }else if(reelVal === "HM"){ //hose
                    $.each(collector, function (index, collectors) {
                        $("#hose").append($('<option>', {
                            value: collectors.Hose,
                            text: collectors.Hose
                        }));

                    });
                } else if(reelVal === "K"){
                    $.each(collector, function (index, collectors) {
                        $("#hose").append($('<option>', {
                            value: collectors.HoseID,
                            text: collectors.HoseID
                        }));

                    });
                }else{
                    $.each(collector, function (index, collectors) {
                        $("#collectorReel").append($('<option>', {
                            value: collectors.Collector,
                            text: collectors.Collector
                        }));

                    });
                }


            });
        }

        function getSeletedValues(){
            frameValue = $("#frames").val();
            gearChoice = $("#gearRatio").val();
            spoolType = $("#spoolType").val();
            springs_Reel = $("#springsForReel").val();
            collectorReel = $("#collectorReel").val();
            hoseValue = $("#hose").val();
            motorTMR = $("#motorTMR").val();
            chainRatio = $("#chainRatio").val();
            wireCode = $("#wireCode").val();
            spoolDiam = $("#spooldiam").val();
            geared_reels = $('input[name=geared-reels]:checked').val();
            reverse_rotate = $('input[name=reverse-rotate]:checked').val();
            harzard_duty = $('input[name=harzard-duty]:checked').val();
            springWidth = $('#springWidth').val();
            quantity = $("#qty").val();
            firstDiscount = $("#discount1").val();
            secondDiscount = $("#discount2").val();

            if (springWidth === "") {
                springWidth = "0";
            }
            if (hoseValue === "") {
                hoseValue = "0";
            }
            if(gearChoice === ""){
                gearChoice = "0";
            }
            if(frameValue === ""){
                frameValue = "0";
            }
            if(spoolType === ""){
                spoolType = "0";
            }
            if(springs_Reel === ""){
                springs_Reel = "0";
            }
            if(collectorReel === ""){
                collectorReel = "0";
            }
            if(motorTMR === ""){
                motorTMR = "0";
            }
            if(spoolDiam === ""){
                spoolDiam = "0";
            }
            if(chainRatio == ""){
                chainRatio = "0";
            }
            if(wireCode == ""){
                wireCode = "0";
            }
            param = frameValue + '/' + reelVal + '/' + springs_Reel + '/' + geared_reels + '/' + collectorReel + '/' + springWidth + '/' + hoseValue + '/' + reverse_rotate + '/' + harzard_duty +'/'+gearChoice+'/'+motorTMR+'/'+spoolType+'/'+spoolDiam+'/'+chainRatio+'/'+wireCode;
        }

        $("#frames").on('change', function(){
           frameValue = this.value;
            getSeletedValues();
            $("#hose").find("option:gt(0)").remove();

            if(frameValue >= 24 && springs_Reel >= 800 && (reelVal === "UE" || reelVal === "UH")){
                $("#gearRatiodiv").show();
            }else {
                $("#gearRatiodiv").hide();
            }

            if(reelVal === "S" && frameValue >= 21){
                $('input[name="geared-reels"][value="Yes"]').prop('disabled', false);
            }

            if(reelVal === "UH"){
                populateHoseCode();
            }

           var reelType = reelVal;
           var sendData = frameValue + '/'+reelType;

            getSpringCollector(sendData);

            if(frameValue !== "0"){
                if(collectorReel !== "0" && springs_Reel !== "0" ) {
                    getReelPrice(param);
                }
                if(collectorReel !== "0" && motorTMR !== "0"){
                    getReelPrice(param);
                }
                if(springs_Reel !== "0" && wireCode !== "0"){
                    getReelPrice(param);
                }
                if(springs_Reel !== "0" && hoseValue !== "0"){
                    getReelPrice(param);
                }
            }


        });//End of event handler

        $("#spoolType").on('change', function () {
            spoolType = this.value;
            var sendData = spoolType + '/'+reelVal;
            $("#perReel").val("");
            $("#totalPriceReel").val("");
            $("#displayDiscount").val("");
            $("#finalPrice").val("");

            switch (spoolType){
                case "R":
                    $("#springWidth").find("option:gt(0)").remove();
                    $("#spooldiam").find("option:gt(0)").remove();
                    populateSpoolWidth(spoolType);
                    populateSpoolDiam();
                    remove60_72();
                    break;
                case "M":
                    $("#springWidth").find("option:gt(0)").remove();
                    $("#spooldiam").find("option:gt(0)").remove();
                    populateSpoolWidth(spoolType);
                    populateSpoolDiam();
                    break;
            }
            getSpringCollector(sendData);

            getSeletedValues();
            //Get Reel price
            if(spoolType !== "0" && springs_Reel !== "0" && collectorReel !== "0" && springWidth !== "0" && spoolDiam !== "0"){

                getReelPrice(param);
            }

            if(spoolType !== "0" && collectorReel !== "0" && springWidth !== "0" && spoolDiam !== "0" && chainRatio !== "0" && motorTMR !== "0"){
                getReelPrice(param);
            }
        });

        $("#springsForReel").on('change', function () {

            getSeletedValues();
            if(frameValue >= 24 && springs_Reel >= 800 && (reelVal === "UE" || reelVal === "UH")){
                $("#gearRatiodiv").show();
            }else {
                $("#gearRatiodiv").hide();
            }

            if(reelVal !== "UE" && reelVal !== "UH"){
                if(collectorReel !== "" && frameValue !== "" && springs_Reel !== "" ) { //S,MMD

                    getReelPrice(param);
                }
            }

            if(spoolType !== "0" && springs_Reel !== "0" && collectorReel !== "0" && springWidth !== "0" && spoolDiam !== "0"){
                getReelPrice(param);
            }

            if(frameValue !== "0" && springs_Reel !== "0" && wireCode !== "0"){
                getReelPrice(param);
            }

            if(frameValue !== "0" && springs_Reel !== "0" && hoseValue !== "0"){
                getReelPrice(param);
                $("#discount1").prop('disabled', false);
            }

        });

        $("#collectorReel").on('change', function(){
            getSeletedValues();
            if(reelVal !== "UE" && reelVal !== "UH"){
                getReelPrice(param);
                $("#discount1").prop('disabled', false);
            }
            if(spoolType !== "0" && springs_Reel !== "0" && collectorReel !== "0" && springWidth !== "0" && spoolDiam !== "0"){
                getReelPrice(param);
            }

            if(spoolType !== "0" && collectorReel !== "0" && springWidth !== "0" && spoolDiam !== "0" && chainRatio !== "0" && motorTMR !== "0"){
                getReelPrice(param);
            }
        });

        $('#springWidth').on('change', function(){
            getSeletedValues();

            if(reelVal === "UE"){
                if(frameValue !== "0" && springs_Reel !== "0" && collectorReel !== "0"){
                    getReelPrice(param);
                    $("#discount1").prop('disabled', false);

                }
            }
            if(reelVal === "UH"){
                if(frameValue !== "0" && springs_Reel !== "0" && hoseValue !== "0"){
                    getReelPrice(param);
                    $("#discount1").prop('disabled', false);
                }
            }
            if(spoolType !== "0" && springs_Reel !== "0" && collectorReel !== "0" && springWidth !== "0" && spoolDiam !== "0"){
                getReelPrice(param);
            }

            if(spoolType !== "0" && collectorReel !== "0" && springWidth !== "0" && spoolDiam !== "0" && chainRatio !== "0" && motorTMR !== "0"){
                getReelPrice(param);
            }
        });

        $('#spooldiam').on('change', function () {
            getSeletedValues();
            if(spoolType !== "0" && springs_Reel !== "0" && collectorReel !== "0" && springWidth !== "0" && spoolDiam !== "0"){
                getReelPrice(param);
            }

            if(spoolType !== "0" && collectorReel !== "0" && springWidth !== "0" && spoolDiam !== "0" && chainRatio !== "0" && motorTMR !== "0"){
                getReelPrice(param);
            }
        });


        $("#collectorReel").on('click', function(){
            getSeletedValues();

            if(frameValue !== "0" && (springs_Reel !== "0" || motorTMR !== "0")){
                if(reelVal !== "UE" && reelVal !== "UH"){
                    getReelPrice(param);
                    $("#discount1").prop('disabled', false);
                }
            }

        });

        $("#hose").on('change', function(){
            getSeletedValues();

            if(frameValue !== "" && springs_Reel !== ""){
                getReelPrice(param);
                $("#discount1").prop('disabled', false);
            }

            if(frameValue !== "0" && springs_Reel !== "0" && hoseValue !== "0"){
                getReelPrice(param);
                $("#discount1").prop('disabled', false);
            }
        });
        $("#motorTMR").on('change', function(){
            getSeletedValues();
            if(frameValue !== "0"){
                if(collectorReel !== "0" && motorTMR !== "0"){
                    getReelPrice(param);
                }
            }

            if(spoolType !== "0" && collectorReel !== "0" && springWidth !== "0" && spoolDiam !== "0" && chainRatio !== "0" && motorTMR !== "0"){
                getReelPrice(param);
            }
        });

        $("#wireCode").on('change', function () {
            getSeletedValues();
            if(frameValue !== "0" && springs_Reel !== "0" && wireCode !== "0"){
                getReelPrice(param);
                $("#discount1").prop('disabled', false);
            }
        });

        $('input:radio[name=geared-reels]').change(function () {
            getSeletedValues();

            if(collectorReel !== "" && frameValue !== "" && springs_Reel !== "" ){ //S,MMD

                getReelPrice(param);
            }

        });

        $('input:radio[name=reverse-rotate]').change(function () {
            getSeletedValues();
            if(collectorReel !== "" && frameValue !== "" && springs_Reel !== "" ){ //S,MMD

                getReelPrice(param);
            }
        });

        $('input:radio[name=harzard-duty]').change(function () {
            getSeletedValues();

            if(collectorReel !== "" && frameValue !== "" && springs_Reel !== "" ){ //S,MMD

                getReelPrice(param);
            }
        });

        $("#qty").on('change', function(){
            quantity = this.value;
            formatAndDisplayPrice(reelPrice);

        });

        $("#discount1").on('change', function(){
            firstDiscount = this.value;
            if(Number(firstDiscount) > 0){
                $("#discount2").prop('disabled', false);
                formatAndDisplayPrice(reelPrice);
            }

        });

        $("#discount2").on('change', function(){
            secondDiscount = this.value;
            if(Number(secondDiscount) > 0 && Number(firstDiscount) > 0){
                formatAndDisplayPrice(reelPrice);
            }
        });

    </script>

@stop