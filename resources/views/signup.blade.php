@php
   $general_settings= DB::table('general_setting')->find(1);
@endphp
@extends('Frontend.layouts.loginlayout')
@section('content')
    @if(isset($fbEmail))
        <signup-page url={{$url}} logo={{$general_settings->logo }} fbemail={{$fbEmail}} fbid={{$fbId}}> </signup-page>
    @else
        <signup-page url={{$url}} logo={{$general_settings->logo }}> </signup-page>
    @endif


@endsection
