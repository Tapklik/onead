@extends('layouts.default')

@section('head-js')
var _data = {id: '{!! $id !!}' };
@stop

@section('content')

@component('layouts.partials.title')
    EDIT CAMPAIGN
@endcomponent      
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
