@extends('layouts.default')

@section('content')

@component('layouts.partials.title')
    SETTINGS
@endcomponent
<settings :user="user" :token="token" ></settings>
@stop
