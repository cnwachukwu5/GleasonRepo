<h3>Customer Information</h3>
<div class="form-group">
	<div style="height:300px; left:10px;">
		<div>
			<p>Customer Name:</p>
			<input readonly id="cust-name" name="cust-name" style="height:30px;">
				{{--@if (isset($quote) && $quote->customer()->first() != null) {{ $quote->customer()->first()->address1  }} {{ $quote->customer()->first()->company_id }} @endif--}}
			</input>
			<p>Customer Address</p>
			<input readonly id="cust-addr" name="cust-addr" style="height:30px;">
				{{--@if (isset($quote) && $quote->customer()->first() != null) {{ $quote->customer()->first()->address1 }} {{ $quote->customer()->first()->id }} @endif--}}
				</input>
			<p>Company</p>
			<input readonly id="cust-comp" name="cust-comp" style="height:30px;">
				{{--@if (isset($quote) && $quote->customer()->first() != null) {{ $quote->customer()->first()->address1 }} {{ $quote->customer()->first()->id }} @endif--}}
			</input>
			<p>Phone Number</p>
			<input readonly id="cust-phone" name="cust-phone" style="height:30px;">
				{{--@if (isset($quote) && $quote->customer()->first() != null) {{ $quote->customer()->first()->address1 }} {{ $quote->customer()->first()->id }} @endif--}}
			</input>
		<br>

		<br>





		</div>

	</div>
	<div>
	<a class="btn btn-primary btn-xs" id="selectCustomer" data-toggle="modal" data-target="#modal" href="{{ url('/package/customer/select') }}">Select customer</a>
	</div>
</div>

<script type="text/javascript">
$(function () {
	$(document).on("click", "#selectCustomer", function () {
        $('input[name=measureUnit]').delay().attr('disabled', true);
        //selVal = $('input[name=measureUnit]:checked').val();
        //alert("MetricValue: " + selVal);
    });
});


</script>
