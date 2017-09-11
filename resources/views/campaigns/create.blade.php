@extends('layouts.default')

@section('content')

        <v-layout class="header">
            <v-flex xs12>
                <h4>Create A New Campaign</h4>
            </v-flex>
         </v-layout>

        <campaign :user="user" :token="token"></campaign>
@stop
