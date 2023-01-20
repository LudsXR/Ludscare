@extends('Frontend.layouts.master')
@section('content')
<appointment-live-payment
:appointment_id="{{$appointment_id}}"
:appointment_fee="{{$appointment_fee}}"
:url="'{{URL::to('/');}}'"

></appointment-live-payment>

@endsection
