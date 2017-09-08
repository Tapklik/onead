@extends('layouts.default')

@section('content')
 <v-layout class="header">
    <v-flex xs12>
        <h4>Reports</h4>
    </v-flex>
</v-layout>
<reporting :user="user" :token="token" ></reporting>
@stop
