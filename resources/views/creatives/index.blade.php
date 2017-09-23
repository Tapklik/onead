@extends('layouts.default')

@section('content')

        <v-layout class="header">
            <v-flex xs12>
                <h4>CREATIVES VAULT</h4>
            </v-flex>
         </v-layout>

        <creatives :user="user" :token="token"></creatives>
@stop