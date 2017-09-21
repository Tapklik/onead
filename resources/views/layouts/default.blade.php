@extends('layouts.master')

@section('body-class')

@stop

@section('master-content')
    <style>
        #loader {
            z-index: 20;
            position: absolute;
            display: block;
            width: 100%;
            height: 100%;
            opacity: .8;
            text-align: center;
            padding: 25% 0;
            background-color: #000;
            color: #fff;
        }
    </style>
<div id="app">
    <div id="loader" v-show="$root.isLoading">LOADING</div>
<v-app>
    <sidebar></sidebar>
    <main>
        <v-container fluid>
            <header id="header">
                @include('layouts.partials.header')
            </header>

            <!-- MAIN CONTENT -->
            <div id="content">
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
