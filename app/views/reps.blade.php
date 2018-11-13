@extends('layouts.master')

@section('page-title')
    {{ $title }}
@stop

@section('content')

    <?php
            //hides link to page unless admin is logged in. Page has filter applied in addition.
        if(Auth::user()->name == 'Admin'){

            $url = url('/register');
            echo "
                <a href='$url'>
        <button type='button' class='btn btn-xs btn-success'>Add Representative</button>
                </a>
            ";

        }

    ?>


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
                <th>Company Email</th>
                <th>Security Code</th>


                <?php
                //hides link to delete button unless admin is logged in. Page has filter applied in addition.
                if(Auth::user()->name =='Admin'){

                    echo "<th>Delete Rep</th>";
                    echo "<th>Edit Rep</th>";
                }
                ?>
    		</tr>
          </thead>
		  <tbody>
             
            @foreach ($reps as $r)
            <tr id="{{$r['attributes']['id']}}">

                <?php
                    //this is done because Admin account has text placeholder, allowing us to skip over it when printing company names
                    if($r['attributes']['name'] !='Admin'){

                        //get company from id of rep
                        $companyID = $r['attributes']['company'];;
                        $company = Company::where('id', '=', $companyID)->first();

                        //get company name from object
                        $companyName = $company['attributes']['name'];

                        //echo table info with company name
                        echo "<td>$companyName</td>";

                    }
                ?>
                <td>{{ $r->name }}</td>
                <td>{{ $r->address1 }}</td>
                <td>{{ $r->address2 }}</td>
                <td>{{ $r->address3 }}</td>
                <td>{{ $r->phone }}</td>
                <td>{{ $r->fax }}</td>
                <td>{{ $r->email }}</td>
                <td>{{$r->company_email}}</td>
                <td>{{$r->security_code}}</td>
                <?php
                //hides link to delete button unless admin is logged in. Page has filter applied in addition.
                if(Auth::user()->name =='Admin'){

                    //regular ID
                    $id = $r['attributes']['id'];
                    //id with the word Button attached so it can be found by the deleting script below
                    $idButton = $id . "Button";

                    //this is to ensure the admin account itself cannot be deleted. It can still be removed via sql if needed for some reason.
                    if($id != 1){
                        echo "
                                <td>
                                <a id='$idButton' class='btn btn-primary btn-xs' onclick='removeItem($id)'>
                                <span class='glyphicon glyphicon-remove'></span></a>
                                </td>

                                <td><a href='reps/edit/$id' class='btn btn-default btn-xs'><span class='glyphicon glyphicon-pencil'></span></a></td>

                                ";
                    }
                }
                ?>

            </tr>
            @endforeach
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
                    <p id="modal-message">This rep has customers associated with it. If deleted, these customers will be assigned to the admin account. Associated quotes will be assigned to admin as well. Continue?</p>
                    <input id="row-id-to-be-deleted" type="hidden" value="">
                </div>
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




            //launch ajax check to see if there are customers associated with this rep
            $.ajax({
                type:'POST',
                url: 'reps/hasCustomers',
                data:{
                    id: rowId
                },
                dataType: 'json',

                success: function (data) {


                    //check for associated customers before delete
                    if(data.hasCustomers) {

                        //display warning before delete
                        $('#confirmDel-modal').modal('show');

                        //store row id of current row to be deleted inside of hidden input tag in modal
                        $('#row-id-to-be-deleted').val(rowId);



                    }
                    else {

                        //if no quotes, delete


                        //fire ajax event to server for removal from DB
                        $.ajax({
                            type:'POST',
                            url: 'reps/delete',
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


                //remove from html
                $("#" + rowId).remove();
                $("#" + rowId + "Button").remove();

                //fire ajax event to server for removal from DB
                $.ajax({
                    type:'POST',
                    url: 'reps/delete',
                    data:{
                        id: rowId
                    },
                    dataType: 'json',
                    success: function (data) {

                        console.log(data);

                    }

                });

            });

        });


    </script>
@stop
