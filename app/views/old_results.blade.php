@extends('layouts.master')
@include('modal')

@section('content')
    <form method="post" action="{{url('/reel/printQuote')}}" id="frm">
        <div id="subpage">
            <div>

                <u>
                    The following models meet your application requirements:
                </u>
            </div>
            <div>
                <p>
                    To select/deselect reel(s) to quote, click on the drop-down in "Quote" column and select "R" to quote reel
                    as "Recommended", or "A" to quote as "Alternative".
                    <strong>To generate a quote, at least one reel must be denoted as "Recommended", then click on "Quote Model(s)" button</strong>.
                    Total price shown does not include cable or hose.
                </p>
            </div>
            <div>
                <a class="btn btn-primary" data-toggle="modal" data-target="#calcModal" id="showCalcs">View Calculation Results</a>
                <button type="button" class="btn btn-primary">Sort Models By Cost</button>
                <a class="btn btn-primary" data-toggle="modal" data-target="#invalidModal" id="showInvalidReel">View Invalid Reels</a>
            </div>
            <div class="table-responsive">
                <table class="table" id="reel-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Model Number</th>
                            <th>Cost</th>
                            <th>Width(in)</th>
                            <th>Height(in)</th>
                            <th>Depth(in)</th>
                            <th>Weight(lb)</th>
                            <th>Quote</th>
                        </tr>
                    </thead>
                    <tbody id="valids">
                    <!--01/03/2017 Commented out this section because all valid reels are now being displayed-->
                        {{--<tr>--}}
                            {{--<!--this only prints the first reel in the valid reels array-->--}}
                            {{--<td>1</td>--}}
                            {{--<td>{{$data['application']['appl']}}</td>--}}
                            {{--<td id="modnum">{{$data['vr']['modelNum']}}</td>--}}
                            {{--<td>{{$data['vr']['totalReelPrice']}}</td>--}}
                            {{--<td>{{$data['vr']['dimWidth']}}</td>--}}
                            {{--<td>{{$data['vr']['dimHeight']}}</td>--}}
                            {{--<td>{{$data['vr']['dimDepth']}}</td>--}}
                            {{--<td>{{$data['vr']['modelWgt']}}</td>--}}
                            {{--<td id="quote">--}}
                                {{--<select id="squote" name="squote">--}}
                                    {{--<option value="Select">Select Quote</option>--}}
                                    {{--<option value="A">A</option>--}}
                                    {{--<option value="R">R</option>--}}
                                {{--</select>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    </tbody>
                </table>
            </div>
            <div id="calc-results-bottom">
                <div>
                    <a class="btn btn-primary" data-toggle="modal" data-target="#accessoriesModal" id="showAccessoriesReel">Quote Model(s)</a>
                    <a class="btn btn-primary" data-toggle="modal" data-target="#printQuote" id="showPrintReel">PrintQuote</a>
                </div>
            </div>
        </div>

        <div class="modal fade" id="calcModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Calculation Results</h4>
                    </div>
                    <div class="modal-body" id="calcDataSection">
                    <!--TODO: Missing something? -AG CAI -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>


        <div class="modal fade" id="invalidModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Invalid reels</h4>
                    </div>
                    <div class="modal-body" id="invalidReels">
                        <div class="table-responsive">
                            <table class="table" id="invalid-table">
                                <thead>
                                    <tr>
                                        <th>Reel Model</th>
                                        <th>Invalid Comparment</th>
                                        <th>Invalid Spring Turns</th>
                                        <th>Invalid Torque</th>
                                        <th>Unused Spring Turns</th>
                                    </tr>
                                </thead>
                                <tbody id="invalids">
                                <!--TODO: missing something? -AG CAI -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="accessoriesModal" role="dialog">
            <div class="modal-dialog">
            <?php //print_r($data['vr']['modelNum']);?>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Accessories</h4>
                    </div>
                    <p style="padding-left:0.5em;">Please select the options and accessories you would like to include with the following model:</p>
                    <span style="padding-left:0.5em; color:Red">RECOMMENDED MODEL: <span style="padding-left:1em;" id="modelnumberQuote"></span></span>
                    <div class="modal-body" id="Accessories">

                        <div class="row">
                            <div>
                                <u>Options</u>
                                <br>
                                <table class="table table-hover" style="width: 63%">
                                    <tbody>
                                        <tr>
                                            <td><span style="padding-left:0.5em">Reverse Rotation:</span></td>
                                            <td><input type="radio" name="addRevRot" value="rr" id="addRevRotNo"> No</td>
                                            <td><input type="radio" name="addRevRot" value="rr" id="addRevRotYes"> Yes</td>
                                        </tr>
                                        <tr>
                                            <td><span style="padding-left:0.5em">Hazardous duty:</span></td>
                                            <td><input type="radio" name="hazardous2" value="hd" id="hazardousNo"> No</td>
                                            <td><input type="radio" name="hazardous2" value="rr" id="hazardousYes"> Yes</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <span id="hazardous"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div>
                                <br/>
                                <u>Accessories</u>
                                <br>
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <td><span style="padding-left:0.5em">Roller Guides: </span></td>
                                            <td><input type="radio" name="addrgOption" value="rg" id="addrgNo"/> No</td>
                                            <td><input type="radio" name="addrgOption" value="rr" id="addrgYes"/> Yes</td>
                                            <td>
                                                <select id="rgapp">
                                                    <option value="Horizontal">Horizontal</option>
                                                    <option value="Verticle">Verticle</option>
                                                    <option value="Verticle down">Verticle down</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select id="rgmat">
                                                    <option value="Nylon">Nylon</option>
                                                    <option value="Steel">Steel</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr id="hoopguide">
                                           <td><span style="padding-left:0.5em">Hoop Guides: </span></td>
                                            <td><input type="radio" name="addHoop" value="No" id="addHoop1"/> No</td>
                                            <td id="addHoop3" colspan="3"><input type="radio" name="addHoop" value="Yes" id="addHoop2"> Yes</td>
                                            <td id="showMsgHoop" style="display:none"> <span>Required for 32 frame w/roller guides</span></td>
                                        </tr>
                                        <tr>
                                            <td><span id="addls2" style="padding-left:0.5em">Limit Switch: </span></td>
                                            <td><input type="radio" name="addls" value="rr" id="addlsNo"/> No</td>
                                            <td colspan="3"><input type="radio" name="addls" value="rr" id="addlsYes"/> Yes</td>
                                        </tr>
                                        <tr>
                                            <td><span id="addls2" style="padding-left:0.5em">340 Degree Pivot Base: </span></td>
                                            <td id="hide340db1"><input type="radio" name="340dp" value="hd" id="340dpNo"/> No</td>
                                            <td id="hide340db2" colspan="3"><input type="radio" name="340dp" value="rr" id="340dpYes"/> Yes</td>
                                            <td id="showMsg" colspan="5" style="display:none"> <span>Cannot be used with Vertical rollers guides</span></td>
                                        </tr>
                                        <tr>
                                            <td><span id="adddnr2" style="padding-left:0.5em">Dog and Ratchet: </span></td>
                                            <td><input type="radio" name="adddnr" value="hd" id="adddnrNo"/> No</td>
                                            <td colspan="3"><input type="radio" name="adddnr" value="rr" id="adddnrYes"/> Yes</td>
                                        </tr>
                                        <tr>
                                            <td><span id="sla2" style="padding-left:0.5em">Spool Lock Assembly: </span></td>
                                            <td><input type="radio" name="sla" value="No" id="slaNo"/> No</td>
                                            <td colspan="3"><input type="radio" name="sla" value="Yes" id="slaYes"/> Yes</td>
                                        </tr>
                                        <tr>
                                            <td><span id="addbsa" style="padding-left:0.5em">Ball Stop Assembly: </span></td>
                                            <td><input type="radio" name="addbsa" value="No" id="addbsaNo"/> No</td>
                                            <td><input type="radio" name="addbsa" value="Yes" id="addbsaYes"/> Yes</td>
                                            <td colspan="2">Ball Diameter:
                                                <select id="bdiam">
                                                    <option value="3" id="opt-3">3.0</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span id="addcga" style="padding-left:0.5em">Cable Grip Assembly: </span></td>
                                            <td><input type="radio" name="cga" value="No" id="addcgaNo"> No</td>
                                            <td colspan="3"><input type="radio" name="cga" value="Yes" id="addcgaYes">Yes</td>
                                        </tr>
                                    </tbody>
                                </table>
                                    <div class = "row">
                                        <div class="col-sm-3"><button type="button" id="backSearchResult" class="btn btn-default" data-dismiss="modal">Search Results</button></div>
                                        <div class="col-sm-3"><button type="button" class="btn btn-default" id="previousReel"><<< Previous Model</button></div>
                                        <div class="col-sm-3"><button type="button" class="btn btn-default" id="nextReel">Next Model >>></button></div>
                                        <a class="btn btn-primary" data-toggle="modal" data-dismiss="modal" data-target="#printQuote" id="printQuoteButton">Continue</a>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <!--<div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>-->
                </div>

            </div>
        </div><!-- End of #accessoriesModal-->


        <div class="modal fade" id="printQuote" role="dialog">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Print Options</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-sm-6">Number of Reels Required: <input type="number" name="numberOfReels" min="0" max="100" step="1" value="0"></div>
                            <div class="col-sm-6">
                                Quote Prepared By: <input type="text" name="firstname" value="" id="quotePreparer">
                            </div>
                        </div>
                        <div class="row">
                            <br>
                            <p>RE:</p>
                            <textarea id="quoteNotes" name="quoteNotes" rows="3"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <p>
                                    Discounts for this Quote
                                </p>
                                Reel: <input type="number" name="discountReel" min="0" max="100" step="1" value="0">
                                % off, plus additional <input type="number" name="addDiscount" min="0" max="100" step="1" value="0"> % off.
                            </div>
                            <div class="col-sm-6">
                                <p>Quote Setup</p>
                                <input type="checkbox" name="quotesetup" value="showDisc">Show Discount(s) on quote<br>
                                <input type="checkbox" name="quotesetup" value="showItemized">Show itemized prices on
                                quote<br>
                                <input type="checkbox" name="quotesetup" value="includeCable">Include cable in quote<br>
                                <input type="checkbox" name="quotesetup" value="includeInstall">Include cable
                                installation<br>
                                <input type="checkbox" name="quotesetup" value="showReelDescription">Show reel
                                description<br>
                            </div>

                        </div>
                        <div class="row" style="margin-top:10px;margin-bottom:10px;">
                            <b>Extra Cable:</b> Note: cable for hookup and safety wrap(s) is already accounted
                            for:<input type="number" name="extraCable" min="0" max="1000" step="1" value="0">
                        </div>

                        <div class="row">
                            <p><b>Quote Format:</b></p>
                            <input type="radio" name="format" value="pdf"> PDF<br>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" id="submit"/>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <input type="hidden" id="str_var" name="str_var" value="<?php print base64_encode(serialize($data)) ?>">;
    </form>


@stop
@section('scripts')
    <script>
        //pre-load script
        $("#rgapp").hide();
        $("#rgmat").hide();
        //$("#bdiam").hide();
        //$("#ls").hide();
        //$("#dnr").hide();
        $("#showPrintReel").hide();
        //get valid reel
        //var reelType = modelNo.substring(0,1);
        //alert(reelType);
        var modelNo; var reelType; var frame; var quoteArray = []; var calcData3 = []; var count;//var validReel = [];

        modelNo = $('#modelnumber').text();
        reelType = modelNo.substring(0,1);
        //alert(reelType);

        $(document).ready(function () {

            //these functions disable the printquote and addAccesory buttons
           $('#showAccessoriesReel').prop('disabled', true);

            <!--todo: I had to add an equal sign to the line below in order to get rid of a syntax error that was causing problems... figure out why it didnt cause syntax problems before. Everything was working with it omitted until today Dec 19 2016.-->
           frame = <?php echo json_encode($data['vr']['frame']);?>;
            if (frame == "14") {
                $('#sla2').append("<b> -- Not available for this frame size.</b>");
                $('#hazardous').append("<b> -- Not available for this frame size.</b>");
                $("#sla").attr("disabled", true);
                $("#hazardous2").attr("disabled", true);
            }
        });

        $('#reel-table tbody tr').on('click', function () {
            $('#reel-table tr').removeClass('cust-selected');
            $(this).addClass('cust-selected');
        });

        $('#addRevRot').on('change', function () {
            str = $('#modelnumber').text();
            if (str.indexOf('R') > -1) {
                str3 = <?php echo json_encode($data['vr']['modelNum'])?>;
                $('#modelnumber').text(str3);
                $('#modnum').text(str3);

            } else {

                strArr = str.split('');
                tempArr = strArr;
                pos = 0;
                for (i = 0; i < strArr.length; i++) {
                    if (strArr[i] == '-') {
                        pos = i;
                        break;
                    }
                }
                str2 = str.slice(0, pos) + 'R' + str.slice(pos);
                $('#modelnumber').text(str2);
                $('#modnum').text(str2);
            }
        });

        $(document).ready(function () {
            $('input:radio').change(function () {
                var selValue = $('input[name=addrgOption]:checked').val();
                if(selValue == 'rg'){
                    $("#rgapp").hide();
                    $("#rgmat").hide();
                }

                if(selValue == 'rr'){
                    $("#rgapp").show();
                    $("#rgmat").show();
                }
            });

        });


        $('#addbsa').on('change', function () {
            if ($('#bdiam').is(":visible")) {
                $("#bdiam").hide();
            } else {
                $("#bdiam").show();
            }
        });

        $('#addls').on('change', function () {

            if ($('#adddnr3').is(":visible")) {
                $("#adddnr3").remove();
                $("#adddnr").attr("disabled", false);
            } else {
                $("#adddnr").attr("disabled", true);
                $("#adddnr2").append("<b id=\"adddnr3\"> -- Not available with Limit Switch</b>");
            }
        });

        $('#adddnr').on('change', function () {
            if ($('#addls3').is(":visible")) {
                $("#addls3").remove();
                $("#addls").attr("disabled", false);
            } else {
                $("#addls").attr("disabled", true);
                $("#addls2").append("<b id=\"addls3\"> -- Not available with Dog and Ratchet</b>");
            }
        });

        $(document).ready(
                $("#showCalcs").click(function () {
                    calcData = <?php echo json_encode($data['calcResultData']);?>;
                    $("#calcDataSection").html(calcData).load();
                }));

        var count = 0;
        $(document).ready(
                $("#showInvalidReel").click(function () {
                    calcData2 = <?php echo json_encode($data['invalidArray']);?>;
                    var html = '';
                    for (var i = 0; i < calcData2.length; i++) {
                        // add opening <tr> tag to the string:
                        html += '<tr>';
                        html += '<td>' + calcData2[i]['invalidReel'] + '</td>';
                        for (var j = 0; j < 4; j++) {
                            //if reason is 3, its torque was invalid.
                            if (j == 2 && calcData2[i]['reason'] == 3) {
                                html += '<td>X' + '</td>'
                            }
                            //if reason is 4, unused spring turns..
                            if (j == 3 && calcData2[i]['reason'] == 4) {
                                html += '<td>X' + '</td>'
                            }
                            html += '<td> ' + '</td>'
                        }
                        html += '</tr>';
                    }
                    count = 0;
                    $('#invalids').append(html);
                }));


        /* *

        Sanning implimentation of functionality from QUOTE.FRM, regarding the second menu (ShowQuote Modal)/
         */

        //locks name of quote preparer at 30
        $(document).ready(

            $("#quotePreparer").on("keyup", function(){

                var string = $("#quotePreparer").val();
                if(string.length > 30){

                    alert("Max length for Quote Preparer Name: 30 characters. You have entered " + string.length + " characters");
                }

            })

        );






        //todo:resume this block on Dec 20
        $(document).ready(function() {
            calcData3 = <?php echo json_encode($data['validArray']);?>;
            AppType = <?php echo json_encode($data['application']['appl']);?>;
            var html = '';
            //for (var i = 0; i < calcData3.length; i++) {
            //todo: currently AppType will always be the same and will not update for different results. This should only be a problem if multiple types of reels are searched at once, which is not yet supported
            count = 1;
            for(var validReelKey in calcData3)
            {
                // add opening <tr> tag to the string:
                var validReel = calcData3[validReelKey];
                html += '<tr id="row'+(count)+'">';
                html += '<td>' + (count) + '</td>';
//                html += '<td>' + calcData3[0]['totalReelPrice'] + '</td>';
//                html += '<td>' + calcData3[0]['dimWidth'] + '</td>';
//                html += '<td>' + calcData3[0]['dimHeight'] + '</td>';
//                html += '<td>' + calcData3[0]['dimDepth'] + '</td>';
//                html += '<td>' + calcData3[0]['modelWgt'] + '</td>';
                html += '<td>' + AppType + '</td>';
                html += '<td>' + validReel.modelNum + '</td>';
                html += '<td>' + validReel['totalReelPrice'] + '</td>';
                html += '<td>' + validReel['dimWidth'] + '</td>';
                html += '<td>' + validReel['dimHeight'] + '</td>';
                html += '<td>' + validReel['dimDepth'] + '</td>';
                html += '<td>' + validReel['modelWgt'] + '</td>';
                html += '<td id="quote'+(count)+'">';
                html += '<select id="squote'+(count)+'" name="squote">';
                html += '<option value="Select">Select Quote</option>';
                html += '<option value="A">A</option>';
                html += '<option value="R">R</option>';
                html += '</select>';
                html += '</td>';
                //html += '<td style="display:none">';
                //html += '<input type="hidden" id="'+(count)+'">';
                //html += '</td>';
                html += '</tr>';
                validReel['ID'] = count;
                count++;
            }
            //}
            console.log(html + "hello world");
            console.log(calcData3);

            //console.log(calcData10);
            $('#valids').append(html);
            //end valid reel print
            //lert("SQuote value: " + $('#squote').val());
        });

        //Enable Quote Model(s) button only if the user selected "R". Populate a quoteArray with all selected Reels to quote.
        $(document).ready(function(){

            //get the value of cable thick
            var cable = <?php echo json_encode($data['cable']);?>;
            var cableThick = cable.thickness;
            cableThick = Number(cableThick);

            //Variable to hold the series for the validReel type
            var series;

            //Remove opts in bdiam
            $("#opt-3").remove();
            $("#opt-35").remove();

            //check the value of cableThick and populate bdiam dropdown accordingly
            if(cableThick < 0.75){
                $('#bdiam')
                    .find('option')
                    .end()
                    .append('<option value="3" selected="selected" id ="opt-3">3.0</option>');
            }else if(cableThick <= 1.3){
                    $('#bdiam')
                        .find('option')
                        .end()
                        .append('<option value="3" selected="selected" id ="opt-3">3.0</option>'
                        + '<option value="3.5" id="opt-35">3.5</option>');
            }else{
                $('#bdiam')
                    .find('option')
                    .end()
                    .append('<option value="3.5" selected="selected" id="opt-35">3.5</option>');
            }


            var total = count - 1;
            $('select').on('change', function(){
                var quoteArrayLength = quoteArray.length;
                for(i = 1; i <= total; i++){

                    if($("#squote" + i).val() == "R"){

                        //var modelNumfromCalc3 = calcData3[i].modelNum;
                        if(quoteArray.length == 0){
                            quoteArray.push(calcData3[i]);
                        }else{
                            var modelNumfromCalc3 = calcData3[i].modelNum;
                            for(x = quoteArray.length - 1; x >= 0; x--) {
                                quoteArray.push(calcData3[i]);
                            }
                        }
                        quoteArray = unique(quoteArray);//Remove duplicates
                        console.log(quoteArray);
                        console.log(quoteArray.length);
                        $('#showAccessoriesReel').removeClass('disabled');
                        $('#showAccessoriesReel').prop('disabled', false);
                    }
                }//End of for statement

                //Display the first element of the quoteArray on the Accessories form and get the series (Reel type)
                $('#modelnumberQuote').html(quoteArray[0].modelNum);
                $('#modelnumberQuote2').html(quoteArray[0].modelNum);

                series = quoteArray[0].series;

                if(quoteArray.length == 1){
                    $("#nextReel").prop('disabled', true);
                    $("#previousReel").prop('disabled', true);
                }else{
                    $("#nextReel").prop('disabled', false);
                    $("#previousReel").prop('disabled', true);
                }

            });//End of eventHandler for select

            //Function to remove duplicate from an array.
            function unique(list) {
                var result = [];
                $.each(list, function(i, e) {
                    if ($.inArray(e, result) == -1) result.push(e);
                });
                return result;
            }

            function setOPTChoices(series, cableThick){
                //Set all "No" options to true
                $("input[name='addRevRot'][value='Yes']").prop('checked', true);
            }

            //Move to next element of the array if there are more elements
            $("#nextReel").on("click", function(){
                //get length of the quoteArray
                var arrayLength = quoteArray.length;

                //get the current element in the #modelnumberQuote
                var currentQuotedReel = $('#modelnumberQuote').html();

                //Get the index of  the current element in the array
                var indexOfCurrentReel = -1
                for(i = 0; i < quoteArray.length; i++){
                    if(quoteArray[i].modelNum == currentQuotedReel){
                        indexOfCurrentReel = i;
                        break;
                    }
                }

                ++indexOfCurrentReel; //get index of the next element
                //Move to the next element in the array if current index is less than quoteArray length
                if(indexOfCurrentReel < quoteArray.length){
                    $('#modelnumberQuote').html(quoteArray[indexOfCurrentReel].modelNum);
                    series = quoteArray[indexOfCurrentReel].series;

                    $("#previousReel").prop('disabled', false);

                    if(indexOfCurrentReel == quoteArray.length - 1){
                        $("#nextReel").prop('disabled', true);
                        $("#previousReel").prop('disabled', false);
                    }
                }
            });

            //Move to the previous element of the array if there is.
            $("#previousReel").on("click", function(){
                //get length of the quoteArray
                var arrayLength = quoteArray.length;

                //get the current element in the #modelnumberQuote
                var currentQuotedReel = $('#modelnumberQuote').html();

                var indexOfCurrentReel = -1
                for(i = 0; i < quoteArray.length; i++){
                    if(quoteArray[i].modelNum == currentQuotedReel){
                        indexOfCurrentReel = i;
                        break;
                    }
                }

                --indexOfCurrentReel;//get index of the previous element
                //Move to the next element in the array if current index is less than quoteArray length
                if(indexOfCurrentReel < quoteArray.length){
                    $('#modelnumberQuote').html(quoteArray[indexOfCurrentReel].modelNum);
                    series = quoteArray[indexOfCurrentReel].series;

                    $("#nextReel").prop('disabled', false);

                    if(indexOfCurrentReel == 0){
                        $("#nextReel").prop('disabled', false);
                        $("#previousReel").prop('disabled', true);
                    }
                }

            });


            //hide 340 degrees pivot base if its U Reel
            $('#rgapp').on('change', function(){

                if(reelType == "U"){
                    if ($('#rgapp').val() == "Verticle"){
                        $("#hide340db1").hide();
                        $("#hide340db2").hide();
                        $('#showMsg').show();
                    }else{
                        $("#hide340db1").show();
                        $("#hide340db2").show();
                        $('#showMsg').hide();
                    }
                }
            });

            $('#rgmat').on('change', function(){
                if(reelType == "S"){
                    if(frame == "32" && $('#rgmat').val() == "Steel"){
                        $("input[name='addHoop'][value='Yes']").prop('checked', true);
                        $("input[name='addHoop'][value='No']").prop('disabled', true);
                        $("#addHoop3").prop("colspan", 2);
                        $("#showMsgHoop").show();
                    }else{
                        $("input[name='addHoop'][value='Yes']").prop('checked', false);
                        $("input[name='addHoop'][value='No']").prop('checked', false);
                        $("#addHoop3").prop("colspan", 3);
                        $("#showMsgHoop").hide();
                    }
                }
            });
        });

        $('#invalidModal').on('hidden.bs.modal', function () {
            $('#invalid-table tbody').empty();
        })

        //begin valid reel print
        {{--<tr>--}}
        {{--<td>1</td>--}}
        {{--<td>{{$data['application']['appl']}}</td>--}}
        {{--<td id="modnum">{{$data['vr']['modelNum']}}</td>--}}
        {{--<td>{{$data['vr']['totalReelPrice']}}</td>--}}
        {{--<td>{{$data['vr']['dimWidth']}}</td>--}}
        {{--<td>{{$data['vr']['dimHeight']}}</td>--}}
        {{--<td>{{$data['vr']['dimDepth']}}</td>--}}
        {{--<td>{{$data['vr']['modelWgt']}}</td>--}}
        {{--<td id="quote">--}}
        {{--<select id="squote" name="squote">--}}
        {{--<option value="Select">Select Quote</option>--}}
        {{--<option value="A">A</option>--}}
        {{--<option value="R">R</option>--}}
        {{--</select>--}}
        {{--</td>--}}
        {{--</tr>--}}


    </script>
@stop