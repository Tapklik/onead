@extends('layouts.default')

@section('content')
<div id="widget-grid">
    <div class="row">
        <div class="col-sm-12">
            <div class="jarviswidget">
                <header>
                    <span class="widget-icon"> <i class="glyphicon glyphicon-stats"></i> </span>
                    <h2>YOUR CREATIVES VAULT</h2>
                </header>

                <creatives></creatives>
            </div>
        </div>
    </div>
</div>
@stop
