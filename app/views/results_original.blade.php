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
                    To select/deselect reel(s) to quote, position cursor in "Quote" column and click one to quote reel
                    as "Recommended" (denoted as 'R'), twice to quote as "Alternative" (denoted as 'A').
                    To generate a quote, at least one reel must be denoted as "Recommended".
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
                    <a class="btn btn-primary" data-toggle="modal" data-target="#accessoriesModal" id="showAccessoriesReel">Add Accessories</a>
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

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Accessories</h4>
                    </div>
                    <h3 style="padding-left:5em;" id="modelnumber">
                        <?php
                        print_r($data['vr']['modelNum']);
                        ?>
                    </h3>
                    <div class="modal-body" id="Accessories">

                        <div class="row">
                            <div>
                                <u>Options</u>
                                <br>
                                <input type="checkbox" name="accessories-checkboxes[]" value="rr" id="addRevRot">Add
                                Reverse Rotation<br>
                                <input type="checkbox" name="accessories-checkboxes[]" value="hd" id="hazardous2"><span
                                        id="hazardous">Add Hazardous duty</span><br>
                            </div>
                        </div>

                        <div class="row">
                            <div>
                                <u>Accessories</u>
                                <br>
                                <div>
                                    <input type="checkbox" name="accessories-checkboxes[]" value="rg" id="addrg"/>Add Roller Guides
                                    <select id="rgapp">
                                        <option value="h">Horizontal</option>
                                        <option value="v">Verticle</option>
                                        <option value="vd">Verticle down</option>
                                    </select>
                                    <select id="rgmat">
                                        <option value="h">Nylon</option>
                                    </select>
                                </div>
                                <input type="checkbox" name="accessories-checkboxes[]" value="hd" id="addHoop"/>Add Hoop Guides<br>
                                <div>
                                    <input type="checkbox" name="accessories-checkboxes[]" value="rr" id="addls"/><span id="addls2">Add Limit Switch</span>
                                </div>
                                <input type="checkbox" name="accessories-checkboxes[]" value="hd" id="340dp"/>Add 340 Degree Pivot Base<br>
                                <div>
                                    <input type="checkbox" name="accessories-checkboxes[]" value="dar" id="adddnr"/><span id="adddnr2">Add Dog and Ratchet</span>
                                </div>
                                <input type="checkbox" name="accessories-checkboxes[]" value="sla" id="sla"/><span id="sla2">Add Spool Lock Assembly</span>
                                <div>
                                    <input type="checkbox" name="accessories-checkboxes[]" value="bsa" id="addbsa"/><span>Add Ball Stop Assembly</span>
                                    <select id="bdiam">
                                        <option value="3">3.0</option>
                                    </select>
                                </div>
                                <input type="checkbox" name="vehicle" value="hd" id="addcga">Add Cable Grip Assembly<br>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
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
                                Quote Prepared By: <input type="text" name="firstname" value="">
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
        $("#bdiam").hide();
        $("#ls").hide();
        $("#dnr").hide();
        $(document).ready(function () {

            //these functions disable the printquote and addAccesory buttons
           $('#showAccessoriesReel').prop('disabled', false);
            $('#showPrintReel').prop('disabled', false);
            //$('#showAccessoriesReel').addClass('disabled');
            //$('#showPrintReel').addClass('disabled');

            <!--todo: I had to add an equal sign to the line below in order to get rid of a syntax error that was causing problems... figure out why it didnt cause syntax problems before. Everything was working with it omitted until today Dec 19 2016.-->
           var frame = <?php echo json_encode($data['vr']['frame']);?>;
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

        $('#squote').on('change', function () {
            if ($('#squote').val() == "R") {

                $('#showAccessoriesReel').removeClass('disabled');
                $('#showPrintReel').removeClass('disabled');
                $('#showAccessoriesReel').prop('disabled', false);
                $('#showPrintReel').prop('disabled', false);
            }
            else {
                $('#showAccessoriesReel').prop('disabled', true);
                $('#showPrintReel').prop('disabled', true);
                $('#showAccessoriesReel').addClass('disabled');
                $('#showPrintReel').addClass('disabled');
            }
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

        $('#addrg').on('change', function () {

            if ($('#rgapp').is(":visible")) {
                $("#rgapp").hide();
                $("#rgmat").hide();
            }
            else {
                $("#rgapp").show();
                $("#rgmat").show();
            }
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

        //todo:resume this block on Dec 20
        $(document).ready(function() {
            calcData3 = <?php echo json_encode($data['validArray']);?>;
            AppType = <?php echo json_encode($data['application']['appl']);?>;
            var html = '';
            //for (var i = 0; i < calcData3.length; i++) {
            //todo: currently AppType will always be the same and will not update for different results. This should only be a problem if multiple types of reels are searched at once, which is not yet supported
            var count = 1;
            for(var validReelKey in calcData3)
            {
                // add opening <tr> tag to the string:
                var validReel = calcData3[validReelKey];
                html += '<tr>';
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
                html += '<td id="quote">';
                html += '<select id="squote" name="squote">';
                html += '<option value="Select">Select Quote</option>';
                html += '<option value="A">A</option>';
                html += '<option value="R">R</option>';
                html += '</select>';
                html += '</td>';
                html += '</tr>';
                count++;
            }
            //}
            console.log(html + "hello world");
            $('#valids').append(html);
            //end valid reel print
        });

        $('#invalidModal').on('hidden.bs.modal', function () {
            $('#invalid-table tbody').empty();
        })

    </script>
@stop