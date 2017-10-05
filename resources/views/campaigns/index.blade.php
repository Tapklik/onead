@extends('layouts.default')

@section('head-js')
    @if(\Illuminate\Support\Facades\Input::get('m'))
        var data = {message: '{{ \Illuminate\Support\Facades\Input::get('m') }}'};
    @endif
@stop

@section('content')

@component('layouts.partials.title')
    CAMPAIGNS
@endcomponent
<campaigns :token="token" :user="user"></campaigns>
@stop
