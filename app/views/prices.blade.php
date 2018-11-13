@extends('layouts.master')

@section('page-title')
    {{ $title }}
@stop



@section('content')





    <div class="table-responsive">
        <h3>Select Parts to View</h3>
        <select id="displayTypeSelector" onChange="displaySelectChanged(this.value)">
            <?php
                //create blank array to store file types
                $styleTypeArray = Array();
                //add 'all' option
                $styleTypeArray[] = "All";
                //for each price, add its style to this array if it is not present.
                foreach($prices as $price){
                    if(!in_array($price->style, $styleTypeArray) ){
                        $styleTypeArray[] = $price->style;
                    }
                 }

                //for each style in the style options array, print out a select option
                foreach($styleTypeArray as $style){
                    echo " <option value='$style'>$style</option>";
                }
                ?>
        </select>


        <table class="table table-striped" id="priceRecordTable">
            <thead>
            <tr>
                <th>Style</th>
                <th>Part Number</th>
                <th>Current Price</th>
                @if(Auth::user()->name == 'Admin')
                    <th>Update By Percentage</th>
                    <th>New Price</th>
                    <th>Update</th>
                @endif
            </tr>
            </thead>
            <tbody>


            @foreach ($prices as $price)



                <tr id='{{$price -> id}}TR' value='{{$price->style}}' style="">


                    @if(Auth::user()->name == 'Admin')
                        <td><input id="{{$price -> id}}style" type="text" disabled value="{{ $price -> style}}"></td>
                        <td><input id="{{$price -> id}}pnValue" type="text" disabled value="{{ $price -> pnValue}}"></td>
                        <td><input id="{{$price -> id}}currentPrice" type="text" disabled value="{{ $price -> price}}"></td>
                        <td><input id="{{$price -> id}}percentage" type="number" min="-100" max="100" value=""> </td>
                        <td><input id="{{$price -> id}}newPrice" type="number" value=""></td>
                        <td><a id='{{$price->id}}Button' onclick='updateItem({{$price->id}})' class='btn btn-success btn-xs' ><span class='glyphicon-repeat'></span></a></td>

                    @else
                        <td><input id="{{$price -> id}}style" type="text" disabled value="{{ $price -> style}}"></td>
                        <td><input id="{{$price -> id}}pnValue" type="text" disabled value="{{ $price -> pnValue}}"></td>
                        <td><input id="{{$price -> id}}currentPrice" type="text" disabled value="{{ $price -> price}}"></td>

                    @endif
                </tr>


            @endforeach

            </tbody>
        </table>
    </div>

@stop






@section('scripts')
    <script type="text/javascript">


        function displaySelectChanged(selectedValue){


            //loop through record table , and if table row style type is not that which is selected, hide it
            var table = document.getElementById("priceRecordTable");
            for (var i = 0, row; row = table.rows[i]; i++) {




                //if 'All' is selected
                if(selectedValue == "All"){
                    currElm = document.getElementById($(row).attr('id'));

                    $(currElm).show();
                }
                //if current row does not match selected value, then hide it
                else if($(row).attr('value') != selectedValue){


                    currElm = document.getElementById($(row).attr('id'));

                    $(currElm).hide();


                }
                //if current row does match selected value, show element
                else{

                    currElm = document.getElementById($(row).attr('id'));

                    $(currElm).show();
                }

            }

        }




        function updateItem(rowId) {

            console.log('update fired, id: ' + rowId);

            //current price in HTML
            var currentPrice =  $('#' + rowId + 'currentPrice').val();
            //get new price from text field
            var newPrice = $('#' + rowId + 'newPrice').val();
            //get percentage value
            var percentageMod = $('#' + rowId + 'percentage').val();

            //if manual new price entry is empty, use percentage to apply
            if(newPrice == 0){

                //check for negative
                if(percentageMod > 0){
                    //(non negative case)
                    percentageMod = (percentageMod / 100) + 1 ;

                    //multiply the percent mod by current price
                    newPrice = currentPrice * percentageMod;

                    //round down new prices
                    Math.floor(newPrice);
                }
                else{
                    //convert to positive int
                    percentageMod= percentageMod * -1;

                    //negative case
                    percentageMod = percentageMod / 100;
                    console.log(percentageMod);

                    //multiply the percent mod by current price
                    newPrice = currentPrice - (currentPrice * percentageMod) ;

                    //round down new prices
                    Math.floor(newPrice);

                    console.log(newPrice);
                }





           $.ajax({
               type: 'POST',
               url: 'prices/update',
               data: {
                   id: rowId,
                   newPrice: newPrice

               },
               dataType: 'text',
               success: function (data) {

                   //update html to be equal to new DB entry
                   $('#' + rowId + 'currentPrice').val(newPrice);
                   //set new price to 0
                   $('#' + rowId + 'newPrice').val("");
                   //set percentage to 0
                   $('#' + rowId + 'percentage').val("");

               }
           });


            }//end if
            else{

                //price update no percentage

                $.ajax({
                    type: 'POST',
                    url: 'prices/update',
                    data: {
                        id: rowId,
                        newPrice: newPrice

                    },
                    dataType: 'text',
                    success: function (data) {

                        //update html to be equal to new DB entry
                        $('#' + rowId + 'currentPrice').val(newPrice);
                        //set new price to 0
                        $('#' + rowId + 'newPrice').val("");

                    }
                });
            } //end else

            //finish
        }



    </script>

@stop