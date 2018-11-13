@extends('layouts.master')

@section('page-title')
    {{ $title }}
@stop

@section('content')



            <a href='{{url('/customers/add')}}'>
              <button type='button' class='btn btn-xs btn-success'>Add Customer</button>
            </a>


    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Name</th>
                    <th>Address 1</th>
                    <th>Address 2</th>
                    <th>Address 3</th>
                    <th>Phone</th>
                    <th>Fax</th>
                    <th>E-mail</th>
                    <?php
                        //display the rep associated with each customer if logged in as admin
                    if(Auth::user()->name == 'Admin')
                        echo "<th>Representative</th>"

                    ?>
                    <th>Delete Customer</th>
                    <th>Edit Customer</th>
                </tr>
            </thead>
            <tbody>


                @foreach ($customers as $price)
                    @if($price['attributes']['rep'] == Auth::user()->id || Auth::user()->name == 'Admin' )

                    <?php $company = $price->company()->first(); ?>
                    <tr id={{$price['attributes']['id']}}>
                        <td>{{ $company['attributes']['name'] }}</td>
                        <td>{{ $price->name }}</td>
                        <td>{{ $price->address1 }}</td>
                        <td>{{ $price->address2 }}</td>
                        <td>{{ $price->address3 }}</td>
                        <td>{{ $price->phone }}</td>
                        <td>{{ $price->fax }}</td>
                        <td>{{ $price->email }}</td>
                        <?php
                        if(Auth::user()->name == 'Admin'){
                            //get rep based on ID stored in customer
                            $rep = Rep::find($price->rep);
                            //print row with rep name
                            echo "<td>$rep->name</td>";
                        }
                        ?>
                        <td><a id='{{$price['attributes']['id']}}Button' onclick='removeItem({{$price['attributes']['id']}})' class='btn btn-primary btn-xs' ><span class='glyphicon glyphicon-remove'></span></a></td>
                        <td><a href="{{ url('customers/edit/'.$price['attributes']['id']) }}" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    </tr>

                    @endif
                @endforeach

                <!--



                Use to put input in the fields themselves
                <tr id="add-controls">
                    <td><input id="company" type="text" placeholder="Company" class="input-xlarge"></td>
                    <td><input id="name" type="text" placeholder="Name" class="input-xlarge"></td>
                    <td><input id="address1" type="text" placeholder="Address 1" class="input-xlarge"></td>
                    <td><input id="address2" type="text" placeholder="Address 2" class="input-xlarge"></td>
                    <td><input id="address3" type="text" placeholder="Address 3" class="input-xlarge"></td>
                    <td><input id="phone" type="text" placeholder="Phone" class="input-xlarge"></td>
                    <td><input id="fax" type="text" placeholder="fax" class="input-xlarge"></td>
                    <td><input id="email" type="text" placeholder="E-mail" class="input-xlarge"></td>
                    <td><button id="add" type="button" class="btn btn-success btn-xs">Add customer</button></td>
                </tr>
                -->
            </tbody>
        </table>
    </div>
    <div id="confirmDel-modal" class="modal fade" tabindex="-1" role="dialog" {{--style="display: none;"--}}>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Warning</h4>
                </div>
                <div class="modal-body">
                    <p>This customer has quotes and/or packages associated with it. All quotes, packages, and package contents associated with this customer will be lost, are you sure you want to continue?</p>
                </div>
                <input id="row-id-to-be-deleted" type="hidden" value="">
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete Customer</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

@stop

@section('scripts')

    <script type="text/javascript">



        function removeItem(rowId) {
            console.log("delete clicked");
            $.ajax({
                type:'POST',
                url: 'customers/hasQuotes',
                data:{
                    id: rowId
                },
                dataType: 'json',
                success: function (data) {

                   //check for associated quotes before delete
                    if(data.hasQuotes) {
                        $('#confirmDel-modal').modal('show');
                        //store row id of current row to be deleted inside of hidden input tag in modal
                        $('#row-id-to-be-deleted').val(rowId);
                    }
                    else {

                    //if no quotes, delete

                    //remove from html
                        $("#" + rowId).remove();
                        $("#" + rowId + "Button").remove();

                    //fire ajax event to server for removal from DB

                        $.ajax({
                            type:'POST',
                            url: 'customers/deletePost',
                            data:{
                                id: rowId
                            },
                            dataType: 'json'
                        });

                    }


                }
            });


        }

        $(document).ready(function() {

            //confirm delete button on modal page
            $('#confirmDelete').click(function() {

                //get data from hidden input inside modal. Information is sent to this input containing the row id
                //of the customer to he deleted. It's stored here so it can be accessed outside of the scope of the
                //original function call
                var rowId = $('#row-id-to-be-deleted').val();

                //get rid of modal
                $("#confirmDel-modal").modal('hide');


                $("#" + rowId).remove();
                $("#" + rowId + "Button").remove();


                $.ajax({
                    type:'POST',
                    url: 'customers/deletePost',
                    data:{
                        id: rowId
                    },
                    dataType: 'json'
                });

            });


        });
    </script>
@stop