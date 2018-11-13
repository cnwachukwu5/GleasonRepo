@extends('layouts.master')

@section('page-title')
    {{ $title }}
@stop



@section('content')

    <div class="table-responsive">
        <form method="post" action="{{ url('/reps/update') }}" class="form-horizontal">
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
                    <th>Password</th>
                    <th>Company E-mail</th>
                    <th>Security Code</th>
                </tr>
                </thead>
                <tbody>

                <?php


                //get list of companies
                $companies = Company::all();



                ?>
                <tr >
                    <td><select id="company" name="company" class="input-xlarge">
                            <option value="-1">-- New --</option>
                            <?php


                            //print out company names as options
                            foreach($companies as $company){

                                //TODO: Fix the company section once db field has been corrected

                                $compName = $company['attributes']['name'];

                                //if this is the company the customer belongs to, set it as selected in the drop down
                                if($company->id == $rep->company ){
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
                    <td><input type="text" name="name" value="{{ $rep->name}}"></td>
                    <td><input type="text" name="address1" value="{{ $rep->address1}}"></td>
                    <td><input type="text" name="address2" value="{{ $rep->address2}}"></td>
                    <td><input type="text" name="address3"value="{{ $rep->address3}}"></td>
                    <td><input type="text" name="phone" value="{{ $rep->phone }}"></td>
                    <td><input type="text" name="fax" value="{{ $rep->fax }}"></td>
                    <td><input type="text" name="email" value="{{ $rep->email }}"></td>
                    <td><input type="text" name="password" value=""></td>
                    <td><input type="text" name="companyEmail" value="{{ $rep->company_email }}"></td>
                    <td><input type="text" name="securityCode" value="{{ $rep->security_code }}"></td>


                </tr>
                </tbody>
            </table>
            <input type="hidden" value="{{$rep->id}}" name="repID">
            <input type="submit" class="btn btn-primary btn-xs btn-nxt" />
        </form>
        <a href="{{ url('/reps')}}"><input value="Back" class="btn btn-primary btn-xs btn-nxt" style="margin-right:3%;" /></a>
    </div>

@stop



@section('scripts')
    <script type="text/javascript">
       //hide new company field
        $('#company-new').hide().removeAttr('required');

        $('#company').change(function() {
            if($(this).val() == -1) {
                //if new is selected, unhide the input field and make it requpired.
                $('#company-new').show().attr('required', '');
            }
            else {
                //otherwise, hide it and make it not required
                $('#company-new').hide().removeAttr('required');
            }
        });
    </script>
@stop















