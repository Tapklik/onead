@extends('layouts.default')

@section('content')

@component('layouts.partials.title')
    CREATE CAMPAIGN
@endcomponent

        <campaign :user="user" :token="token" :alert1="alert1" :error1="error1" :success1="success1" :alertmessage1="alertmessage1"></campaign>
@stop
