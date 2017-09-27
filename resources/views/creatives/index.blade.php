@extends('layouts.default')


@section('content')

@component('layouts.partials.title')
    CREATIVES VAULT
@endcomponent

        <creatives :user="user" :token="token"></creatives>
@stop