@section('start')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('/vendor/fontawesome-free/css/all.min.css')}}">


    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.css?v=3')}}">

    <script src="{{asset('js/plugins/jquery/jquery.min.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="{{asset('/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('js/plugins/iCheck/all.css')}}">
    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/vendor/overlayScrollbars/css/OverlayScrollbars.min.css')}}">


</head>
@endsection
