<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/uikit.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <title>{{config('app.name')}}</title>
</head>
<body>
    <div id="app">
    @if(Auth::check())
        <header-component user="{{Auth::user()->email}}"></header-component>
    @else
        <header-component user=""></header-component>
    @endif

        @yield('content')
        <footer-component></footer-component>
    </div>
    <script type="application/javascript" src="{{asset('js/uikit.min.js')}}"></script>
    <script type="application/javascript" src="{{asset('js/uikit-icons.min.js')}}"></script>
    <script type="application/javascript" src="{{mix('js/app.js')}}?<?php echo filemtime('js/app.js') ?>"></script>
</body>
</html>