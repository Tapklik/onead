@extends('layouts.default')

@section('content')

        <v-layout class="header">
            <v-flex xs12>
                <h4>Create a new campaign</h4>
            </v-flex>
         </v-layout>

        <campaign :user="user"></campaign>
@stop
