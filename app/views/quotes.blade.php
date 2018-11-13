@extends('layouts.master')

@section('page-title')
    Quotes
@stop

@section('content')
    <div class="table-responsive">
        <table class="table table-striped quotes-table">
            <thead>
            <tr>
                <th>Prepared By</th>
                @if(Auth::user()->name == 'Admin')
                    <th>Representative</th>
                @endif
                <th>Customer</th>
                <th>Product Line</th>
                <th>Revision</th>
                <th>Last Updated</th>
                <th>Detailed View</th>
                <th>View PDF</th>
                <th>Edit Quote</th>
                <th>Delete Quote</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($quotes as $q)

                <?php
                //get current rep assoc with this quote
                $currentRep = Rep::where('id', '=', $q->pkeyRep)->first();

                //current customer
                $currentCust = Customer::where('id','=',$q->pkeyCust)->first();


                ?>

                @if(Auth::user()->id == $currentRep->id or Auth::user()->name =='Admin' )
                    <tr id="{{$q->quotes_id}}">
                        <input type="hidden" value={{$q->quotes_id}}>
                        <td>{{ $q->RepID }}</td>
                        @if(Auth::user()->name == 'Admin')
                            <td>{{ $currentRep->name }}</td>
                        @endif
                        @if ($currentCust != null)
                            <td>{{ $currentCust->name }}</td>
                        @endif
                        <td id="d1">{{ $q->ProductLine }}</td>
                        <td id="d2">{{ number_format(($q->Revision + 1.0), 1) }}</td>
                        <td id="d3">{{ $q->QuoteDate }}</td>
                        <td id="d4"><a href="{{ url('quote/detail/'.$q->quotes_id) }}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a></td>
                        <td id="d5"><a href="{{ url($q->pdfFilepath) }}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-search"></span></a></td>
                        <td id="d6"><a href="{{ url('quote/edit/'.$q->quotes_id) }}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a></td>
                        <td id="delete"><a   onClick='removeItem({{$q->quotes_id}})' class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span></a></td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>

@stop

@section('scripts')
    <script type="text/javascript">


        $('tbody tr').each(function() {

            var id = $(this).children('input:first').val();
            $(this).children('td').each(function() {

                $(this).css('cursor', 'pointer');
                $(this).on('click', function() {

                //need to be able to target the TD for delete button to stop page reload

                    //something like if(cursor on delete button)
                        //do nothing
                   //else
                            //go to details


                    //console.log($(this).children('td'));
                    //console.log($(this).children('td').attr(id));
                    //window.location.href= "{{url('quote/detail')}}" + "/"+id;

                });

            });
        });

        function removeItem(quoteId) {

            console.log("delete clicked");

                        $.ajax({

                            type: 'POST',
                            url: 'quotes/delete',
                            data:{
                                id: quoteId
                            },
                            dataType: 'text',

                            success: function (data){
                                $("#" + quoteId).remove();

                                console.log(data);

                            }
                        });

        }

    </script>
@stop