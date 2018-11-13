@extends('layouts.master')

@section('page-title')
Edit {{$user->name}}'s Profile
@stop

@section('content')
		
<form method="post" action="{{ url('/profile') }}" class="form-horizontal">
<fieldset>


<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="company">Company *</label>
  <div class="controls">
    <input id="company" name="company" type="text" placeholder="Company" class="input-xlarge" required="" value="{{ $user->company }}">
  </div>
</div>
  <br>
<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="address1">Address 1 *</label>
  <div class="controls">
    <input id="address1" name="address1" type="text" placeholder="Address 1" class="input-xlarge" required="" value="{{ $user->address1 }}">
  </div>
</div>
  <br>
<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="address2">Address 2</label>
  <div class="controls">
    <input id="address2" name="address2" type="text" placeholder="Address 2" class="input-xlarge" value="{{ $user->address2 }}">
  </div>
</div>
  <br>
<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="address3">Address 3</label>
  <div class="controls">
    <input id="address3" name="address3" type="text" placeholder="Address 3" class="input-xlarge" value="{{ $user->address3 }}">
  </div>
</div>
  <br>
<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="phone">Phone *</label>
  <div class="controls">
    <input id="phone" name="phone" type="text" placeholder="Phone" class="input-xlarge" required="" value="{{ $user->phone }}">
  </div>
</div>
  <br>
<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="phone">Fax</label>
  <div class="controls">
    <input id="fax" name="fax" type="text" placeholder="Fax" class="input-xlarge" value="{{ $user->fax }}">
  </div>
</div>
<br>
<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="email">Email</label>
  <div class="controls">
    <input id="email" name="email" type="text" placeholder="Email" class="input-xlarge" value="{{ $user->email }}">
  </div>
</div>
  <br>
  <!-- Text input-->
  <div class="control-group">
    <label class="control-label" for="email">Password</label>
    <div class="controls">
      <input id="password" name="password" type="text" placeholder="Password" class="input-xlarge" value="">
    </div>
  </div>
  <br>
<b></b>
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