@extends('layouts.master')

@section('page-title')
    {{ $title }}
@stop



@section('content')




    <a href='{{url('/companies/add')}}'>
        <button type='button' class='btn btn-xs btn-success'>Add Company</button>
    </a>


    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Company</th>
                @if(Auth::user()->name == 'Admin')
                <th>Update</th>
                <th>Delete</th>
                @endif
            </tr>
            </thead>
            <tbody>


            @foreach ($companies->toArray() as $price)



                <tr id={{$price['id']}}>


                    @if($price['id']!= 1 && Auth::user()->name == 'Admin')
                        <td><input id="{{$price['id']}}text" type="text" value="{{ $price['name'] }}"></td>
                        <td><a id='{{$price['id']}}Button' onclick='updateItem({{$price['id']}})' class='btn btn-success btn-xs' ><span class='glyphicon-repeat'></span></a></td>
                        <td><a id='{{$price['id']}}Button' onclick='removeItem({{$price['id']}})' class='btn btn-primary btn-xs' ><span class='glyphicon glyphicon-remove'></span></a></td>


                    @else
                        <td><p>{{ $price['name'] }}</p></td>


                    @endif
                </tr>


            @endforeach

            </tbody>
        </table>
    </div>

@stop






@section('scripts')
    <script type="text/javascript">

        function updateItem(rowId) {

            console.log('update fired, id: ' + rowId);

            //get new name from text field
            var newName = $('#' + rowId + 'text').val();

            //update DB
            $.ajax({
                type: 'POST',
                url: 'companies/update',
                data: {
                    id: rowId,
                    newName: newName

                },
                dataType: 'text',
                success: function (data) {


                    alert("Company Updated Successfully")


                }

            });
        }

        function removeItem(rowId) {

            console.log('delete fired, id: ' + rowId);

            $.ajax({
                type:'POST',
                url: 'companies/delete',
                data:{
                    id: rowId
                },
                dataType: 'text',
                success: function (data) {


                        //remove from html
                        $("#" + rowId).remove();
                        $("#" + rowId + "Button").remove();

                        console.log(data);


                    }

            });


        }


    </script>

@stop