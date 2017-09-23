@extends('layouts.default')

@section('content')
        
        <v-layout row wrap class="mt-3 mb-4">
            <v-flex xs12 md4>
                <span class="display-1 grey--text text--lighten2">DASHBOARD</span>
                
                
            </v-flex>
            <v-spacer></v-spacer>
            <controls></controls>
         </v-layout>

        <dashboard :user="user" :token="token" :trialdate="trialdate"></dashboard>
@stop

@section('footer-js-header')
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/amcharts.js?ver=20170519-02'></script>
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/serial.js?ver=20170519-02'></script>
    <script type='text/javascript' src='https://www.amcharts.com/lib/3/themes/light.js?ver=20170519-02'></script>
@stop
