  @php
    $url = URL::to('/');
   $general_settings= DB::table('general_setting')->find(1);
@endphp
<site-header url={{$url}} logo={{$general_settings->logo }} currency_symbol={{$general_settings->currency_symbol }}> </site-header>
