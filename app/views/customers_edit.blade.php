@extends('layouts.master')

@section('page-title')
    {{ $title }}
@stop



@section('content')

    <div class="table-responsive">
        <form method="post" action="{{ url('/customers/update') }}" class="form-horizontal">
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
                @if(Auth::user()->name =='Admin')
                    <th>Representative</th>
                @endif
            </tr>
            </thead>
            <tbody>

                <?php

                //ensures that only those with proper permissions can edit customers

                    //if the customer's currently assigned rep id does not match the id of the rep signed in
                        //of if the admin isn't signed in
                        //redirect away from this page
                if( $customer->rep != Auth::user()->id){
                    if(Auth::user()->name !='Admin'){
                        $messages = new Illuminate\Support\MessageBag;
                        $messages->add('Auth failed', 'You are not authorized to edit this Customer');
                        Redirect::to('/')->withErrors($messages)->send();
                       }
                }

                //get list of companies
                $companies = Company::all();


                //get a list of reps
                $reps = Rep::all();

                ?>
                <tr >
                    <td><select id="company" name="company" class="input-xlarge">
                        <option value="-1">-- New --</option>
                        <?php
                                //print out company names as options
                                foreach($companies as $company){

                                    $compName = $company['attributes']['name'];

                                    //if this is the company the customer belongs to, set it as selected in the drop down
                                    if($company->id == $customer->company_id ){
                                        echo "<option value='$company->id' selected>$compName</option>";
                                    }
                                    else{
                                        echo "<option value='$company->id'>$compName</option>";
                                    }

                                }
                        ?>
                    </select>
                        <input id="company-new" name="newcompany" type="text" placeholder="Company" class="input-xlarge" required="">
                    </td>
                    <td><input type="text" name="name" value="{{ $customer->name}}"></td>
                    <td><input type="text" name="address1" value="{{ $customer->address1}}"></td>
                    <td><input type="text" name="address2" value="{{ $customer->address2}}"></td>
                    <td><input type="text" name="address3"value="{{ $customer->address3}}"></td>
                    <td><input type="text" name="phone" value="{{ $customer->phone }}"></td>
                    <td><input type="text" name="fax" value="{{ $customer->fax }}"></td>
                    <td><input type="text" name="email" value="{{ $customer->email }}"></td>
                    @if(Auth::user()->name =='Admin')
                        <td><select id="rep" name="rep" class="input-xlarge">
                        <?php

                                //print out rep names as options
                                foreach($reps as $rep){

                                    $repName = $rep->name;

                                    //if this is the company the customer belongs to, set it as selected in the drop down
                                    if($rep->id == $customer->rep ){
                                        echo "<option value='$rep->id' selected>$repName</option>";
                                    }
                                    else{
                                        echo "<option value='$rep->id'>$repName</option>";
                                    }
                                }
                        ?>
                        </select></td>
                    @endif
                </tr>
            </tbody>
        </table>
            <input type="hidden" value="{{$customer->id}}" name="customerID">
        <input type="submit" class="btn btn-primary btn-xs btn-nxt" />
        </form>
       <a href="{{ url('/customers')}}"><input value="Back" class="btn btn-primary btn-xs btn-nxt" style="margin-right:3%;" /></a>
    </div>

@stop



@section('scripts')
    <script type="text/javascript">

        //hide new company field
        $('#company-new').hide().removeAttr('required');


        $('#company').change(function() {
            if($(this).val() == -1) {
                $('#company-new').show().attr('required', '');
            }
            else {
                $('#company-new').hide().removeAttr('required');
            }
        });
    </script>
@stop















