@extends('layouts.default')

@section('content')

        <v-layout class="header">
            <v-flex xs12>
                <h4>Create A New Campaign</h4>
            </v-flex>
         </v-layout>

        <campaign :user="user" :token="token" :alert1="alert1" :error1="error1" :success1="success1" :alertmessage1="alertmessage1"></campaign>
@stop
