@extends('Frontend.layouts.master')
@section('content')
<appointment-live
:appointment_id="{{$appointment_id}}"
:appointment_fee="{{$appointment_fee}}"

:mentee_id="{{$mentee_id}}"
:url="'{{$url}}'"

></appointment-live>

@endsection
