@extends('layouts.master')

@section('page-title')
{{ $title }}
@stop

@section('content')
		
<form method="post" action="{{ url('/parts/add') }}" class="form-horizontal">
<fieldset>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="partNum">Part Number *</label>
  <div class="controls">
    <input id="partNum" name="partNum" type="text" placeholder="Number" class="input-xlarge" required="">
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="desc">Description</label>
  <div class="controls">
    <input id="desc" name="desc" type="text" placeholder="Description" class="input-xlarge">
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="price">Unit Price</label>
  <div class="controls">
    <input id="price" name="price" type="text" placeholder="Price" class="input-xlarge">
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="um">U/M *</label>
  <div class="controls">
    <input id="um" name="um" type="text" placeholder="U/M" class="input-xlarge" required="">
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="stk">Stock</label>
  <div class="controls">
    <input id="stk" name="stk" type="text" placeholder="Stock" class="input-xlarge">
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="plc">PLC</label>
  <div class="controls">
    <input id="plc" name="plc" type="text" placeholder="PLC" class="input-xlarge">
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <div class="controls">
    <input type="submit" class="btn btn-primary" />
  </div>
</div>

</fieldset>
</form>
@stop

<!--
@section('scripts')
<script type="text/javascript">

  $('#company').change(function() {
    if($(this).val() == -1) {
      $('#company-new').show().attr('required', '');
    }
    else {
      $('#company-new').hide().removeAttr('required');
    }
  });
</script>
-->