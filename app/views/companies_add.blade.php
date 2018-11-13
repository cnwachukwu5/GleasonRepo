@extends('layouts.master')

@section('page-title')
    {{ $title }}
@stop



@section('content')


    <form method="post" action="{{url('/companies/add')}}">

        <label for="newCompName">Company Name</label>
        <input type="text" name="newCompName" required>


        <input type="submit" class="btn btn-primary" />

    </form>

    @stop