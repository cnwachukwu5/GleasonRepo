@extends('layouts.master')

@section('page-title')
{{$title}}
@stop

@section('content')
    
<form method="post" action="{{ url('/register') }}" class="form-horizontal">
<fieldset>



<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="name">Representative's name *</label>
  <div class="controls">
    <input id="name" name="name" type="text" placeholder="Name" class="input-xlarge" required="">
    <p class="help-block">Enter Rep's name</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="email">Representative E-mail *</label>
  <div class="controls">
    <input id="email" name="email" type="email" placeholder="RepE-mail" class="input-xlarge" required="">
    <p class="help-block">Enter Rep company</p>
  </div>
</div>

<!-- Text input -->
<div class="control-group">
  <label class="control-label" for="password">Password</label>
  <div class="controls">
    <input id="password" name="password" type="password" placeholder="RepPassword" class="input-xlarge" required="">
    <p class="help-block">Enter Rep's password</p>
  </div>
</div>


<!-- select input-->
  <div class="control-group">
    <label class="control-label" for="company">Company*</label>
    <div class="controls">
      <select id="company" name="company" class="input-xlarge">
        <option value="-1">-- New --</option>
          @foreach ($companies->toArray() as $price)
              <option value="{{ $price['id'] }}">{{ $price['name'] }}</option>
          @endforeach

      </select>
      <input id="company-new" name="newcompany" type="text" placeholder="Company" class="input-xlarge" required="">
      <p class="help-block">Select the company the Rep belongs to</p>
    </div>
  </div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="address1">Address 1 *</label>
  <div class="controls">
    <input id="address1" name="address1" type="text" placeholder="Address" class="input-xlarge" required="">
    <p class="help-block">Enter Rep's address</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="address2">Address 2</label>
  <div class="controls">
    <input id="address2" name="address2" type="text" placeholder="Address" class="input-xlarge">
    <p class="help-block">Enter Rep's address</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="address3">Address 3</label>
  <div class="controls">
    <input id="address3" name="address3" type="text" placeholder="Address" class="input-xlarge">
    <p class="help-block">Enter Rep's address</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="phone">Phone *</label>
  <div class="controls">
    <input id="phone" name="phone" type="text" placeholder="Address" class="input-xlarge" required="">
    <p class="help-block">Enter Rep's phone number</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="fax">Fax</label>
  <div class="controls">
    <input id="fax" name="fax" type="text" placeholder="Fax" class="input-xlarge">
    <p class="help-block">Enter Rep's fax number</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="company_email">Company E-mail</label>
  <div class="controls">
    <input id="company_email" name="company_email" type="email" placeholder="Company E-mail" class="input-xlarge">
    <p class="help-block">Enter Rep's company's email</p>
  </div>
</div>
  <div class="control-group">
    <label class="control-label" for="security_code">Security Code*</label>
    <div class="controls">
      <input id="securityCode" name="security_code" type="number" min="0" max="99" value="99" placeholder="Security Code" class="input-xlarge" required="">
      <p class="help-block">Enter Rep's Security Code</p>
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

