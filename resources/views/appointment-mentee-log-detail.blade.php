@php
$general_settings= DB::table('general_setting')->find(1);
@endphp
@extends('Frontend.layouts.master')
@section('content')
    <appointment-mentee-log-detail-page url={{$url}} appointment_id={{$appointment_id}} currency_symbol={{$general_settings->currency_symbol }}> </appointment-mentee-log-detail-page>
@endsection
