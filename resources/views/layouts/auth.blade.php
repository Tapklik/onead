@extends('layouts.master')

@section('body-class')

@stop

@section('master-content')
<div id="app">
<v-app>
    <main>
        <v-container fluid class="tapklik-gradient fill-height"> 

            <!-- MAIN CONTENT -->
                @yield('content')
            <!-- END MAIN CONTENT -->

        </v-container>
    </main>
</v-app>
</div>

@yield('footer-js-header')

<script src="/js/app.js"></script>
@stop
