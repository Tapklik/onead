@extends('layouts.master')

@section('body-class')

@stop

@section('master-content')

<div id="app">
    <div class="loader" v-show="$root.isLoading">
        <div class="loader-container">
            <div class="loader-logo">
                <div class="loader-spinner"></div>
                <div class="loader-inner-logo"></div>
            </div>
            <div class="loader-text">LOADING</div>
        </div> 
    </div>    
    <v-app v-cloak>
        <sidebar></sidebar>
        <main>
            <v-container fluid>

                <!-- MAIN CONTENT -->
                <div id="content">
                    <tk-popup></tk-popup>
                    @yield('layouts.partials.title')

                    @yield('content')
                </div>
                <!-- END MAIN CONTENT -->

            </v-container>
        </main>
    </v-app>
</div>

@yield('footer-js-header')
<script src="/js/app.js"></script>
@stop
