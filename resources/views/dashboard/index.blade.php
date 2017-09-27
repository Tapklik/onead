@extends('layouts.default')

@section('content')
        
@component('layouts.partials.title')
    DASHBOARD
@endcomponent

        <dashboard :user="user" :token="token" :trialdate="trialdate"></dashboard>
@stop

@section('footer-js-header')
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/amcharts.js?ver=20170519-02'></script>
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/serial.js?ver=20170519-02'></script>
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/themes/light.js?ver=20170519-02'></script>
@stop
