@extends('layouts.master')

@section('body-class')
    smart-style-tapklik menu-on-side fixed-navigation
@stop

@section('master-content')

    <div id="main" role="main">
        <div id="app">
            <!-- MAIN CONTENT -->
            <div id="content">
                @yield('content')
            </div>
            <!-- END MAIN CONTENT -->
        </div>
    </div>

    <div class="page-footer">
        @include('layouts.partials.footer')
    </div>

    @include('layouts.partials.modal')

    <script src="/js/app.js"></script>
    <!--script src="/js/all.js"></script-->
@stop
