@extends('layouts.default')

@section('content')

@component('layouts.partials.title')
    CREATE CAMPAIGN
@endcomponent

    <campaign :user="user" :token="token"></campaign>
@stop
