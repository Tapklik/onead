@extends('layouts.default')

@section('content')

@component('layouts.partials.title')
    EDIT CAMPAIGN
@endcomponent
    <campaign :token="token" :user="user"></campaign>
@stop