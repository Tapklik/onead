@extends('layouts.default')

@section('content')

@component('layouts.partials.title')
    CAMPAIGNS
@endcomponent
<campaigns :token="token" :user="user"></campaigns>
@stop
