@extends('layouts.master')

@section('body-class')

@stop

@section('master-content')
<div id="app">
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
