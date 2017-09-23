@extends('layouts.default')

@section('content')
 <v-layout class="header">
    <v-flex xs12>
        <h4>CAMPAIGNS LIST</h4>
    </v-flex>
</v-layout>
<campaigns :token="token" :user="user" :alert1="alert1" :error1="error1" :success1="success1" :alertmessage1="alertmessage1"></campaigns>
@stop
