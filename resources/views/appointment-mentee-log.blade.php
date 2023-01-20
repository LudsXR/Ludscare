@php
$general_settings= DB::table('general_setting')->find(1);
@endphp
@extends('Frontend.layouts.master')
@section('content')
    <appointment-mentee-log-page url={{$url}} currency_symbol={{$general_settings->currency_symbol }}> </appointment-mentee-log-page>

@endsection
