@extends('layouts.master')

@section('page-title')
{{ $title }}
@stop

@section('content')

<form method="post" action="{{ url('/customers/add') }}" class="form-horizontal">
<fieldset>

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

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="name">Customer name *</label>
  <div class="controls">
    <input id="name" name="name" type="text" placeholder="Name" class="input-xlarge" required="">
    <p class="help-block">Enter the customer's name</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="address1">Address 1 *</label>
  <div class="controls">
    <input id="address1" name="address1" type="text" placeholder="Address" class="input-xlarge" required="">
    <p class="help-block">Enter the customer's address</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="address2">Address 2</label>
  <div class="controls">
    <input id="address2" name="address2" type="text" placeholder="Address" class="input-xlarge">
    <p class="help-block">Enter the customer's address</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="address3">Address 3</label>
  <div class="controls">
    <input id="address3" name="address3" type="text" placeholder="Address" class="input-xlarge">
    <p class="help-block">Enter the customer's address</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="phone">Phone *</label>
  <div class="controls">
    <input id="phone" name="phone" type="text" placeholder="Address" class="input-xlarge" required="">
    <p class="help-block">Enter the customer's phone number</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="fax">Fax</label>
  <div class="controls">
    <input id="fax" name="fax" type="text" placeholder="Fax" class="input-xlarge">
    <p class="help-block">Enter the customer's fax number</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="email">E-mail</label>
  <div class="controls">
    <input id="email" name="email" type="email" placeholder="E-mail" class="input-xlarge">
    <p class="help-block">Enter the customer's email</p>
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

@section('scripts')
<script type="text/javascript">

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
