@extends('Frontend.layouts.master')
@section('content')
<appointment-payment-page url={{$url}} route={{route('paytm.order',['','',''])}}> </appointment-payment-page>

@endsection
