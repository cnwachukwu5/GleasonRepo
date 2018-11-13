@extends('layouts.master')


@section('page-title')
    Quote Details
@stop


@section('content')
    <div>
        <a href="{{ url('quote/edit/' . $quote->quotes_id) }}"><h3>Edit this Quote</h3></a>
    </div>
    <div class="table-responsive-first">
        <table class="table table-striped quotes-table">
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
                    <td>{{$quote->ProductLine}}</td>
                    <td>{{$quote->Revision}}</td>
                    <td>{{$quote->QuoteDate}}</td>
                    <td>{{$quote->ReelQty}}</td>
                    <td><?php

                            if($quote->ShowDiscount != "Yes"){
                                echo "No";
                            }
                            else{
                                echo $quote->ShowDiscount;
                            }
                        ?>
                    </td>
                    <td>{{$quote->CableIncl}}</td>
                    <td>{{$quote->CableInstall}}</td>


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
                    <td>{{$quote->ExCabMoving}}</td>
                    <td>{{$quote->ShowItem}}</td>
                    <td>{{$quote->Status}}</td>
                    <td><?php
                            if($quote->Metric == 1){
                                echo "Yes";
                                }
                            else{
                                echo "No";
                                }
                        ?>
                    </td>
                    <td>{{$quote->RepID}}</td>
                    <td><a href = {{url('customers')}}><?php
                        $cust = Customer::find($quote->pkeyCust);
                        echo $cust->name;
                            ?></a></td>
                    <td><a href = {{url('reps')}}>
                        <?php
                        $rep = Rep::find($quote->pkeyRep);
                        echo $rep->name;

                            ?></a>
                    </td>

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
    </div>
    <br><br>

    <body>

        <div class="notes-div">
            <h3>Notes</h3>
            <br>
            <textarea readonly rows="4" cols="100">
            {{$quote->Subject}}
        </textarea>
        </div>

        <br><br>

        <div class="table-responsive-models">
            <h3>Models</h3>
            <br>
            <table class="table table-striped models-table">

                <thead>
                    <tr>
                        <th>Model Number</th>
                        <th>Series</th>
                        <th>Hazard Duty</th>
                        <th>Reverse Rotate</th>
                        <th>Required Extra Cable</th>
                        <th>Reel Height</th>
                        <th>Reel Width</th>
                        <th>Reel Depth</th>
                        <th>Reel Weight</th>
                        <th>Picture ID</th>
                        <th>Quote Type</th>
                        <th>Delivery Time</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($models as $model)
                    <tr>
                        <td>{{$model->ModelNum}}</td>
                        <td>{{$model->Series}}</td>
                        <td>{{$model->HazardDuty}}</td>
                        <td>{{$model->ReverseRotate}}</td>
                        <td>{{$model->ReqdExtraCAble}}</td>
                        <td>{{$model->ReelHeight}}</td>
                        <td>{{$model->ReelWeight}}</td>
                        <td>{{$model->ReelDepth}}</td>
                        <td>{{$model->ReelWeight}}</td>
                        <td>{{$model->PictureID}}</td>
                        <td>{{$model->QuoteType}}</td>
                        <td>{{$model->Delivery}}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

        <br><br>

        <div class="table-responsive-reels">
        <h3>Reels</h3>
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
                        <td>{{$reel->modelnum}}</td>
                        <td>{{$reel->qty}}</td>
                        <td>{{$reel->pn}}</td>
                        <td>{{$reel->description}}</td>
                        <td>{{$reel->price}} $</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


    <div class="table-responsive-disc">
        <h3>Discounts</h3>
        <br>
        <table class="table table-striped disc-table">
            @foreach($discounts as $discount)
            <tbody>
                <tr>
                    <th>S Reel Discount</th>
                    <th>S Reel Discount (Additional)</th>
                </tr>

                <tr>
                    <td>{{$discount->SreelDisc1}}%</td>
                    <td>{{$discount->SreelDisc2}}%</td>
                </tr>

                <tr>
                    <th>MMD Reel Discount</th>
                    <th>MMD Reel Discount (Additional)</th>
                </tr>

                <tr>
                    <td>{{$discount->MMDreelDisc1}}%</td>
                    <td>{{$discount->MMDreelDisc2}}%</td>
                </tr>

                <tr>
                    <th>SM Reel Discount</th>
                    <th>SM Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td>{{$discount->SMreelDisc1}}%</td>
                    <td>{{$discount->SMreelDisc2}}%</td>
                </tr>

                <tr>
                    <th>SHO Reel Discount</th>
                    <th>SHO Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td>{{$discount->SHOreelDisc1}}%</td>
                    <td>{{$discount->SHOreelDisc2}}%</td>
                </tr>

                <tr>
                    <th>TMR Reel Discount</th>
                    <th>TMR Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td>{{$discount->TMRreelDisc1}}%</td>
                    <td>{{$discount->TMRreelDisc2}}%</td>
                </tr>

                <tr>
                    <th>UE Reel Discount</th>
                    <th>UE Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td>{{$discount->UEreelDisc1}}%</td>
                    <td>{{$discount->UEreelDisc2}}%</td>
                </tr>

                <tr>
                    <th>CM Reel Discount</th>
                    <th>CM Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td>{{$discount->CMreelDisc1}}%</td>
                    <td>{{$discount->CMreelDisc2}}%</td>
                </tr>

                <tr>
                    <th>P Reel Discount</th>
                    <th>P Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td>{{$discount->PreelDisc1}}%</td>
                    <td>{{$discount->PreelDisc2}}%</td>
                </tr>

                <tr>
                    <th>UH Reel Discount</th>
                    <th>UH Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td>{{$discount->UHreelDisc1}}%</td>
                    <td>{{$discount->UHreelDisc2}}%</td>
                </tr>

                <tr>
                    <th>K Reel Discount</th>
                    <th>K Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td>{{$discount->KreelDisc1}}%</td>
                    <td>{{$discount->KreelDisc2}}%</td>
                </tr>

                <tr>
                    <th>HM Reel Discount</th>
                    <th>HM Reel Discount (Additional)</th>
                </tr>


                <tr>
                    <td>{{$discount->HMreelDisc1}}%</td>
                    <td>{{$discount->HMreelDisc2}}%</td>
                </tr>

            </tbody>
            @endforeach
        </table>
    </div>
    </body>

    <div class="table-responsive-reel-details">
        <h3>Reel Application Details</h3>
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
                    <td>{{$info->Application}}</td>
                    <td>{{$info->Sag}}</td>
                    <td>{{$info->PendantWgt}}</td>
                    <td>{{$info->CenterlineHgt}}</td>
                    <td>{{$info->Travel}}</td>
                    <td>{{$info->Speed}}</td>
                    <td>{{$info->Accel}}</td>
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
                    <td>{{$info->Duty_Cycle}}</td>
                    <td>{{$info->TempMin}}</td>
                    <td>{{$info->TempMax}}</td>
                    <td>{{$info->TempMax}}</td>
                    <td>{{$info->SpringTurns}}</td>
                    <td>{{$info->CCF}}</td>
                    <td>{{$info->DeadWraps}}</td>
                    <td>{{$info->AppNote}}</td>
                </tr>

            </tbody>
            @endforeach
        </table>
    </div>



@stop

@section('scripts')

@stop