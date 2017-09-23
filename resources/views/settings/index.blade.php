@extends('layouts.default')

@section('content')
 <v-layout class="header">
    <v-flex xs12>
        <h4>SETTINGS</h4>
    </v-flex>
</v-layout>
<settings :user="user" :token="token" ></settings>
@stop
