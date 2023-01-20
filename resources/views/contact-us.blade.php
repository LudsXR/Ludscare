@php
$url = URL::to('/');
$general_settings= DB::table('general_setting')->find(1);


@endphp
@extends('Frontend.layouts.master')
@section('content')
<contact-us-page url={{$url}} address="{{$general_settings->address}}"
    phone="{{$general_settings->phone}}"
    email_text="{{$general_settings->company_email}}"
    facebook_link="{{$general_settings->facebook_link}}"
    twitter_link="{{$general_settings->twitter_link}}"
    linkden_link="{{$general_settings->linkden_link}}"
    about_company="{{$general_settings->about_company}}"> </contact-us-page>

@endsection
