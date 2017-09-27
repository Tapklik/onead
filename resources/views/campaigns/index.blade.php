@extends('layouts.default')

@section('content')

@component('layouts.partials.title')
    CAMPAIGNS
@endcomponent
<campaigns :token="token" :user="user" :alert1="alert1" :error1="error1" :success1="success1" :alertmessage1="alertmessage1"></campaigns>
@stop
