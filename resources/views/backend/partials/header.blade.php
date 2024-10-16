<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{$title ?? setting_by_key('title')}}  | {{setting_by_key('title')}} </title>

    @php 
   
    $favicon =  setting_by_key('favicon'); 
    
    @endphp
    @if($favicon)
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/storage/branding/{{$favicon}}">
    <link rel="icon" type="image/png" sizes="32x32" href="/storage/branding/{{$favicon}}">
    <link rel="icon" type="image/png" sizes="16x16" href="/storage/branding/{{$favicon}}">
    <link rel="shortcut icon" href="/storage/branding/{{$favicon}}">
    @endif

    <link href="{{url('assets/backend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('assets/backend/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{url('assets/backend/css/animate.css')}}" rel="stylesheet">
    <link href="{{url('assets/backend/css/style.css')}}" rel="stylesheet">
    <link href="{{url('assets/backend/css/custom.css')}}" rel="stylesheet">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script>
        window.Laravel = <?php echo json_encode(
            [
            'csrfToken'  => csrf_token(),
            'siteUrlApi' => url('api'),
            'tokenApi'
            ]
        ); ?>
    </script>
    <script src="{{url('assets/backend/jquery-3.1.1.min.js')}}"></script>
   

</head>
