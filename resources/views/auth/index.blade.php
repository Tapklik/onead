@extends('layouts.auth')

@section('content')
    <div id="widget-grid">
        <div class="row">
            <div class="col-sm-12">
                <div class="jarviswidget">
                    <header class="text-center">
                        <span class="widget-icon"> <i class="glyphicon glyphicon-stats"></i> </span>
                        <h2>TAPKLIK LOGIN</h2>
                    </header>

                    <auth></auth>
                </div>
            </div>
        </div>
    </div>
@stop
