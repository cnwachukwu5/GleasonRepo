@extends('layouts.master')

@section('page-title')
{{ $title }}
@stop

@section('content')

    @include('modal')

	<a href="{{ url('/parts/add') }}"><button type="button" class="btn btn-xs btn-success">Add Part</button></a>
	<div class="table-responsive">
		<table class="table table-striped">
		  <thead>
    		<tr>
    		  <th>Part Number</th>
    		  <th>Description</th>
    		  <th>Unit Price</th>
    		  <th>U/M</th>
              <th>Stk</th>
    		  <th>PLC</th>
    		</tr>
          </thead>
		  <tbody>


    	@foreach ($parts as $p)
    	<?php $arr = $p->toArray(); ?>
    	<tr>
    	  <td>{{ $arr['number'] }}</td>
    	  <td>{{ $arr['description'] }}</td>
    	  <td>{{ $arr['price'] }}</td>
    	  <td>{{ $arr['unit'] }}</td>
          <td>{{ $arr['stocked'] }}</td>
    	  <td>{{ $arr['plc'] }}</td>
    	</tr>
    	@endforeach

    	  </tbody>
    	</table>
	</div>

@stop

@section('scripts')

<script type="text/javascript">

</script>

@stop