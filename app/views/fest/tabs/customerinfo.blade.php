<h3>Customer Information</h3>
<div class="form-group">
	<div style="height:300px; left:10px;">
		<div>
			<p>Customer Name:</p>
		<span id="cust-name" style="height:100px;">

			@if (isset($quote) && $quote->customer()->first() != null) {{ $quote->customer()->first()->name  }} {{ $quote->customer()->id }} @endif
		</span>
		<br>
		<br>





		</div>

	</div>
	<div>
	<a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal" href="{{ url('/package/customer/select') }}">Select customer</a>
	</div>
</div>

<script type="text/javascript">



</script>
