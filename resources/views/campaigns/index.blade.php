@extends('layouts.default')

@section('content')
 <v-layout class="header">
    <v-flex xs12>
        <h4>Your Campaigns List</h4>
    </v-flex>
</v-layout>
<campaigns :token="token" :user="user"></campaigns>
@stop
