@extends('layouts.default')

@section('head-js')
var _data = {id: '{!! $id !!}' };
@stop

@section('content')
    <div id="widget-grid">
        <div class="row">
            <div class="col-sm-12">
                <div class="jarviswidget">
                    <header>
                        <span class="widget-icon"> <i class="glyphicon glyphicon-stats"></i> </span>
                        <h2>EDIT CAMPAIGN @{{ section }}</h2>
                    </header>

                    <div class="widget-body">
                        <div class="row">
                            <form action="" novalidate>
                                <campaign-edit :token="token" :user="user"></campaign-edit>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
