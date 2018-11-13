@extends('layouts.master')
@include('modal')

@section('content')
    <form method="post" action="{{url('/reel/printQuote')}}" id="frm" target="_blank">
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
                    <!--<a class="btn btn-primary" data-toggle="modal" data-target="#printQuote" id="showPrintReel">PrintQuote</a>-->
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
                    <span style="padding-left:1em;" id="modelnumberQuote"></span><input id="modelNumDisplayed" type="hidden"/>
                    <div class="modal-body" id="Accessories">

                        <div class="row">
                            <div>
                                <u>Options</u>
                                <br>
                                <table class="table table-hover" style="width: 63%">
                                    <tbody>
                                        <tr>
                                            <td><span style="padding-left:0.5em">Reverse Rotation:</span></td>
                                            <td id="hideRR1"><input type="radio" name="addRevRot" value="No" id="addRevRotNo"> No</td>
                                            <td id="hideRR2"><input type="radio" name="addRevRot" value="Yes" id="addRevRotYes"> Yes</td>
                                            <td id="showMsgRR" colspan="2" style="display:none"> <span id="RRMsg"></span></td>
                                        </tr>
                                        <tr>
                                            <td><span style="padding-left:0.5em">Hazardous duty:</span></td>
                                            <td id="hideHazard1"><input type="radio" name="hazardous2" value="No" id="hazardousNo"> No</td>
                                            <td id="hideHazard2"><input type="radio" name="hazardous2" value="Yes" id="hazardousYes"> Yes</td>
                                            <td id="showMsgHazard" colspan="2" style="display:none"> <span id="hazardMsg"></span></td>
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
                                            <td id="hideRG1"><input type="radio" name="addrgOption" value="No" id="addrgNo"/> No</td>
                                            <td id="hideRG2"><input type="radio" name="addrgOption" value="Yes" id="addrgYes"/> Yes</td>
                                            <td id="hideRG3">
                                                <div class="form-group" id="rgAppDIV">
                                                    <input type="radio" name="rgapp" value="horizontal" checked />Horizontal <br/>
                                                    <input type="radio" name="rgapp" value="vertical" />Vertical <br/>
                                                    <input type="radio" name="rgapp" value="verticalDown" />Vertical Down
                                                   <!-- <select class="form-control" id="rgapp" onchange="javascript:return false;">
                                                        <option value="horizontal" id="horizontal" class="active">Horizontal</option>
                                                        <option value="vertical" id="vertical">Vertical</option>
                                                        <option value="verticalDown" id="verticalDown">Vertical Down</option>
                                                    </select>-->
                                                </div>

                                            </td>
                                            <td id="hideRG4">
                                                <div class="form-group" id="rgMatDIV">
                                                    <input type="radio" name="rgmat" value="nylon" checked />Nylon <br/>
                                                    <input type="radio" name="rgmat" value="steel" />Steel

                                                <!--<select class="form-control" id="rgmat">
                                                    <option value="Nylon" id="nylon">Nylon</option>
                                                    <option value="Steel" id="steel">Steel</option>
                                                </select>-->
                                                </div>

                                            </td>
                                            <td id="showMsgRG" colspan="4" style="display:none"> <span id="rgMsg"></span></td>
                                        </tr>
                                        <tr id="hoopguide">
                                           <td><span style="padding-left:0.5em">Hoop Guides: </span></td>
                                            <td id="hideHG1"><input type="radio" name="addHoop" value="No" id="addHoop1"/> No</td>
                                            <td id="hideHG2" colspan="3"><input type="radio" name="addHoop" value="Yes" id="addHoop2"> Yes</td>
                                            <td id="showMsgHoop" colspan="4" style="display:none"> <span id="hgMsg"></span></td>
                                        </tr>
                                        <tr>
                                            <td><span id="addls2" style="padding-left:0.5em">Limit Switch: </span></td>
                                            <td id="hideLS1"><input type="radio" name="addls" value="No" id="addlsNo"/> No</td>
                                            <td id="hideLS2" colspan="3"><input type="radio" name="addls" value="Yes" id="addlsYes"/> Yes</td>
                                            <td id="showMsgLS" colspan="4" style="display:none"> <span id="LSMsg"></span></td>
                                        </tr>
                                        <tr>
                                            <td><span id="addls2" style="padding-left:0.5em">340 Degree Pivot Base: </span></td>
                                            <td id="hide340db1"><input type="radio" name="pivotBase340" value="No" id="340dpNo"/> No</td>
                                            <td id="hide340db2" colspan="3"><input type="radio" name="pivotBase340" value="Yes" id="340dpYes"/> Yes</td>
                                            <td id="showMsg340" colspan="4" style="display:none"> <span id="340DPBMsg"></span></td>
                                        </tr>
                                        <tr>
                                            <td><span id="adddnr2" style="padding-left:0.5em">Dog and Ratchet: </span></td>
                                            <td id="hideDR1"><input type="radio" name="adddnr" value="No" id="adddnrNo"/> No</td>
                                            <td id="hideDR2" colspan="3"><input type="radio" name="adddnr" value="Yes" id="adddnrYes"/> Yes</td>
                                            <td id="showMsgDR" colspan="4" style="display:none"> <span id="DRMsg"></span></td>
                                        </tr>
                                        <tr>
                                            <td><span id="sla2" style="padding-left:0.5em">Spool Lock Assembly: </span></td>
                                            <td id="hidesla1"><input type="radio" name="sla" value="No" id="slaNo"/> No</td>
                                            <td id="hidesla2" colspan="3"><input type="radio" name="sla" value="Yes" id="slaYes"/> Yes</td>
                                            <td id="showMsgSLA" colspan="4" style="display:none"> <span id="slaMsg"></span></td>
                                        </tr>
                                        <tr>
                                            <td><span id="addbsa" style="padding-left:0.5em">Ball Stop Assembly: </span></td>
                                            <td id="hideBSA1"><input type="radio" name="addbsa" value="No" id="addbsaNo"/> No</td>
                                            <td id="hideBSA2"><input type="radio" name="addbsa" value="Yes" id="addbsaYes"/> Yes</td>
                                            <td id="hideBSA3" colspan="2"><span id="bdLabel" style="display:none">Ball Diameter:</span>
                                                <div class="form-group" id="bdiamDIV">
                                                    <input type="radio" name="bdiam" value="3" checked />3.0 <br/>
                                                    <!--<select class="form-control" id="bdiam" style="display:none">
                                                    <option value="3" id="opt-3">3.0</option>
                                                </select>-->
                                                </div>

                                            </td>
                                            <td id="showMsgBSA" colspan="4" style="display:none"> <span id="bsaMsg" ></span></td>
                                        </tr>
                                        <tr>
                                            <td><span id="addcga" style="padding-left:0.5em">Cable Grip Assembly: </span></td>
                                            <td id="hideCGA1"><input type="radio" name="cga" value="No" id="addcgaNo"> No</td>
                                            <td id="hideCGA2" colspan="3"><input type="radio" name="cga" value="Yes" id="addcgaYes">Yes</td>
                                            <td id="showMsgCGA" colspan="4" style="display:none"> <span id="cgaMsg"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                    <div class = "row">
                                        <div class="col-sm-3"><button type="button" id="backSearchResult" class="btn btn-primary" data-dismiss="modal">Search Results</button></div>
                                        <div class="col-sm-3"><button type="button" class="btn btn-primary" id="previousReel"><<< Previous Model</button></div>
                                        <div class="col-sm-3"><button type="button" class="btn btn-primary" id="nextReel">Next Model >>></button></div>
                                        <div class="col-sm-3"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#printQuote" id="continue" data-dismiss="modal">Continue</button></div>
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
        <!-- Enter Quote Notes -->
        <div class="modal fade" id="notes" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Enter Notes</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12"><p>In the boxes below, type in any notes you would like to appear in the sections shown:</p></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">Application section: <br/>
                                <textarea id="appSection" name="appNote" rows="3" cols="100"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12"><br/>Cable/Hose: <br/>
                                <textarea id="cableHoseSection" name="pkgNote" rows="3" cols="100"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12"><br/>In BOM Header for model => <select id="noteForModel">
                                    <option value=""></option>
                                </select> <br/>
                                <textarea id="BOMheaderModelSection" name="modNote" rows="3" cols="100"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12"><br/>End of Quote (note: if multiple models quoted, this note will appear after each): <br/>
                                <textarea id="endOfQuoteSection" name="notes" rows="3" cols="100"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6"><br/>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#printQuote" data-dismiss="modal" style="width: 100%; padding: 10px 73px;"> Continue</button>
                            </div>
                            <div class="col-sm-6" style=""><br/>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#printQuote" data-dismiss="modal" style="width: 100%; padding: 10px 70px;"> Cancel </button>
                            </div>
                        </div>
                    </div>
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

                            <div class="col-sm-6">Number of Reels Required: <input type="number" id="numberOfReels" name="numberOfReels" min="0" max="100" step="1" value="1"></div>
                            <div class="col-sm-6">
                                Quote Prepared By: <input type="text" id="preparedBy" name="preparedBy" value="Gleason Quote">
                            </div>
                        </div>
                        <div class="row">
                            <br>
                            RE: <textarea id="quoteNotes" name="quoteNotes" rows="3"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-sm-6" style="width: 60%;">
                                <input type="hidden" name="printQuotedArrays" id="printQuotedArrays"/>
                                    <fieldset class="form-group discounts">
                                        <legend>Discounts for this Quote</legend>
                                            <table border="0" class="discounts">
                                                <tbody>
                                                    <tr id="sReel" style="display: none">
                                                        <td>S Reel:</td> <td><input type="number" id="discountSReel" name="discountSReel" min="0" max="100" step="1" value="0"></td>
                                                        <td>% off, plus additional</td><td><input type="number" id="addDiscountSReel" name="addDiscountSReel" min="0" max="100" step="1" value="0"> % off.</td>
                                                    </tr>
                                                    <tr id="mmdReel" style="display: none">
                                                        <td>MMD Reel:</td> <td><input type="number" id="discountMMDReel" name="discountMMDReel" min="0" max="100" step="1" value="0"></td>
                                                        <td>% off, plus additional</td><td><input type="number" id="addDiscountMMDReel" name="addDiscountMMDReel" min="0" max="100" step="1" value="0"> % off.</td>
                                                    </tr>
                                                    <tr id="smReel" style="display: none">
                                                        <td>SM Reel:</td> <td><input type="number" id="discountSMReel" name="discountSMReel" min="0" max="100" step="1" value="0"></td>
                                                        <td>% off, plus additional</td><td><input type="number" id="addDiscountSMReel" name="addDiscountSMReel" min="0" max="100" step="1" value="0"> % off.</td>
                                                    </tr>
                                                    <tr id="shoReel" style="display: none">
                                                        <td>SHO Reel:</td> <td><input type="number" id="discountSHOReel" name="discountSHOReel" min="0" max="100" step="1" value="0"></td>
                                                        <td>% off, plus additional</td><td><input type="number" id="addDiscountSHOReel" name="addDiscountSHOReel" min="0" max="100" step="1" value="0"> % off.</td>
                                                    </tr>
                                                    <tr id="tmrReel" style="display: none">
                                                        <td>TMR Reel:</td> <td><input type="number" id="discountTMRReel" name="discountTMRReel" min="0" max="100" step="1" value="0"></td>
                                                        <td>% off, plus additional</td><td><input type="number" id="addDiscountTMRReel" name="addDiscountTMRReel" min="0" max="100" step="1" value="0"> % off.</td>
                                                    </tr>
                                                    <tr id="cmReel" style="display: none">
                                                        <td>CM Reel:</td> <td><input type="number" id="discountCMReel" name="discountCMReel" min="0" max="100" step="1" value="0"></td>
                                                        <td>% off, plus additional</td><td><input type="number" id="addDiscountCMReel" name="addDiscountCMReel" min="0" max="100" step="1" value="0"> % off.</td>
                                                    </tr>
                                                    <tr id="uReel" style="display: none">
                                                        <td>U Reel:</td> <td><input type="number" id="discountUReel" name="discountUReel" min="0" max="100" step="1" value="0"></td>
                                                        <td>% off, plus additional</td><td><input type="number" id="addDiscountUReel" name="addDiscountUReel" min="0" max="100" step="1" value="0"> % off.</td>
                                                    </tr>
                                                    <tr id="pendantReel" style="display: none">
                                                        <td>Pendant Reel:</td> <td><input type="number" id="discountPendantReel" name="discountPendantReel" min="0" max="100" step="1" value="0"></td>
                                                        <td>% off, plus additional</td><td><input type="number" id="addDiscountPendantReel" name="addDiscountPendantReel" min="0" max="100" step="1" value="0"> % off.</td>
                                                    </tr>
                                                    <tr id="kReel" style="display: none">
                                                        <td>K Reel:</td> <td><input type="number" id="discountKReel" name="discountKReel" min="0" max="100" step="1" value="0"></td>
                                                        <td>% off, plus additional</td><td><input type="number" id="addDiscountKReel" name="addDiscountKReel" min="0" max="100" step="1" value="0"> % off.</td>
                                                    </tr>
                                                    <tr id="uhReel" style="display: none">
                                                        <td>UH Reel:</td> <td><input type="number" id="discountUHReel" name="discountUHReel" min="0" max="100" step="1" value="0"></td>
                                                        <td>% off, plus additional</td><td><input type="number" id="addDiscountUHReel" name="addDiscountUHReel" min="0" max="100" step="1" value="0"> % off.</td>
                                                    </tr>
                                                    <tr id="hmReel" style="display: none">
                                                        <td>HM Reel:</td> <td><input type="number" id="discountHMReel" name="discountHMReel" min="0" max="100" step="1" value="0"></td>
                                                        <td>% off, plus additional</td><td><input type="number" id="addDiscountHMReel" name="addDiscountHMReel" min="0" max="100" step="1" value="0"> % off.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    </fieldset>
                            </div>
                            <div class="col-sm-6" style="width: 40%;">
                                <fieldset class="form-group discounts">
                                    <legend>Quote Setup</legend>
                                        <div class="form-check">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" id="showDiscount" name="showDiscount" type="checkbox" value="Yes">Show discount(s) on quote
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" id="showItemPrice" name="showItemPrice" type="checkbox" value="Yes">Show itemized prices on quote
                                                        </label>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" id="includeCableQuote" name="includeCableQuote" type="checkbox" value="Yes"><span id="includeCableQuoteLabel"> Include cable in quote</span>
                                                        </label>
                                                    </div>

                                                </li>
                                                <ul class="list-group" id="listItems">
                                                    <li class="list-group-item">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" id="includeCableInstall" name="includeCableInstall" type="checkbox" value="Yes"><span id="includeCableInstallLabel">Include cable installation</span>
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <li class="list-group-item">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" id="showReelDesc" name="showReelDesc" type="checkbox" value="Yes">Show Reel Description
                                                        </label>
                                                    </div>

                                                </li>
                                            </ul>
                                            <span>Attachements: </span>
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" id="includeDimDrwaings" name="includeDimDrwaings" type="checkbox" value="Yes">Include dimensional drawings
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                </fieldset>

                            </div>

                        </div><!-- End of row-->
                        <div class="row" id="NotesInQuote">
                            <div class="pull-right" style="margin-right: 2%">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#notes" data-dismiss="modal" style="width: 100%; padding: 10px 73px;">Enter Notes in Quotes</button>
                            </div>
                        </div>
                        <div class="row" id="extraCable" style="margin-top:10px;margin-bottom:10px;">
                            <fieldset class="form-group discounts">
                                <span id="extraLable"><b>Extra Cable:</b></span> <span id="msg">(Note: cable for hookup and safety wrap(s) is already accounted for) </span>
                                <input type="number" id="extraCableValue" name="extraCableValue" min="0" max="1000" step="1" value="0"> <span id="measure">feet</span>
                            </fieldset>
                        </div>

                        <div class="row" style="width: 50%">
                            <fieldset class="form-group discounts">
                                <legend>Quote Format:</legend>
                                    <label class="radio-inline">
                                        <input class="form-check-input" type="radio" name="quoteFormat" id="pdf" value="pdf" checked> PDF
                                    </label>
                                    <label class="radio-inline">
                                        <input class="form-check-input" type="radio" name="quoteFormat" id="word" value="word"> Word Document
                                    </label>
                            </fieldset>
                        </div>
                    </div>
                    <div class="modal-footer" style="margin-top: 0px">
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
        $("#rgAppDIV").hide();
        $("#rgMatDIV").hide();
        $("#bdiamDIV").hide();
        //$("#bdiam").hide();
        //$("#ls").hide();
        //$("#dnr").hide();
        $("#showPrintReel").hide();
        //get valid reel
        //var reelType = modelNo.substring(0,1);
        //alert(reelType);
        var modelNo; var reelType; var quoteArray = []; var calcData3 = []; var series; var revRotVal; var hazardVal; var rollerGuideVal; var hoopGuideVal; var limitSwitchVal; var pivotBase340Val;
        var dogAndRatchetVal; var spoolLockAssVal; var ballStopAssVal; var cableGripAssVal; var framez; var printQuoteModel = [];


        $(document).ready(function () {

            //these functions disable the printquote and addAccesory buttons
           $('#showAccessoriesReel').prop('disabled', true);

            <!--todo: I had to add an equal sign to the line below in order to get rid of a syntax error that was causing problems... figure out why it didnt cause syntax problems before. Everything was working with it omitted until today Dec 19 2016.-->
           var frame = <?php echo json_encode($data['vr']['frame']);?>;

        });

        $('#reel-table tbody tr').on('click', function () {
            $('#reel-table tr').removeClass('cust-selected');
            $(this).addClass('cust-selected');
        });


        $(document).ready(function () {
            $("#hideRG3").hide();
            function removeMat(){
                $('#nylon').remove();
                $('#steel').remove();
            }

            $('input:radio[name=addrgOption]').change(function () {
                rollerGuideVal = $('input[name=addrgOption]:checked').val();
                if(rollerGuideVal === 'No'){
                    $("#hideRG3").hide();
                    $("#rgAppDIV").hide();
                    $("#rgMatDIV").hide();
                    $("#hideRG4").hide();
                }

                if(rollerGuideVal === 'Yes'){
                    $("#hideRG3").show();
                    $("#rgAppDIV").show();
                    $("#rgMatDIV").show();
                    $("#hideRG4").show();
                }
            });

            $('input:radio[name=addls]').change(function () {

                limitSwitchVal = $('input[name=addls]:checked').val();
                if(limitSwitchVal === "No"){
                    var text = $('#DRMsg').html();
                    text = text.substring(0,7);
                    if(text.indexOf("Cannot") >= 0){
                        $("input[name='adddnr'][value='No']").prop('checked', true);
                        $('#hideDR1').show(); $('#hideDR2').show(); $('#showMsgDR').hide();
                    }
                }
                if(limitSwitchVal === "Yes"){
                    $('#DRMsg').html("Cannot be used with Limit Switch");
                    $('#showMsgDR').show();
                    $('#hideDR1').hide(); $('#hideDR2').hide();
                }
            });

            $('input:radio[name=adddnr]').change(function () {
                dogAndRatchetVal = $('input[name=adddnr]:checked').val();
                if(dogAndRatchetVal === "No"){
                    var text = $('#LSMsg').html();
                    text = text.substring(0,7);
                    if(text.indexOf("Cannot") >= 0) {
                        $("input[name='addls'][value='No']").prop('checked', true);
                        $('#hideLS1').show();
                        $('#hideLS2').show();
                        $('#showMsgLS').hide();
                    }
                }
                if(dogAndRatchetVal === "Yes"){
                    $('#LSMsg').html("Cannot be used with Dog and Ratchet");
                    $('#showMsgLS').show();
                    $('#hideLS1').hide(); $('#hideLS2').hide();
                }
            });

            $('input:radio[name=addbsa]').change(function () {
                ballStopAssVal = $('input[name=addbsa]:checked').val();
                if(ballStopAssVal === "No"){
                    $('#bdLabel').hide();
                    $('#bdiamDIV').hide();
                    $('#hideBSA3').hide();
                }
                if(ballStopAssVal === "Yes"){
                    $('#bdiamDIV').show();
                    $('#bdLabel').show();
                    $('#bsaMsg').html("");
                    $('#showMsgBSA').hide();
                }
            });
            $('input:radio[name=addRevRot]').change(function () {
                revRotVal = $('input[name=addRevRot]:checked').val();
                var modelNo = $('#modelnumberQuote').html();

                if(revRotVal === "No"){

                    if(modelNo.indexOf("R") > 0){
                        var position = modelNo.indexOf("R");//Stating position of R in ModelNo
                        var leftSide = modelNo.substring(0, position);
                        var rightSide = modelNo.substring(position + 1, modelNo.length);
                        var concatModelNo = leftSide + rightSide
                        $('#modelnumberQuote').html(concatModelNo);
                    }
                }
                if(revRotVal === "Yes"){

                    var strArr = modelNo.split('');
                    pos = 0;
                    for (i = 0; i < strArr.length; i++) {
                        if (strArr[i] == '-') {
                            pos = i;
                            break;
                        }
                    }
                    str2 = modelNo.slice(0, pos) + 'R' + modelNo.slice(pos);
                    $('#modelnumberQuote').html(str2);
                }
            });

            $('input:radio[name=hazardous2]').change(function () {
                hazardVal = $('input[name=hazardous2]:checked').val();
                var modelNo = $('#modelnumberQuote').html();

                if(hazardVal === "No"){
                    if(modelNo.indexOf("Z") > 0){
                        var position = modelNo.indexOf("Z");//Stating position of Z in ModelNo
                        var leftSide = modelNo.substring(0, position);
                        var rightSide = modelNo.substring(position + 1, modelNo.length);
                        var concatModelNo = leftSide + rightSide
                        $('#modelnumberQuote').html(concatModelNo);
                    }

                    var text = $('#LSMsg').html();// $('#LSMsg').html("");
                    if(text.indexOf("Limit") >= 0){
                        $('#showMsgLS').hide();
                        $("input[name='addls'][value='No']").prop('checked', true);
                        $('#hideLS1').show(); $('#hideLS2').show();
                    }

                    //removeMat();
                    /*$('#rgmat')
                        .find('option')
                        .end()
                        .append('<option value="Nylon" selected="selected" id ="nylon">Nylon</option>'
                            + '<option value="Steel" id="steel">Steel</option>').val("Nylon");*/
                    $("#rgMatDIV").empty();
                    $("#rgMatDIV").append($('<input type="radio" name="rgmat" value="nylon" checked />Nylon &lt;br />')
                    + $('<input type="radio" name="rgmat" value="steel" checked />Steel'));

                    switch(series){
                        case "S":
                            if(framez === "14"){
                               /* removeMat();
                                $('#rgmat')
                                    .find('option')
                                    .end()
                                    .append('<option value="Nylon" selected="selected" id ="nylon">Nylon</option>').val("Nylon");*/
                                $("#rgMatDIV").empty();
                                $("#rgMatDIV").append($('<input type="radio" name="rgmat" value="nylon" checked />Nylon'));
                            }
                            break;
                        case "SM":
                            removeMat();
                            /*$('#rgmat')
                                .find('option')
                                .end()
                                .append('<option value="Steel" selected="selected" id ="steel">Steel</option>').val("Steel");*/
                            $("#rgMatDIV").empty();
                            $("#rgMatDIV").append($('<input type="radio" name="rgmat" value="steel" checked />Steel'));
                            break;
                        case "UE":
                        case "UH":
                           /* removeMat();
                            $('#rgmat')
                                .find('option')
                                .end()
                                .append('<option value="Nylon" selected="selected" id ="nylon">Nylon</option>').val("Nylon");*/
                            $("#rgMatDIV").empty();
                            $("#rgMatDIV").append($('<input type="radio" name="rgmat" value="nylon" checked />Nylon'));
                            break;
                    }

                }//End of NO value
                if(hazardVal === "Yes"){
                    if(series === "S"){
                        var leftSide = modelNo.substring(0, 1);
                        var rightSide = modelNo.substring(1, modelNo.length);
                        modelNo = leftSide + 'Z' + rightSide;
                        $('#modelnumberQuote').html(modelNo);
                    }

                    if(series === "MMD"){
                        var leftSide = modelNo.substring(0, 3);
                        var rightSide = modelNo.substring(3, modelNo.length);
                        modelNo = leftSide + 'Z' + rightSide;
                        $('#modelnumberQuote').html(modelNo);
                    }

                    /*removeMat();
                    $('#rgmat')
                        .find('option')
                        .end()
                        .append('<option value="Steel" selected="selected" id ="steel">Steel</option>').val("Steel");*/
                    $("#rgMatDIV").empty();
                    $("#rgMatDIV").append($('<input type="radio" name="rgmat" value="steel" checked />Steel'));

                                                                                //$('#bdiam').is(":visible")
                     if($('#showMsgLS').not(':visible')){
                         $("input[name='addls'][value='No']").prop('checked', true);
                         $('#hideLS1').hide(); $('#hideLS2').hide();
                         $('#LSMsg').html("Limit Switch not available with hazardous duty");
                         $('#showMsgLS').show();
                     }
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
            $("#hideRG3").hide();
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
            //console.log(html + "hello world");
            //console.log(calcData3);

            //console.log(calcData10);
            $('#valids').append(html);
            //end valid reel print
            //lert("SQuote value: " + $('#squote').val());
        //});

        //Enable Quote Model(s) button only if the user selected "R". Populate a quoteArray with all selected Reels to quote.
        //$(document).ready(function(){

            //get the value of cable thick
            var cable = <?php echo json_encode($data['cable']);?>;
            var cableThick = cable.thickness;
            cableThick = Number(cableThick);

            //Variable to hold the series, frame for the validReel type
            var frame;

            //check the value of cableThick and populate bdiam dropdown accordingly
            if(cableThick < 0.75){
                /*$('#bdiam')
                    .find('option')
                    .end()
                    .append('<option value="3" selected="selected" id ="opt-3">3.0</option>');*/
                $("#bdiamDIV").empty();
                $("#bdiamDIV").append('<input type="radio" name="bdiam" value="3.0" checked />3.0');

            }else if(cableThick <= 1.3){
                    /*$('#bdiam')
                        .find('option')
                        .end()
                        .append('<option value="3" selected="selected" id ="opt-3">3.0</option>'
                        + '<option value="3.5" id="opt-35">3.5</option>');*/
                $("#bdiamDIV").empty();
                $("#bdiamDIV").append(('<input type="radio" name="bdiam" value="3.0" checked />3.0 <br/>' )
                + ('<input type="radio" name="bdiam" value="3.5" checked />3.5'));
            }else{
               /*$('#bdiam')
                    .find('option')
                    .end()
                    .append('<option value="3.5" selected="selected" id="opt-35">3.5</option>')*/;
                $("#bdiamDIV").empty();
                $("#bdiamDIV").append('<input type="radio" name="bdiam" value="3.5" checked />3.5');
            }

            //Function to remove duplicate from an array.
            function unique(list) {
                var result = [];
                $.each(list, function(i, e) {
                    if ($.inArray(e, result) == -1) result.push(e);
                });
                return result;
            }

            //Get the models quoted as R (Recommended) and A (Alternate) in separate arrays.
            var total = count - 1;
            var R = 0;  recommendedArray = [];  alternateArray = [];
            $('select').on('change', function(){

                for(i = 1; i <= total; i++){

                    if($("#squote" + i).val() === "R"){
                        calcData3[i]["quoteFlag"] = 1;
                        recommendedArray.push(calcData3[i]);
                        R = R + 1;
                        $('#showAccessoriesReel').removeClass('disabled');
                        $('#showAccessoriesReel').prop('disabled', false);
                    }
                    if($("#squote" + i).val() === "A") {
                        calcData3[i]["quoteFlag"] = 2;
                        alternateArray.push(calcData3[i]);
                    }
                }

            });//End of eventHandler for select

          //copy the arrays content into quoteArray.
            $('#showAccessoriesReel').on('click', function(){
                //Copy array content to quotedArray
                if(recommendedArray.length !== 0){
                    for(i = 0; i < recommendedArray.length; i++){
                        quoteArray.push(recommendedArray[i]);
                    }
                }

                if(alternateArray.length !== 0){
                    for(i = 0; i < alternateArray.length; i++){
                        quoteArray.push(alternateArray[i]);
                    }
                }

                //Remove duplicates
                quoteArray = unique(quoteArray);
                console.log(quoteArray);

                //Display the first element of the quoteArray on the Accessories form and get the series (Reel type)
                display = "RECOMMENDED MODEL: " + quoteArray[0].modelNum;
                $("#modelNumDisplayed").val(quoteArray[0].modelNum);
                document.getElementById("modelnumberQuote").style.color = "red";
                $('#modelnumberQuote').html(display); //modelMsg

                series = quoteArray[0].series;
                framez = quoteArray[0].frame;
                setOPTChoices(series, cableThick, framez);

                if(quoteArray.length === 1){
                    $("#nextReel").prop('disabled', true);
                    $("#previousReel").prop('disabled', true);
                }else if (quoteArray.length > 1){
                    $("#nextReel").prop('disabled', false);
                    $("#previousReel").prop('disabled', true);
                }
            });

            function removeMat(){
                $('#nylon').remove();
                $('#steel').remove();
            }


            function setOPTChoices(series, cableThick, frame){
                //Set all "No" options to true
                $("input[name='addRevRot'][value='No']").prop('checked', true);
                $("input[name='hazardous2'][value='No']").prop('checked', true);
                $("input[name='addrgOption'][value='No']").prop('checked', true);
                $("#hideRG3").hide();
                $("#rgAppDIV").hide();
                $("#rgMatDIV").hide();
                $("#hideRG4").hide();
                $("input[name='addHoop'][value='No']").prop('checked', true);
                $("input[name='addls'][value='No']").prop('checked', true);
                $("input[name='pivotBase340'][value='No']").prop('checked', true);
                $("input[name='adddnr'][value='No']").prop('checked', true);
                $("input[name='sla'][value='No']").prop('checked', true);
                $("input[name='addbsa'][value='No']").prop('checked', true);
                $("input[name='cga'][value='No']").prop('checked', true);

                //Set choices for accessory side
                switch (series){
                    case "S":
                        if(frame == "14"){
                            //Remove value from Material dropdown and append only nylon
                           /* removeMat();
                            $('#rgmat')
                                .find('option')
                                .end()
                                .append('<option value="nylon" selected="selected" id="nylon">Nylon</option>')
                                .val("nylon");*/
                            $("#rgMatDIV").empty();
                            $("#rgMatDIV").append('<input type="radio" name="rgmat" value="nylon"/>Nylon');

                            //Hide spool lock assembly and display the message
                            $('#hidesla2').hide(); $('#hidesla1').hide(); $('#slaMsg').html("Not available for this frame for S reels"); $('#showMsgSLA').show();

                            //Hide Hazardous Duty and display message
                            $('#hideHazard1').hide(); $('#hideHazard2').hide(); $('#hazardMsg').html("Not available for this frame for S reels"); $('#showMsgHazard').show();
                        }

                        if(frame == "14" || frame == "16"){
                            $('#hideHG1').hide(); $('#hideHG2').hide(); $('#hgMsg').html("Not available for this frame for S reels"); $('#showMsgHoop').show();
                        }
                        $('#hideRG1').show(); $('#hideRG2').show(); $('#hideRG3').show(); $('#hideRG4').show(); $('#rgMsg').html(""); $('#showMsgRG').hide();
                        $('#hideLS1').show(); $('#hideLS2').show(); $('#LSMsg').html(""); $('#showMsgLS').hide();
                        $('#hide340db1').show(); $('#hide340db2').show(); $('#340DPBMsg').html(""); $('#showmsg340').hide();
                        $('#hideDR1').show(); $('#hideDR2').show(); $('#DRMsg').html(""); $('#showMsgDR').hide();
                        $('#hideBSA1').show(); $('#hideBSA2').show(); $('#hideBSA3').show(); $('#bsaMsg').html(""); $('#showMsgBSA').hide();
                        $('#hideCGA1').show(); $('#hideCGA2').show(); $('#cgaMsg').html(""); $('#showMsgCGA').hide();
                        $('#hideRR1').show(); $('#hideRR2').show(); $('#RRMsg').html(""); $('#showMsgRR').hide();
                        break;
                    case "SM":
                        //Remove value from material dropdown and add only steel
                        removeMat();
                        /*$('#rgmat')
                            .find('option')
                            .end()
                            .append('<option value="steel" selected="selected" id="steel">Steel</option>')
                            .val("steel");*/
                        $("#rgMatDIV").empty();
                        $("#rgMatDIV").append('<input type="radio" name="rgmat" value="steel"/>Steel');

                        $('#hideHG1').hide(); $('#hideHG2').hide(); $('#hgMsg').html("Standard equipment on SM reels"); $('#showMsgHoop').show();
                        //Hide spool lock assembly and display the message
                        $('#hidesla2').hide(); $('#hidesla1').hide(); $('#slaMsg').html("Standard equipment on SM reels"); $('#showMsgSLA').show();
                        //Hide Hazardous Duty and display message
                        $('#hideHazard1').hide(); $('#hideHazard2').hide(); $('#hazardMsg').html("Not available for SM reels"); $('#showMsgHazard').show();

                        $('#hideRG1').show(); $('#hideRG2').show(); $('#hideRG3').show(); $('#hideRG4').show(); $('#rgMsg').html(""); $('#showMsgRG').hide();
                        $('#hideLS1').show(); $('#hideLS2').show(); $('#LSMsg').html(""); $('#showMsgLS').hide();
                        $('#hide340db1').show(); $('#hide340db2').show(); $('#340DPBMsg').html(""); $('#showmsg340').hide();
                        $('#hideDR1').show(); $('#hideDR2').show(); $('#DRMsg').html(""); $('#showMsgDR').hide();
                        $('#hideBSA1').show(); $('#hideBSA2').show(); $('#hideBSA3').show(); $('#bsaMsg').html(""); $('#showMsgBSA').hide();
                        $('#hideCGA1').show(); $('#hideCGA2').show(); $('#cgaMsg').html(""); $('#showMsgCGA').hide();
                        $('#hideRR1').show(); $('#hideRR2').show(); $('#RRMsg').html(""); $('#showMsgRR').hide();
                        break;
                    case "MMD":
                        $('#hideHG1').hide(); $('#hideHG2').hide(); $('#hgMsg').html("Standard equipment on MMD reels"); $('#showMsgHoop').show();
                        //Hide spool lock assembly and display the message
                        $('#hidesla2').hide(); $('#hidesla1').hide(); $('#slaMsg').html("Standard equipment on MMD reels"); $('#showMsgSLA').show();

                        $('#hideRG1').show(); $('#hideRG2').show(); $('#hideRG3').show(); $('#hideRG4').show(); $('#rgMsg').html(""); $('#showMsgRG').hide();
                        $('#hideLS1').show(); $('#hideLS2').show(); $('#LSMsg').html(""); $('#showMsgLS').hide();
                        $('#hide340db1').show(); $('#hide340db2').show(); $('#340DPBMsg').html(""); $('#showmsg340').hide();
                        $('#hideDR1').show(); $('#hideDR2').show(); $('#DRMsg').html(""); $('#showMsgDR').hide();
                        $('#hideBSA1').show(); $('#hideBSA2').show(); $('#hideBSA3').show(); $('#bsaMsg').html(""); $('#showMsgBSA').hide();
                        $('#hideCGA1').show(); $('#hideCGA2').show(); $('#cgaMsg').html(""); $('#showMsgCGA').hide();
                        $('#hideRR1').show(); $('#hideRR2').show(); $('#RRMsg').html(""); $('#showMsgRR').hide();
                        $('#hideHazard1').show(); $('#hideHazard2').show(); $('#hazardMsg').html(""); $('#showMsgHazard').hide();
                        break;

                    case "UE":
                    case "UH":
                        removeMat();
                        /*$('#rgmat')
                            .find('option')
                            .end()
                            .append('<option value="nylon" id="nylon">Nylon</option>')
                            .val("nylon");*/
                        $("#rgMatDIV").empty();
                        $("#rgMatDIV").append('<input type="radio" name="rgmat" value="nylon" checked />Nylon');

                        $('#hideCGA1').hide(); $('#hideCGA2').hide(); $('#cgaMsg').html("Not available for " + series + " reels."); $('#showMsgCGA').show();
                        //Hide Hazardous Duty and display message
                        $('#hideHazard1').hide(); $('#hideHazard2').hide(); $('#hazardMsg').html("Not available for" + series + " reels"); $('#showMsgHazard').show();

                        $('#hideRG1').show(); $('#hideRG2').show(); $('#hideRG3').show(); $('#hideRG4').show(); $('#rgMsg').html(""); $('#showMsgRG').hide();
                        $('#hideLS1').show(); $('#hideLS2').show(); $('#LSMsg').html(""); $('#showMsgLS').hide();
                        $('#hide340db1').show(); $('#hide340db2').show(); $('#340DPBMsg').html(""); $('#showMsg340').hide();
                        $('#hideDR1').show(); $('#hideDR2').show(); $('#DRMsg').html(""); $('#showMsgDR').hide();
                        $('#hideBSA1').show(); $('#hideBSA2').show(); $('#hideBSA3').show(); $('#bsaMsg').html(""); $('#showMsgBSA').hide();
                        $('#hidesla1').show(); $('#hidesla2').show(); $('#slaMsg').html(""); $('#showMsgSLA').hide();
                        $('#hideRR1').show(); $('#hideRR2').show(); $('#RRMsg').html(""); $('#showMsgRR').hide();
                        $('#hideHG1').show(); $('#hideHG2').show(); $('#RRMsg').html(""); $('#showMsgHoop').hide();
                        break;

                    case "SHO":
                    case "TMR":
                        $('#hideRG1').hide(); $('#hideRG2').hide(); $('#hideRG3').hide(); $('#hideRG4').hide(); $('#rgMsg').html("Not available for " + series + " reels."); $('#showMsgRG').show();
                        $('#hideHG1').hide(); $('#hideHG2').hide(); $('#hgMsg').html("Not available for " + series + " reels."); $('#showMsgHoop').show();

                        $('#hide340db1').hide(); $('#hide340db2').hide(); $('#340DPBMsg').html("Not available for " + series + " reels."); $('#showMsg340').show();
                        $('#hideDR1').hide(); $('#hideDR2').hide(); $('#DRMsg').html("Not available for " + series + " reels."); $('#showMsgDR').show();
                        $('#hidesla2').hide(); $('#hidesla1').hide(); $('#slaMsg').html("Not available for " + series + " reels."); $('#showMsgSLA').show();
                        $('#hideBSA1').hide(); $('#hideBSA2').hide(); $('#hideBSA3').hide(); $('#bsaMsg').html("Not available for " + series + " reels."); $('#showMsgBSA').show();

                        $('#hideHazard1').hide(); $('#hideHazard2').hide(); $('#hazardMsg').html("Not available for" + series + " reels"); $('#showMsgHazard').show();

                        $('#hideLS1').show(); $('#hideLS2').show(); $('#LSMsg').html(""); $('#showMsgLS').hide();
                        $('#hideCGA1').show(); $('#hideCGA2').show(); $('#cgaMsg').html(""); $('#showMsgCGA').hide();
                        $('#hideRR1').show(); $('#hideRR2').show(); $('#RRMsg').html(""); $('#showMsgRR').hide();
                        break;

                    case "C":
                        $('#hideRG1').hide(); $('#hideRG2').hide(); $('#hideRG3').hide(); $('#hideRG4').hide(); $('#rgMsg').html("Standard equipment on Cable Master reels"); $('#showMsgRG').show();
                        $('#hideHG1').hide(); $('#hideHG2').hide(); $('#hgMsg').html("Not available for Cable Master reels"); $('#showMsgHoop').show();
                        $('#hideLS1').hide(); $('#hideLS2').hide(); $('#LSMsg').html("Not available for Cable Master reels"); $('#showMsgLS').show();

                        $('#hideDR1').hide(); $('#hideDR2').hide(); $('#DRMsg').html("Standard equipment on Cable Master reels"); $('#showMsgDR').show();
                        $('#hidesla2').hide(); $('#hidesla1').hide(); $('#slaMsg').html("Not available for Cable Master reels"); $('#showMsgSLA').show();

                        $('#hideRR1').hide(); $('#hideRR2').hide(); $('#RRMsg').html("Not available for Cable Master reels"); $('#showMsgRR').show();
                        $('#hideHazard1').hide(); $('#hideHazard2').hide(); $('#hazardMsg').html("Not available for Cable Master reels"); $('#showMsgHazard').show();

                        $('#hide340db1').show(); $('#hide340db2').show(); $('#340DPBMsg').html(""); $('#showMsg340').hide();
                        $('#hideBSA1').show(); $('#hideBSA2').show(); $('#hideBSA3').show(); $('#bsaMsg').html(""); $('#showMsgBSA').hide();
                        $('#hideCGA1').show(); $('#hideCGA2').show(); $('#cgaMsg').html(""); $('#showMsgCGA').hide();
                        break;

                    case "HM":
                        $('#hideRG1').hide(); $('#hideRG2').hide(); $('#hideRG3').hide(); $('#hideRG4').hide(); $('#rgMsg').html("Standard equipment on Cable Master reels"); $('#showMsgRG').show();
                        $('#hideHG1').hide(); $('#hideHG2').hide(); $('#hgMsg').html("Not available for Hose Master reels"); $('#showMsgHoop').show();
                        $('#hideLS1').hide(); $('#hideLS2').hide(); $('#LSMsg').html("Not available for Hose Master reels"); $('#showMsgLS').show();

                        $('#hideDR1').hide(); $('#hideDR2').hide(); $('#DRMsg').html("Standard equipment on Hose Master reels"); $('#showMsgDR').show();
                        $('#hidesla2').hide(); $('#hidesla1').hide(); $('#slaMsg').html("Not available for Hose Master reels"); $('#showMsgSLA').show();

                        $('#hideCGA1').hide(); $('#hideCGA2').hide(); $('#cgaMsg').html("Not available for Hose Master reels"); $('#showMsgCGA').show();
                        $('#hideRR1').hide(); $('#hideRR2').hide(); $('#RRMsg').html("Not available for Hose Master reels"); $('#showMsgRR').show();
                        $('#hideHazard1').hide(); $('#hideHazard2').hide(); $('#hazardMsg').html("Not available for Hose Master reels"); $('#showMsgHazard').show();

                        $('#hide340db1').show(); $('#hide340db2').show(); $('#340DPBMsg').html(""); $('#showMsg340').hide();
                        $('#hideBSA1').show(); $('#hideBSA2').show(); $('#hideBSA3').show(); $('#bsaMsg').html(""); $('#showMsgBSA').hide();
                        break;

                    case "P":
                        $('#hideRG1').hide(); $('#hideRG2').hide(); $('#hideRG3').hide(); $('#hideRG4').hide(); $('#rgMsg').html("Standard equipment on Pendant reels"); $('#showMsgRG').show();
                        $('#hideHG1').hide(); $('#hideHG2').hide(); $('#hgMsg').html("Not available for Pendant reels"); $('#showMsgHoop').show();
                        $('#hideLS1').hide(); $('#hideLS2').hide(); $('#LSMsg').html("Standard equipment on Pendant reels"); $('#showMsgLS').show();
                        $('#hide340db1').hide(); $('#hide340db2').hide(); $('#340DPBMsg').html("Standard equipment on Pendant reels"); $('#showmsg340').show();

                        $('#hide340db1').hide(); $('#hide340db2').hide(); $('#340DPBMsg').html("Not available for Pendant reels"); $('#showMsg340').show();
                        $('#hideDR1').hide(); $('#hideDR2').hide(); $('#DRMsg').html("Not available for Pendant reels"); $('#showMsgDR').show();
                        $('#hidesla2').hide(); $('#hidesla1').hide(); $('#slaMsg').html("Not available for Pendant reels"); $('#showMsgSLA').show();
                        $('#hideBSA1').hide(); $('#hideBSA2').hide(); $('#hideBSA3').hide(); $('#bsaMsg').html("Not available for Pendant reels."); $('#showMsgBSA').show();

                        $('#hideRR1').hide(); $('#hideRR2').hide(); $('#RRMsg').html("Not available for Pendant reels"); $('#showMsgRR').show();
                        $('#hideHazard1').hide(); $('#hideHazard2').hide(); $('#hazardMsg').html("Not available for Pendant reels"); $('#showMsgHazard').show();
                        break;

                    case "K":
                        $('#hideRG1').hide(); $('#hideRG2').hide(); $('#hideRG3').hide(); $('#hideRG4').hide(); $('#rgMsg').html("Not available for K reels"); $('#showMsgRG').show();
                        $('#hideHG1').hide(); $('#hideHG2').hide(); $('#hgMsg').html("Not available for K reels"); $('#showMsgHoop').show();
                        $('#hideLS1').hide(); $('#hideLS2').hide(); $('#LSMsg').html("Not available for K reels"); $('#showMsgLS').show();
                        $('#hide340db1').hide(); $('#hide340db2').hide(); $('#340DPBMsg').html("Not available for K reels"); $('#showMsg340').show();

                        $('#hidesla2').hide(); $('#hidesla1').hide(); $('#slaMsg').html("Not available for K reels"); $('#showMsgSLA').show();
                        $('#hideBSA1').hide(); $('#hideBSA2').hide(); $('#hideBSA3').hide(); $('#bsaMsg').html("Not available for K reels."); $('#showMsgBSA').show();
                        $('#hideCGA1').hide(); $('#hideCGA2').hide(); $('#cgaMsg').html("Not available for K reels"); $('#showMsgCGA').show();
                        $('#hideRR1').hide(); $('#hideRR2').hide(); $('#RRMsg').html("Not available for K reels"); $('#showMsgRR').show();
                        $('#hideHazard1').hide(); $('#hideHazard2').hide(); $('#hazardMsg').html("Not available for K reels"); $('#showMsgHazard').show();

                        $('#hideDR1').show(); $('#hideDR2').show(); $('#DRMsg').html(""); $('#showMsgDR').hide();
                        break;
                }//End of switch -- series

                switch (series){
                    case "C":
                    case "HM":
                        if(cableThick > 1.24 || cableThick < 0.5){
                            $('#hideCGA1').hide(); $('#hideCGA2').hide(); $('#cgaMsg').html("Not available for this Cable/Hose diameter. Consult factory"); $('#showMsgCGA').show();
                        }

                        if(cableThick > 1 || cableThick < 0.25){
                            $('#hideBSA1').hide(); $('#hideBSA2').hide(); $('#hideBSA3').hide(); $('#bsaMsg').html("Not available for this Cable/Hose diameter. Consult factory."); $('#showMsgBSA').show();
                        }
                        break;
                    case "S":
                    case "SM":
                    case "MMD":
                    case "UE":
                    case "UH":
                    case "SHO":
                    case "TMR":
                        if(cableThick > 1.49 || cableThick < 0.41){
                            $('#hideCGA1').hide(); $('#hideCGA2').hide(); $('#cgaMsg').html("Not available for this Cable/Hose diameter. Consult factory"); $('#showMsgCGA').show();
                        }

                        if(cableThick > 2.06 || cableThick < 0.44){
                            $('#hideBSA1').hide(); $('#hideBSA2').hide(); $('#hideBSA3').hide(); $('#bsaMsg').html("Not available for this Cable/Hose diameter. Consult factory."); $('#showMsgBSA').show();
                        }
                        break;
                }
            }

            //This section manages "Discounts for this Quote" section of the accessories form
            $("#showDiscount").prop("disabled", true);
            $("#showReelDesc").prop("checked", true);
            $("#showItemPrice").prop("checked", true);
            $("#addDiscountSReel").prop("disabled", true);
            $("#addDiscountCMReel").prop("disabled", true);
            $("#addDiscountHMReel").prop("disabled", true);
            $("#addDiscountKReel").prop("disabled", true);
            $("#addDiscountMMDReel").prop("disabled", true);
            $("#addDiscountPendantReel").prop("disabled", true);
            $("#addDiscountSHOReel").prop("disabled", true);
            $("#addDiscountSMReel").prop("disabled", true);
            $("#addDiscountTMRReel").prop("disabled", true);
            $("#addDiscountUHReel").prop("disabled", true);
            $("#addDiscountUReel").prop("disabled", false);

            $("#discountSReel").on("input", function(){
                var mainDiscountSReel = document.getElementById("discountSReel").value;
                if(mainDiscountSReel > 0){
                    $("#showDiscount").prop("disabled", false);
                    $("#addDiscountSReel").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);

                }else{
                    $("#showDiscount").prop("disabled", true);
                    $("#addDiscountSReel").prop("disabled", true);
                    $("#showDiscount").prop("checked", false);
                }
            });

            $("#discountCMReel").on("input", function(){
                var mainDiscountCMReel = document.getElementById("discountCMReel").value;
                if(mainDiscountCMReel > 0){
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountCMReel").prop("disabled", false);
                }else{
                    $("#showDiscount").prop("disabled", true);
                    $("#showDiscount").prop("checked", false);
                    $("#addDiscountCMReel").prop("disabled", true);
                }
            });

            $("#discountHMReel").on("input", function(){
                var mainDiscountHMReel = document.getElementById("discountHMReel").value;
                if(mainDiscountHMReel > 0){
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountHMReel").prop("disabled", false);
                }else{
                    $("#showDiscount").prop("disabled", true);
                    $("#showDiscount").prop("checked", false);
                    $("#addDiscountHMReel").prop("disabled", true);
                }
            });

            $("#discountKReel").on("input", function(){
                var mainDiscountKReel = document.getElementById("discountKReel").value;
                if(mainDiscountKReel > 0){
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountKReel").prop("disabled", false);
                }else{
                    $("#showDiscount").prop("disabled", true);
                    $("#showDiscount").prop("checked", false);
                    $("#addDiscountKReel").prop("disabled", true);
                }
            });

            $("#discountMMDReel").on("input", function(){
                var mainDiscountMMDReel = document.getElementById("discountMMDReel").value;
                if(mainDiscountMMDReel > 0){
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountMMDReel").prop("disabled", false);
                }else{
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountMMDReel").prop("disabled", true);
                }
            });

            $("#discountPendantReel").on("input", function(){
                var mainDiscountPendantReel = document.getElementById("discountPendantReel").value;
                if(mainDiscountPendantReel > 0){
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountPendantReel").prop("disabled", false);
                }else{
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountPendantReel").prop("disabled", true);
                }
            });

            $("#discountSHOReel").on("input", function(){
                var mainDiscountSHOReel = document.getElementById("discountSHOReel").value;
                if(mainDiscountSHOReel > 0){
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountSHOReel").prop("disabled", false);
                }else{
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountSHOReel").prop("disabled", true);
                }
            });

            $("#discountSMReel").on("input", function(){
                var mainDiscountSMReel = document.getElementById("discountSMReel").value;
                if(mainDiscountSMReel > 0){
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountSMReel").prop("disabled", false);
                }else{
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountSMReel").prop("disabled", true);
                }
            });

            $("#discountTMRReel").on("input", function(){
                var mainDiscountTMRReel = document.getElementById("discountTMRReel").value;
                if(mainDiscountTMRReel > 0){
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountTMRReel").prop("disabled", false);
                }else{
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountTMRReel").prop("disabled", true);
                }
            });

            $("#discountUHReel").on("input", function(){
                var mainDiscountUHReel = document.getElementById("discountUHReel").value;
                if(mainDiscountUHReel > 0){
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountUHReel").prop("disabled", false);
                }else{
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountUHReel").prop("disabled", true);
                }
            });

            $("#discountUReel").on("input", function(){
                var mainDiscountUReel = document.getElementById("discountUReel").value;
                if(mainDiscountUReel > 0){
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountUReel").prop("disabled", false);
                }else{
                    $("#showDiscount").prop("disabled", false);
                    $("#showDiscount").prop("checked", true);
                    $("#addDiscountUReel").prop("disabled", false);
                }
            });

           //Move to next element of the array if there are more elements
            $("#nextReel").on("click", function(){

               //Get the currently displayed modelNum
                giveModelNum = $("#modelNumDisplayed").val();

                //Get the index of  the current element in the array
                var indexOfCurrentReel = -1;

                for(i = 0; i < quoteArray.length; i++){
                    if(quoteArray[i].modelNum === giveModelNum){
                        indexOfCurrentReel = i;
                        $("input[name='addHoop'][value='No']").prop('checked', true);
                        series = quoteArray[indexOfCurrentReel].series;

                        break;
                    }
                }

                console.log("Value of index: " + indexOfCurrentReel);

                //Store value of selected options for the current Reel
                storeModelOptions(indexOfCurrentReel);

                ++indexOfCurrentReel; //get index of the next element

                console.log("Value of index: " + indexOfCurrentReel);

                //Move to the next element in the array if current index is less than quoteArray length
                if(indexOfCurrentReel < quoteArray.length){
                    if(quoteArray[indexOfCurrentReel]["quoteFlag"] === 1){
                        $("#modelNumDisplayed").val(quoteArray[indexOfCurrentReel].modelNum);
                        display = "RECOMMENDED MODEL: " + quoteArray[indexOfCurrentReel].modelNum;
                        document.getElementById("modelnumberQuote").style.color = "red";
                        $('#modelnumberQuote').html(display);
                        series = quoteArray[indexOfCurrentReel].series;
                        framez = quoteArray[indexOfCurrentReel].frame;
                        setOPTChoices(series, cableThick, framez);
                    }else if (quoteArray[indexOfCurrentReel]["quoteFlag"] === 2){
                        $("#modelNumDisplayed").val(quoteArray[indexOfCurrentReel].modelNum);
                        display = "ALTERNATIVE MODEL: " + quoteArray[indexOfCurrentReel].modelNum;
                        document.getElementById("modelnumberQuote").style.color = "blue";
                        $('#modelnumberQuote').html(display);
                        series = quoteArray[indexOfCurrentReel].series;
                        framez = quoteArray[indexOfCurrentReel].frame;
                        setOPTChoices(series, cableThick, framez);
                    }

                    $("#previousReel").prop('disabled', false);
                    if(indexOfCurrentReel === quoteArray.length - 1){
                        $("#nextReel").prop('disabled', true);
                        $("#previousReel").prop('disabled', false);
                    }
                }
            });

            //Move to the previous element of the array if there is.
            $("#previousReel").on("click", function(){
                giveModelNum = $("#modelNumDisplayed").val();

                var indexOfCurrentReel = -1;
                for(i = 0; i < quoteArray.length; i++){
                    if(quoteArray[i].modelNum === giveModelNum){
                        indexOfCurrentReel = i;
                        break;
                    }
                }

                --indexOfCurrentReel;//get index of the previous element
                //Move to the next element in the array if current index is less than quoteArray length
                if(indexOfCurrentReel < quoteArray.length){
                    if(quoteArray[indexOfCurrentReel]["quoteFlag"] === 1){
                        giveModelNum = quoteArray[indexOfCurrentReel].modelNum;
                        display = "RECOMMENDED MODEL: " + quoteArray[indexOfCurrentReel].modelNum;
                        document.getElementById("modelnumberQuote").style.color = "red";
                        $('#modelnumberQuote').html(display);
                        series = quoteArray[indexOfCurrentReel].series;
                        framez = quoteArray[indexOfCurrentReel].frame;
                        setOPTChoices(series, cableThick, framez);
                    }else if (quoteArray[indexOfCurrentReel]["quoteFlag"] === 2){
                        giveModelNum = quoteArray[indexOfCurrentReel].modelNum;
                        display = "ALTERNATIVE MODEL: " + quoteArray[indexOfCurrentReel].modelNum;
                        document.getElementById("modelnumberQuote").style.color = "blue";
                        $('#modelnumberQuote').html(display);
                        series = quoteArray[indexOfCurrentReel].series;
                        framez = quoteArray[indexOfCurrentReel].frame;
                        setOPTChoices(series, cableThick, framez);
                    }

                    $("#nextReel").prop('disabled', false);

                    if(indexOfCurrentReel == 0){
                        $("#nextReel").prop('disabled', false);
                        $("#previousReel").prop('disabled', true);
                    }
                }

            });


            //hide 340 degrees pivot base if its U Reel
            $('input:radio[name=rgapp]').change(function () {
                var rgappValue = $('input[name=rgapp]:checked').val();
                reelType = series.substring(0,1);
                if(reelType == "U"){
                    if (rgappValue === "vertical"){
                        $("#hide340db1").hide();
                        $("#hide340db2").hide();
                        $("#340DPBMsg").html("Cannot be used with Vertical roller guides.");
                        $('#showMsg340').show();
                    }else{
                        $("#hide340db1").show();
                        $("#hide340db2").show();
                        $("#340DPBMsg").html("");
                        $('#showMsg340').hide();
                    }
                }
            });

            $('input:radio[name=rgmat]').change(function () {
                var rgmatValue = $('input[name=rgmat]:checked').val();

                if(reelType === "S") {
                    if (frame === "32" && rgmatValue === "Steel") {
                        $("input[name='addHoop'][value='Yes']").prop('checked', true);
                        $("input[name='addHoop'][value='No']").prop('disabled', true);
                        $('#hgMsg').html("Required for 32 frame w/roller guides");
                        $('#showMsgHoop').show();
                    } else {
                        $("input[name='addHoop'][value='Yes']").prop('checked', false);
                        $("input[name='addHoop'][value='No']").prop('checked', false);
                        $('#hgMsg').html("Not available for this frame size");
                        $("#showMsgHoop").show();
                    }
                }
            });

            function storeModelOptions(index) {
                //Get the values selected by the user

                rollerGuideVal = $('input[name=addrgOption]:checked').val();
                var rollerGuideApp; var rollerGuideMat; var bdiamVar;
                    if (rollerGuideVal === "Yes") {
                        rollerGuideApp = $('input[name=rgapp]:checked').val();
                        rollerGuideMat = $('input[name=rgmat]:checked').val();
                    }

                    if (rollerGuideVal === "No"){
                        rollerGuideApp = "";
                        rollerGuideMat = "";
                    }

                hoopGuideVal = $('input[name=addHoop]:checked').val();
                limitSwitchVal = $('input[name=addls]:checked').val();
                pivotBase340Val = $('input[name=pivotBase340]:checked').val();
                dogAndRatchetVal = $('input[name=adddnr]:checked').val();
                spoolLockAssVal = $('input[name=sla]:checked').val();

                ballStopAssVal = $('input[name=addbsa]:checked').val();
                if(ballStopAssVal === "Yes"){
                    bdiamVar = $('input[name=bdiam]:checked').val();
                }else{
                    bdiamVar = "";
                }

                cableGripAssVal = $('input[name=cga]:checked').val();
                revRotVal = $('input[name=addRevRot]:checked').val();
                hazardVal = $('input[name=hazardous2]:checked').val();


                if(!("rollerGuideVal" in quoteArray[index])){
                    quoteArray[index]["rollerGuideVal"] = rollerGuideVal;

                }
                if(!("rollerGuideApp" in quoteArray[index])){
                    quoteArray[index]["rollerGuideApp"] = rollerGuideApp;
                }
                if(!("rollerGuideMat" in quoteArray[index])){
                    quoteArray[index]["rollerGuideMat"] = rollerGuideMat;
                }
                if(!("hoopGuideVal" in quoteArray[index])){
                    quoteArray[index]["hoopGuideVal"] = hoopGuideVal;
                }
                if(!("limitSwitchVal" in quoteArray[index])){
                    quoteArray[index]["limitSwitchVal"] = limitSwitchVal;
                }
                if(!("pivotBase340Val" in quoteArray[index])){
                    quoteArray[index]["pivotBase340Val"] = pivotBase340Val;
                }
                if(!("dogAndRatchetVal" in quoteArray[index])){
                    quoteArray[index]["dogAndRatchetVal"] = dogAndRatchetVal;
                }
                if(!("spoolLockAssVal" in quoteArray[index])){
                    quoteArray[index]["spoolLockAssVal"] = spoolLockAssVal;
                }
                if(!("ballStopAssVal" in quoteArray[index])){
                    quoteArray[index]["ballStopAssVal"] = ballStopAssVal;
                }
                if(!("bdiamVar" in quoteArray[index])){
                    quoteArray[index]["bdiamVar"] = bdiamVar;
                }
               if(!("cableGripAssVal" in quoteArray[index])){
                    quoteArray[index]["cableGripAssVal"] = cableGripAssVal;
                }
                if(!("revRotVal" in quoteArray[index])){
                    quoteArray[index]["revRotVal"] = revRotVal;
                }
                if(!("hazardVal" in quoteArray[index])){
                    quoteArray[index]["hazardVal"] = hazardVal;
                }
                quoteArray[index]["modNote"] = "";

                printQuoteModel.push(quoteArray[index]);
                printQuoteModel = unique(printQuoteModel);
                console.log(printQuoteModel);
                console.log(printQuoteModel.length);
            }

            //function that takes the printquotemodel and displays the quoted reels
            function displayQuoteReel(array){
                for(i = 0; i < array.length; i++){
                    var theSeries = array[i].series;
                    if(theSeries === "S"){
                        $("#sReel").show();
                    }
                    if(theSeries === "MMD"){
                        $("#mmdReel").show();
                    }
                    if(theSeries === "SM"){
                        $("#smReel").show();
                    }
                    if(theSeries === "SHO"){
                        $("#shoReel").show();
                    }
                    if(theSeries === "TMR"){
                        $("#tmrReel").show();
                    }
                    if(theSeries === "C"){
                        $("#cmReel").show();
                    }
                    if(theSeries === "UE"){
                        $("#uReel").show();
                    }
                    if(theSeries === "UH"){
                        $("#uhReel").show();
                    }
                    if(theSeries === "HM"){
                        $("#hmReel").show();
                    }
                    if(theSeries === "K"){
                        $("#kReel").show();
                    }
                    if(theSeries === "P"){
                        $("#pendantReel").show();
                    }
                }
            }

            $('#continue').on('click', function(){
                //get the current element in the #modelnumberQuote
                var currentQuotedReel = $("#modelNumDisplayed").val();
                var indexOfCurrentReel = -1;

                if(quoteArray.length === 1){
                    indexOfCurrentReel = 0;
                    storeModelOptions(indexOfCurrentReel);
                }else{
                    for(i = 0; i < quoteArray.length; i++){
                        if(quoteArray[i].modelNum === currentQuotedReel){
                            indexOfCurrentReel = i;
                            storeModelOptions(indexOfCurrentReel);
                            break;
                        }
                    }
                }


                $("#printQuotedArrays").val(JSON.stringify(quoteArray));
                for(i = 0; i < quoteArray.length; i++){
                    $("#noteForModel")
                        .find("option")
                        .end()
                        .append('<option value='+quoteArray[i].modelNum+'>'+quoteArray[i].modelNum+'</option>');
                }
                displayQuoteReel(printQuoteModel);

            });
            
            $('#noteForModel').on('change', function(){

                var modNum = $(this).val();
                if(modNum === ""){
                    $('#BOMheaderModelSection').val("");
                }
                for(i = 0; i < quoteArray.length; i++){
                    if(modNum === quoteArray[i].modelNum){
                        $('#BOMheaderModelSection').val(quoteArray[i].modNote)
                    }
                }
            });

            $('#BOMheaderModelSection').on('focusout', function(){
                var modNum = $('#noteForModel').val();
                for(i = 0; i < quoteArray.length; i++){
                    if(modNum === quoteArray[i].modelNum){
                        quoteArray[i]["modNote"] = $('#BOMheaderModelSection').val();

                    }
                }
                $("#printQuotedArrays").val(JSON.stringify(quoteArray));
            });

        });

        //printQuote - implementation
        $(document).ready(function(){

           var typeOtherFlag = false;
           var discountsChanged = false;
           var cable = <?php echo json_encode($data['cable']);?>;
           var cableOrHose = <?php echo json_encode($data['cableOrHose']);?>;
           var metricDefault = <?php echo json_encode($data['metricDefault']);?>;
           var quoteComplete = false; var quoteCableFlag = true;
           var increment = 0; var  frmt = 0;

           switch (metricDefault){
               case true:
                   increment = 0.1;
                   frmt = "0.00";
                   $("#measure").val("meters:");
                   break;
               case false:
                   increment = 1;
                   frmt = "0.0";
                   $("#measure").val("feet:");
           }



           //Because this is for Reel application set cabSkip = true and cableSave = true (cableSave is a variable set when a cable is added to a package and saved to the DB
            cableSave = false; cabSkip = false; //When implementing other modules, these variables may change
           if(cabSkip === true || cableSave === true){
               $('#extraCable').hide();
           }else{
               $('#extraCable').show();
           }

            switch(cableOrHose){
                case "HS":
                case "HD":
                    $('#includeCableQuoteLabel').text("Include hose in quote");
                    $('#includeCableInstallLabel').text("Include hose installation");
                    $('#listItems').hide();
                    $('#extraLabel').text("Extra Hose: ");
                    $('#msg').text("Note: hose for hookup and safety wrap(s) is already accounted for");
                    break;
                case "C":
                    $('#includeCableQuoteLabel').text("Include cable in quote");
                    $('#includeCableInstallLabel').text("Include cable installation");
                    $('#listItems').show();
                    $('#extraLabel').text("Extra Cable: ");
                    $('#msg').text("Note: cable for hookup and safety wrap(s) is already accounted for");
                    break;
            }

            if(quoteComplete === false){
                //setDiscFlag(); Not defined here. included in the click event of the respective text boxes for incrementing discount
                if(cableOrHose === "C"){

                    switch(cable.type){
                        case "SO":
                        case "W":
                        case "G":
                        case "GGC":
                        case "HV":
                            break;
                        default:
                            typeOtherFlag = true; quoteCableFlag = "true"
                    }
                }

                switch (quoteCableFlag){
                    case false:
                        $("#includeCableQuote").val("No");
                        $('#includeCableInstall').val("No");
                        $("#includeCableQuote").prop("disabled", true);
                        $('#includeCableInstall').prop("disabled", true);
                        break;
                    case true:
                        $("#includeCableQuote").prop("checked", true);
                        $('#includeCableInstall').prop("checked", true);
                        $("#includeCableQuote").prop("disabled", false);
                        $('#includeCableInstall').prop("disabled", false);
                        if(typeOtherFlag === true){
                            $('#includeCableInstall').prop("disabled", true);
                        }else if(cableOrHose !== "C" || Number(cable.installFoot) <= 0){
                            $('#includeCableInstall').val("No");
                            $('#includeCableInstall').prop("disabled", true);
                        }
                }
            }

           if($("#preparedBy").val().length > 8){
                    $("#submit").prop("disabled", false);
                }
            

            $("#preparedBy").focusout(function(){
                if($("#preparedBy").val().length > 8){
                    $("#submit").prop("disabled", false);
                }
            });

            $("#includeCableQuote").on('click', function(){
                if($(this).is(':checked') && typeOtherFlag){
                    $('#includeCableInstall').prop("checked", true);
                }
                if($("#includeCableQuote").prop("checked") === false){
                    $('#includeCableInstall').prop("checked", false);
                }
            });

            $("#includeCableInstall").on('click', function(){
                if($(this).is(':checked')){
                    $('#includeCableQuote').prop("checked", true);
                }
            });

            function confirmDialog(message){

                $('<div></div>').appendTo('body')
                    .html('<div><h6>'+message+'?</h6></div>')
                    .dialog({
                        modal: true, title: 'Important Note', zIndex: 10000, autoOpen: true,
                        width: 'auto', resizable: false,
                        buttons: {
                            Yes: function () {
                                $('body').append('<h1>Confirm Dialog Result: <i>Yes</i></h1>');

                                $(this).dialog("close");
                            },
                            No: function () {
                                $('body').append('<h1>Confirm Dialog Result: <i>No</i></h1>');

                                $(this).dialog("close");
                            }
                        }
                });
            }

            $("#submit").on('click', function(){
                //alert("We got here");
                if($("#includeCableQuote").is(':checked')){
                    //alert("We got here");
                    if(cabSkip === false && quoteCableFlag === true){
                        //alert("We got here");
                        var extracabNo = document.getElementById("extraCableValue").value;

                       if(Number(extracabNo) == 0){
                           var response = confirm("You have not entered any extra cable/hose length for hook-up. Would you like to go back and add extra cable/hose length?");
                           if(response === true){
                               return false;
                           }
                       }
                    }
                }
            });




        });//End of implementation for printQuote



        $('#invalidModal').on('hidden.bs.modal', function () {
            $('#invalid-table tbody').empty();
        })


    </script>
@stop