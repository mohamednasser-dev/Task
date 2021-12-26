
@include('layouts.admin_head')
@include('layouts.admin_header')
{{--@include('sweetalert::alert')--}}
@include('layouts.admin_sidebar')
@include('layouts.messages')
@include('layouts.errors')
@yield('content')
{{--@include('layouts.messages')--}}
{{--@include('layouts.errors')--}}

@include('layouts.admin_footer')
