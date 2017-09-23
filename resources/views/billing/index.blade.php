@extends('layouts.default')

@section('content')
 <v-layout class="header">
    <v-flex xs12>
        <h4>BILLING</h4>
    </v-flex>
</v-layout>
<billing :user="user" :token="token" ></billing>
@stop
