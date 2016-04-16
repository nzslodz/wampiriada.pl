@extends('layouts.master')

@section('content')
    {{ Auth::user()->first_name }}
@stop
