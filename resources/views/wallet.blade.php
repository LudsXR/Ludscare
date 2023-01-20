@php
$general_settings= DB::table('general_setting')->find(1);
@endphp
@extends('Frontend.layouts.master')
@section('content')
    <wallet-page url={{$url}} currency_symbol={{$general_settings->currency_symbol }} route={{route('wallet.paytm.order',['','',''])}} liveRoute={{$routeLive}} google_capcha_site_key={{ $googleSiteKey }}> </wallet-page>

@endsection
