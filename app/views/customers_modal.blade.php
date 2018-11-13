@extends('layouts.modal')

@section('modal-title')
Select Customer
@stop

@section('modal-content')
    <div class="table-responsive">
       <!--

        This is a small form attached to the select customer modal
        it's been temporarily commented out, can be re-enabled
        check with Steve on thursday and see if its needed

        sanning 11-14-17


       <form id="cust-form" method = "post" action = "{{ url('/customers/add') }}" class="form-horizontal">
          <fieldset>
          <h3>New Customer</h3>
          <table id="add-table" class="table table-striped">
            <thead>
              <tr>
                <td>Company</td>
                <td>Name</td>
                <td>Address 1</td>
                <td>Address 2</td>
                <td>Address 3</td>
                <td>Phone</td>
                <td>Fax</td>
                <td>Email</td>
              </tr>
            </thead>
            <tbody>
              <tr id="add-controls">
                <td>
                  <div class="control-group">
                    <label class="control-label" for="company">Company name *</label>
                    <div class="controls">
                      <select id="company" name="company" class="input-xlarge">
                        <option value="-1">-- New --</option>
                        @foreach ($companies->toArray() as $price)
                          <option value="{{ $price['id'] }}">{{ $price['name'] }}</option>
                        @endforeach
                      </select>
                      <input id="company-new" name="newcompany" type="text" placeholder="Company" class="input-xlarge" required="">
                      <p class="help-block">Select the company the customer belongs to</p>
                    </div>
                  </div>
                </td>
                <td><input id="name" name="name" type="text" placeholder="Name" class="form-control"></td>
                <td><input id="address1" name="address1" type="text" placeholder="Address 1" class="form-control"></td>
                <td><input id="address2" name="address2" type="text" placeholder="Address 2" class="form-control"></td>
                <td><input id="address3" name="address3" type="text" placeholder="Address 3" class="form-control"></td>
                <td><input id="phone" name="phone" type="text" placeholder="Phone" class="form-control"></td>
                <td><input id="fax" name="fax" type="text" placeholder="fax" class="form-control"></td>
                <td><input id="email" name="email" type="text" placeholder="email" class="form-control"></td>
              </tr>
            </tbody>
          </table>
          <div class="control-group">
            <div class="controls">
              <input id="cust_submit" type="submit" class="btn btn-primary" />
            </div>
          </div>
        <fieldset>
        </form>-->
        <h3>Existing Customer</h3>
        <table id="cust-table" class="table table-striped">
          <thead>
            <tr>
              <th></th>
              <th>Company</th>
              <th>Name</th>
              <th>Address 1</th>
              <th>Address 2</th>
              <th>Address 3</th>
              <th>Phone</th>
              <th>Fax</th>
              <th>E-mail</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($customers as $price)
            <?php $company = $price->company()->first(); ?>
            <tr>
              <td><input type="text" hidden id="customerid" value="{{ $price->id }}" /></td>
              <td>{{ $company['attributes']['name'] }}</td>
              <td>{{ $price->name }}</td>
              <td>{{ $price->address1 }}</td>
              <td>{{ $price->address2 }}</td>
              <td>{{ $price->address3 }}</td>
              <td>{{ $price->phone }}</td>
              <td>{{ $price->fax }}</td>
              <td>{{ $price->email }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
    </div>
@stop

@section('modal-footer')
  <button type="button" class="btn btn-default cust-close" data-dismiss="modal">Close</button>
  <script type="text/javascript">

    //selects the desired cust.
   $('#cust-table tbody tr').on('click', function() {
        $('#cust-table tr').removeClass('cust-selected');
        $(this).addClass('cust-selected');
   });

   $(function() {
     $('.cust-close').on('click', function (e) {
       customerid = $('.cust-selected #customerid').val();
     });
   });

   //creates new cust, puts selection on new cust.
   $('#cust_submit').on("click", function(e) {
      e.preventDefault();
      $.post("{{ url('/customers/add/json') }}", $('#cust-form').serialize()).done(function(data) {
        data = JSON.parse(data);
        console.log(data);
          $('#cust-table tbody').append($('<tr>')
            .append($('<td>').append($('<input>').attr('type', 'hidden').val(data.id)))
            .append($('<td>').text(data.company))
            .append($('<td>').text(data.name))
            .append($('<td>').text(data.address1))
            .append($('<td>').text(data.address2))
            .append($('<td>').text(data.address3))
            .append($('<td>').text(data.phone))
            .append($('<td>').text(data.fax))
            .append($('<td>').text(data.email))
            .on('click', function() {
              $('#cust-table tr').removeClass('cust-selected');
              $(this).addClass('cust-selected');
            }).trigger('click'));
      });
   });
  </script>
@stop
