@extends('layouts.master')

@section('page-title')
Sign in
@stop

@section('content')
<form class="form-signin" role="form" method="post" action="{{ url('/sign-in') }}">
	<h2>Please sign in</h2>
	<input name="email" type="email" class="form-control" placeholder="Email" required="" autofocus="" >
	<input name="password" type="password" class="form-control" placeholder="Password" required="" >
	<label class="checkbox">
		<input type="checkbox" value="remember-me"><small>Remember me</small></input>
	</label>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
	<br>

</form>

@stop

@section('scripts')
@stop