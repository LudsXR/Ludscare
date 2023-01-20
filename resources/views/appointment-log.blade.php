
  @php
 $general_settings= DB::table('general_setting')->find(1);
@endphp
@extends('Frontend.layouts.master')
@section('content')
    <appointment-log-page url={{$url}} currency_symbol={{$general_settings->currency_symbol }}> </appointment-log-page>

@endsection
