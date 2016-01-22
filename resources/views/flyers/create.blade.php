@extends('layout')
@section('content')
<h1>Selling Your Home?</h1>
    <hr>
<form method="POST" action="{{ url('flyers') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        @include('flyers.form')
</form>
@stop
