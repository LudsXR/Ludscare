@extends('Frontend.layouts.master')
@section('content')

    @if (isset($appointmentid))
        <appointment-schedule-page url={{ $url }} mentor_id={{ $mentor_id }} google_capcha_site_key={{ $googleSiteKey }}
            route={{ route('paytm.order', ['', '', '']) }} liveRoute={{ $routeLive }} appointmentid={{ $appointmentid }}>
        </appointment-schedule-page>
    @else

        <appointment-schedule-page url={{ $url }} mentor_id={{ $mentor_id }}
            route={{ route('paytm.order', ['', '', '']) }} liveRoute={{ $routeLive }} google_capcha_site_key={{ $googleSiteKey }}>
        </appointment-schedule-page>
    @endif
@endsection

