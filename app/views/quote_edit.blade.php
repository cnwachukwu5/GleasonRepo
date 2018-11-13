@extends('layouts.master')


@section('page-title')
   Edit Quote
@stop


@section('content')
    <div class="table-responsive-first">
        <form method="post" action="{{url('quote/update')}}">
        <table class="table table-striped quotes-table">
            <input type="hidden" value="{{$quote->quotes_id}}" name="quote-id">
            <input type="hidden" value="{{$quote->QuoteID}}" name="quote-id-two">
            <tbody>
            <tr>
                <th>ProductLine</th>
                <th>Revision</th>
                <th>Quote Date</th>
                <th>Reel Quantity</th>
                <th>Show Discount</th>
                <th>Cable Incline</th>
                <th>Cable Install</th>
            </tr>

            <tr>
                <td><input type="text" value="{{$quote->ProductLine}}" name="quote-productline"></td>
                <td><input type="text" value="{{$quote->Revision}}" name="quote-revision"></td>
                <td><input type="text" value="{{$quote->QuoteDate}}" name="quote-quotedate"></td>
                <td><input type="text" value="{{$quote->ReelQty}}" name="quote-reelqty"></td>
                <td><select name="quote-showdisc">
                    <?php

                    if($quote->ShowDiscount != "Yes"){
                        echo "<option selected>No</option><option>Yes</option>";
                    }
                    else{
                        echo "<option >No</option><option selected>Yes</option>";
                    }
                    ?> </select></td>
                <td><select name="quote-cableincl">
                        <?php

                        if($quote->CableIncl != "Yes"){
                            echo "<option selected>No</option><option>Yes</option>";
                        }
                        else{
                            echo "<option >No</option><option selected>Yes</option>";
                        }
                        ?> </select></td>
                <td><select name="quote-cableinstall">
                        <?php

                        if($quote->CableInstall != "Yes"){
                            echo "<option selected>No</option><option>Yes</option>";
                        }
                        else{
                            echo "<option >No</option><option selected>Yes</option>";
                        }
                        ?> </select></td>

            </tr>

            <tr>
                <th>ExCabMoving</th>
                <th>Show Item</th>
                <th>Status</th>
                <th>Metric</th>
                <th>Quote Preparer</th>
                <th>Customer ID</th>
                <th>Representative ID</th>
            </tr>

            <tr>
                <td><input type="text" value="{{$quote->ExCabMoving}}" name="quote-excabmoving"></td>
                <td><select name="quote-showitem">
                        <?php

                        if($quote->ShowItem != "Yes"){
                            echo "<option selected>No</option><option>Yes</option>";
                        }
                        else{
                            echo "<option >No</option><option selected>Yes</option>";
                        }
                        ?> </select>
                </td>
                <td><input type="text" value="{{$quote->Status}}" name="quote-status"></td>
                <td><input type="text" value="{{$quote->Metric}}" name="quote-metric"></td>
                <td><input type="text" value="{{$quote->RepID}}" name="quote-RepID"></td>
                <td><select name = "quote-custID"><?php
                    $customers = Customer::All();
                    foreach($customers as $customer){

                        if($customer->id == $quote->CustomerID){
                            echo "<option value='$customer->id' selected >$customer->name</option>";
                        }
                        else{
                            echo "<option value='$customer->id'>$customer->name</option>";
                        }
                    }
                    ?></select></td>
                <td><select name = "quote-repID"><?php
                        $reps = Rep::All();
                        foreach($reps as $rep){

                            if($rep->id == $quote->CustomerID){
                                echo "<option value='$rep->id' selected >$rep->name</option>";
                            }
                            else{
                                echo "<option value='$rep->id'>$rep->name</option>";
                            }
                        }
                        ?></select></td>
            </tr>

            <tr>
                <th>Quote ID</th>
                <th>Package ID</th>
                <th>View PDF</th>
            </tr>

            <tr>
                <td>{{$quote->QuoteID}}</td>
                <td>{{$quote->PkgID}}</td>
                <td><a href="{{ url($quote->pdfFilepath) }}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-search"></span></a></td>
            </tr>
            </tbody>


        </table>

    <br><br>

    <body>

    <div class="notes-div">
        <h3>Edit Notes</h3>
        <br>
        <textarea rows="4" cols="100" name="quote-subject">
            {{$quote->Subject}}
        </textarea>

    </div>

    <br><br>

    <div class="table-responsive-models">
        <h3>Edit Models</h3>
        <br>
        <table class="table table-striped models-table">

            <tbody>
            @foreach($models as $model)

            <tr>
                <th>Model Number</th>
                <th>Series</th>
                <th>Hazard Duty</th>
                <th>Reverse Rotate</th>
                <th>Required Extra Cable</th>
                <th>Reel Height</th>
            </tr>
            <tr>

                <td><input type="text" value="{{$model->ModelNum}}" name="models[{{$model->ModelID}}][modelNum]"></td>
                <td><input type="text" value="{{$model->Series}}" name="models[{{$model->ModelID}}][series]"></td>
                <td><input type="text" value="{{$model->HazardDuty}}" name="models[{{$model->ModelID}}][hazardDuty]"></td>
                <td><input type="text" value="{{$model->ReverseRotate}}" name="models[{{$model->ModelID}}][reverseRotate]"></td>
                <td><input type="text" value="{{$model->ReqdExtraCAble}}" name="models[{{$model->ModelID}}][reqdExtraCable]"></td>
                <td><input type="text" value="{{$model->ReelHeight}}" name="models[{{$model->ModelID}}][reelHeight]"></td>
            </tr>
            <tr>
                <th>Reel Width</th>
                <th>Reel Depth</th>
                <th>Reel Weight</th>
                <th>Picture ID</th>
                <th>Quote Type</th>
                <th>Delivery Time</th>
            </tr>
            <tr>
                <td><input type="text" value="{{$model->ReelWidth}}" name="models[{{$model->ModelID}}][reelWidth]"></td>
                <td><input type="text" value="{{$model->ReelDepth}}" name="models[{{$model->ModelID}}][reelDepth]"></td>
                <td><input type="text" value="{{$model->ReelWeight}}" name="models[{{$model->ModelID}}][reelWeight]"></td>
                <td>{{$model->PictureID}}</td>
                <td><input type="text" value="{{$model->QuoteType}}" name="models[{{$model->ModelID}}][quoteType]"></td>
                <td><input type="text" value="{{$model->Delivery}}" name="models[{{$model->ModelID}}][delivery]"></td>

            </tr>
            @endforeach

            </tbody>
        </table>

    </div>

    <br><br>

    <div class="table-responsive-reels">
        <h3>Edit Reels</h3>
        <br>
        <table class="table table-striped reels-table">

            <thead>
            <tr>
                <th>Model Number</th>
                <th>Quantity</th>
                <th>Part Number</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reels as $reel)

                <tr>

                    <td><input type="text" value="{{$reel->modelnum}}" name="reels[{{$reel->quotedetails_id}}][modelnum]"></td>
                    <td><input type="text" value="{{$reel->qty}}" name="reels[{{$reel->quotedetails_id}}][qty]"></td>
                    <td><input type="text" value="{{$reel->pn}}" name="reels[{{$reel->quotedetails_id}}][pn]"></td>
                    <td><input type="text" value="{{$reel->description}}" name="reels[{{$reel->quotedetails_id}}][description]"></td>
                    <td><input type="text" value="{{$reel->price}}$" name="reels[{{$reel->quotedetails_id}}][price]"></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <div class="table-responsive-disc">
        <h3>Edit Discounts</h3>
        <br>
        <table class="table table-striped disc-table">
            @foreach($discounts as $discount)

                <tbody>
                <tr>
                    <th>S Reel Discount</th>
                    <th>S Reel Discount (Additional)</th>
                </tr>

                <tr>
                    <td><input type="text" value="{{$discount->SreelDisc1}}%" name="discounts[{{$discount-> qtedisc_id}}][sreel1]"></td>
                    <td><input type="text" value="{{$discount->SreelDisc2}}%" name="discounts[{{$discount-> qtedisc_id}}][sreel2]"></td>
                </tr>

                <tr>
                    <th>MMD Reel Discount</th>
                    <th>MMD Reel Discount (Additional)</th>
                </tr>

                <tr>
                    <td><input type="text" value="{{$discount->MMDreelDisc1}}%" name="discounts[{{$discount-> qtedisc_id}}][mmdreel1]"></td>
                    <td><input type="text" value="{{$discount->MMDreelDisc2}}%" name="discounts[{{$discount-> qtedisc_id}}][mmdreel2]"></td>
                </tr>

                <tr>
                    <th>SM Reel Discount</th>
                    <th>SM Reel Discount (Additional)</th>
                </tr>

                <tr>
                    <td><input type="text" value="{{$discount->SMreelDisc1}}%" name="discounts[{{$discount-> qtedisc_id}}][smreel1]"></td>
                    <td><input type="text" value="{{$discount->SMreelDisc2}}%" name="discounts[{{$discount-> qtedisc_id}}][smreel2]"></td>
                </tr>

                <tr>
                    <th>SHO Reel Discount</th>
                    <th>SHO Reel Discount (Additional)</th>
                </tr>

                <tr>
                    <td><input type="text" value="{{$discount->SHOreelDisc1}}%" name="discounts[{{$discount-> qtedisc_id}}][shoreel1]"></td>
                    <td><input type="text" value="{{$discount->SHOreelDisc2}}%" name="discounts[{{$discount-> qtedisc_id}}][shoreel2]"></td>
                </tr>

                <tr>
                    <th>TMR Reel Discount</th>
                    <th>TMR Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td><input type="text" value="{{$discount->TMRreelDisc1}}%" name="discounts[{{$discount-> qtedisc_id}}][tmrreel1]"></td>
                    <td><input type="text" value="{{$discount->TMRreelDisc2}}%" name="discounts[{{$discount-> qtedisc_id}}][tmrreel2]"></td>
                </tr>

                <tr>
                    <th>UE Reel Discount</th>
                    <th>UE Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td><input type="text" value="{{$discount->UEreelDisc1}}%" name="discounts[{{$discount-> qtedisc_id}}][ureel1]"></td>
                    <td><input type="text" value="{{$discount->UEreelDisc2}}%" name="discounts[{{$discount-> qtedisc_id}}][ureel2]"></td>
                </tr>

                <tr>
                    <th>CM Reel Discount</th>
                    <th>CM Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td><input type="text"  value="{{$discount->CMreelDisc1}}%" name="discounts[{{$discount-> qtedisc_id}}][cmreel1]"></td>
                    <td><input type="text"  value="{{$discount->CMreelDisc2}}%" name="discounts[{{$discount-> qtedisc_id}}][cmreel2]"></td>
                </tr>

                <tr>
                    <th>P Reel Discount</th>
                    <th>P Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td><input type="text"  value="{{$discount->PreelDisc1}}%" name="discounts[{{$discount-> qtedisc_id}}][preel1]"></td>
                    <td><input type="text"  value="{{$discount->PreelDisc2}}%" name="discounts[{{$discount-> qtedisc_id}}][preel2]"></td>
                </tr>

                <tr>
                    <th>UH Reel Discount</th>
                    <th>UH Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td><input type="text"  value="{{$discount->UHreelDisc1}}%" name="discounts[{{$discount-> qtedisc_id}}][uhreel1]"></td>
                    <td><input type="text"  value="{{$discount->UHreelDisc2}}%" name="discounts[{{$discount-> qtedisc_id}}][uhreel2]"></td>
                </tr>

                <tr>
                    <th>K Reel Discount</th>
                    <th>K Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td><input type="text"  value="{{$discount->KreelDisc1}}%" name="discounts[{{$discount-> qtedisc_id}}][kreel1]"></td>
                    <td><input type="text"  value="{{$discount->KreelDisc2}}%" name="discounts[{{$discount-> qtedisc_id}}][kreel2]"></td>
                </tr>

                <tr>
                    <th>HM Reel Discount</th>
                    <th>HM Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td><input type="text"  value="{{$discount->HMreelDisc1}}%" name="discounts[{{$discount-> qtedisc_id}}][hmreel1]"></td>
                    <td><input type="text"  value="{{$discount->HMreelDisc2}}%" name="discounts[{{$discount-> qtedisc_id}}][hmreel2]"></td>
                </tr>

                </tbody>
            @endforeach
        </table>
    </div>
    </body>

    <div class="table-responsive-reel-details">
        <h3>Edit Reel Application Details</h3>
        <br>
        <table class="table table-striped table-condensed reel-details-table">
            @foreach($reelInfo as $info)
                <tbody>

                <tr>
                    <th>Application</th>
                    <th>Sag</th>
                    <th>PendantWgt</th>
                    <th>Centerline Height</th>
                    <th>Travel</th>
                    <th>Speed</th>
                    <th>Acceleration</th>
                </tr>

                <tr>
                    <td><input type="text"  value="{{$info->Application}}" name="reelapp[{{$info->reelapp_id}}][application]"></td>
                    <td><input type="text"  value="{{$info->Sag}}" name="reelapp[{{$info->reelapp_id}}][sag]"></td>
                    <td><input type="text"  value="{{$info->PendantWgt}}" name="reelapp[{{$info->reelapp_id}}][pendantwgt]"></td>
                    <td><input type="text"  value="{{$info->CenterlineHgt}}" name="reelapp[{{$info->reelapp_id}}][centerlinehgt]"></td>
                    <td><input type="text"  value="{{$info->Travel}}" name="reelapp[{{$info->reelapp_id}}][travel]"></td>
                    <td><input type="text"  value="{{$info->Speed}}" name="reelapp[{{$info->reelapp_id}}][speed]"></td>
                    <td><input type="text"  value="{{$info->Accel}}" name="reelapp[{{$info->reelapp_id}}][accel]"></td>
                </tr>

                <tr>
                    <th>Duty_Cycle</th>
                    <th>Minimum Temperature</th>
                    <th>Maximum Temperature</th>
                    <th>Spring Turns</th>
                    <th>CCF</th>
                    <th>Dead Wraps</th>
                    <th>App Notes</th>
                </tr>

                <tr>
                    <td><input type="text"  value="{{$info->Duty_Cycle}}" name="reelapp[{{$info->reelapp_id}}][duty_cycle]"></td>
                    <td><input type="text"  value="{{$info->TempMin}}" name="reelapp[{{$info->reelapp_id}}][tempmin]"></td>
                    <td><input type="text"  value="{{$info->TempMax}}" name="reelapp[{{$info->reelapp_id}}][tempmax]"></td>
                    <td><input type="text"  value="{{$info->SpringTurns}}" name="reelapp[{{$info->reelapp_id}}][springturns]"></td>
                    <td><input type="text"  value="{{$info->CCF}}" name="reelapp[{{$info->reelapp_id}}][ccf]"></td>
                    <td><input type="text"  value="{{$info->DeadWraps}}" name="reelapp[{{$info->reelapp_id}}][deadwraps]"></td>
                    <td><input type="text"  value="{{$info->AppNote}}" name="reelapp[{{$info->reelapp_id}}][appnote]"></td>
                </tr>

                </tbody>
            @endforeach
        </table>
    </div>

            <input type="submit" value="save" class="btn btn-primary btn-xs" />
        </form>
    </div>


@stop

@section('scripts')

@stop