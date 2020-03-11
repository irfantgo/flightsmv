<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('page_title','Welcome') | {{ env('APP_NAME') }}</title>
    
    @include('heliumframework-css')

    {{-- Icons --}}
    <link rel="icon" type="image/png" href="{{ assets('touch-icons/apple-touch.png') }}">
    <link rel="apple-touch-icon" href="{{ assets('touch-icons/apple-touch.png') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
    <link rel="stylesheet" href="{{ assets( 'adminlte/plugins/fontawesome-free/css/all.min.css' ) }}">
    
    <link rel="stylesheet" href="{{ assets( 'adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css' ) }}">
    <link rel="stylesheet" href="{{ assets( 'adminlte/plugins/select2/css/select2.css' ) }}">
    <link rel="stylesheet" href="{{ assets( 'adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.css' ) }}">
    <link rel="stylesheet" href="{{ assets( 'adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css' ) }}">
    <link rel="stylesheet" href="{{ assets( 'adminlte/plugins/daterangepicker/daterangepicker.css' ) }}">
    <link rel="stylesheet" href="{{ assets( 'adminlte/css/adminlte.css' ) }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <script src="{{ assets( 'js/jquery.js' ) }}"></script>
    
</head>