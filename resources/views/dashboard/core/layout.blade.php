@include('dashboard.core.head')
@include('dashboard.core.sidebar')
@include('dashboard.core.topbar')

@include('dashboard.core.alert')

{{--MAIN--}}
@yield('content')

@include('dashboard.core.foot')
