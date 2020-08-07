@extends('layouts.myapp')


@section('content')
<our-service page-slug="{{$slug}}" url="{{url()->current()}}"></our-service>
@endsection