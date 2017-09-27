@extends('layouts.default')

@section('content')

@component('layouts.partials.title')
    BILLING
@endcomponent
<billing :user="user" :token="token" ></billing>
@stop
