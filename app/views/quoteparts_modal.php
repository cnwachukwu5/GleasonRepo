@extends('layouts.modal')

@section('modal-title')
Select Customer
@stop

@section('modal-content')
    <div id="cust-table" class="table-responsive">
        <table class="table table-striped">
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

        @foreach ($customers->toArray() as $c)
        <tr>
          <td><input type="hidden" value="{{ $c['id'] }}" /></td>
          <td>{{ Company::find($c['id'])['attributes']['name'] }}</td>
          <td>{{ $c['name'] }}</td>
          <td>{{ $c['address1'] }}</td>
          <td>{{ $c['address2'] }}</td>
          <td>{{ $c['address3'] }}</td>
          <td>{{ $c['phone'] }}</td>
          <td>{{ $c['fax'] }}</td>
          <td>{{ $c['email'] }}</td>
        </tr>

        @endforeach

          </tbody>
        </table>
    </div>
@stop

@section('modal-footer')
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <script type="text/javascript">
   $('#cust-table tbody tr').on('click', function() {
        $('#cust-table tr').removeClass('cust-selected');
        $(this).addClass('cust-selected');
   });
  </script>
@stop
