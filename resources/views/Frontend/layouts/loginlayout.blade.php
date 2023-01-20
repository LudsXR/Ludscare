@include('Frontend.includes.head')
<div id="app">
    <div class="d-none">
    @include('Frontend.includes.header')
    </div>
@yield('content')

</div>
@include('Frontend.includes.foot')
