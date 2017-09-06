@extends('layouts.default')

@section('content')
        
        <v-layout class="header">
            <v-flex xs12>
                <h4>Dashboard</h4>
            </v-flex>
         </v-layout>

        <dashboard :user="user"></dashboard>
@stop

@section('footer-js-header')
    <!--<script type='text/javascript' src='https://www.amcharts.com/lib/3/amcharts.js?ver=20170519-02'></script>
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/serial.js?ver=20170519-02'></script>
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/themes/light.js?ver=20170519-02'></script>-->
@stop
