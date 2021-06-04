<!DOCTYPE html>
<html>

@php
$title = !empty($title) ? $title : '';
$desc = !empty($desc) ? $desc : '';
$keywords = !empty($keywords) ? $keywords : '';
@endphp

<head>
    <script type="text/human">
/*

 * Public Book library 

*/

    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="keyword" content="{{ $keywords }}" />
    @if ($desc)
    <meta name="description" content="{{ $desc }}" />
    @endif
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.ico">
    <link rel="stylesheet"
        href="{{ asset('assets/css/dashboard.css') }}?{{ File::lastModified('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{env('APP_URL')}}/vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css">
    <script src="{{env('APP_URL')}}/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link rel="stylesheet" href="{{env('APP_URL')}}/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css">


</head>

<body>
    @include('common.header')
    <div class="main container-fluid card my-5">
        @yield('content')
    </div>
    @include('common.footer')

    {{-- scripts --}}

    <script src="{{env('APP_URL')}}/vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js"></script>



</body>

</html>
