@extends('layouts.myapp')


@section('content')
@if(Auth::check()) 
    <home-component user="{{Auth::user()->email}}"></home-component>
@else
    <home-component user=""></home-component>
@endif
@endsection