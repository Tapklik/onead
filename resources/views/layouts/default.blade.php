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
                <header id="header">
                    @include('layouts.partials.header')
                </header>

                <!-- MAIN CONTENT -->
                <div id="content">
                    <tk-popup></tk-popup>
                    <tk-tutorial></tk-tutorial>
                    @yield('layouts.partials.title')

                    @yield('content')
                </div>
                <!-- END MAIN CONTENT -->

                <div class="page-footer">
                    @include('layouts.partials.footer')
                </div>
            </v-container>
        </main>
    </v-app>
</div>

@yield('footer-js-header')
<script src="/js/app.js"></script>
@stop
