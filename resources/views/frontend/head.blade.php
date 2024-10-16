<head>
<?php 
     $app_setting = getApplicationSettings();
     $name = !empty($app_setting["title"]) ? $app_setting["title"] : "";
     $slogan = !empty($app_setting["slogan"]) ? $app_setting["slogan"] : "";
     $favicon = !empty($app_setting["favicon"]) ? $app_setting["favicon"] : "";
     $google_analytics = !empty($app_setting["google_analytics"]) ? $app_setting["google_analytics"] : "";
     $facebook_pixels = !empty($app_setting["facebook_pixels"]) ? $app_setting["facebook_pixels"] : "";
     $google_adsense = !empty($app_setting["google_adsense"]) ? $app_setting["google_adsense"] : "";
     $other_head = !empty($app_setting["other_head"]) ? $app_setting["other_head"] : "";
    if(!empty($title))  { 
        $title =  $title . " | " . $name;
    } else { 
        $title = $name . " | " . $slogan;
    }
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @if($favicon)
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/storage/branding/{{$favicon}}">
    <link rel="icon" type="image/png" sizes="32x32" href="/storage/branding/{{$favicon}}">
    <link rel="icon" type="image/png" sizes="16x16" href="/storage/branding/{{$favicon}}">
    <link rel="shortcut icon" href="/storage/branding/{{$favicon}}">
    @endif
    <!-- <link rel="manifest" href="/site.webmanifest"> -->

   
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
    @if(!empty($canonicalUrl))
    <link rel="canonical" href="{{$canonicalUrl}}" />
    @else 
    <link rel="canonical" href="{{url('/')}}" />
    @endif
    <meta name="description" content="Buy Changan Alsvin Accessories and Auto Parts online in Pakistan. Buy Changan Alsvin Parts, Auto Parts, Car care products, Car Seat Covers & Mats at best price. FREE delivery Nationwide. Sell your Changan Alsvin car accessories." />
    <meta name="keywords" content="Changan Auto Parts, Changan Car, Changan Parts, Alsvin, Alsvin Auto Parts, Changan Alsvin arts, Car Parts Buy in Pakistan" />
    {!! seoSiteVerification( $app_setting) !!}

    <title> {{$title}} </title>
   

    <meta property="og:title" content="{{$title}}">
    <meta property="og:site_name" content="{{$title}}">
    <meta property="og:url" content="https://alsvinparts.com/">
    <meta property="og:description" content="Buy Changan Alsvin Accessories and Auto Parts online in Pakistan. Buy Changan Alsvin Parts, Auto Parts, Car care products, Car Seat Covers & Mats at best price. FREE delivery Nationwide. Sell your Changan Alsvin car accessories.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://alsvinparts.com/storage/ChanganAlsvinAutoParts.jpg">
<!-- SITE TITLE -->

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@alsvinparts" />
    <meta name="twitter:title" content="{{$title}}" />
    <meta name="twitter:description" content="Buy Changan Alsvin Accessories and Auto Parts online in Pakistan. Buy Changan Alsvin Parts, Auto Parts, Car care products, Car Seat Covers &amp; Mats at best price. FREE delivery Nationwide. Sell your Changan Alsvin car accessories." />
    <meta name="twitter:image" content="https://alsvinparts.com/storage/ChanganAlsvinAutoParts.jpg" />


    <!-- Bootstrap core CSS -->
    <link href="{{url('assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet">


    <link href="{{url('assets/css/style.css')}}" rel="stylesheet">

    <!-- styles needed for carousel slider -->
    <link href="{{url('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{url('assets/plugins/owl-carousel/owl.theme.css')}}" rel="stylesheet">

    <!-- bxSlider CSS file -->
    <link href="{{url('assets/plugins/bxslider/jquery.bxslider.css')}}" rel="stylesheet"/>

    <!-- include pace script for automatic web page progress bar  -->
    <script>
        paceOptions = {
            elements: true
        };
    </script>
    <script src="{{url('assets/js/pace.min.js')}}"></script>
    <script src="{{url('assets/plugins/modernizr/modernizr-custom.js')}}"></script>
    <script src="{{url('assets/jquery/3.3.1/jquery.min.js')}}"></script>

    <?php $url = secure_url("/"); ?>
  
    @if(!empty($google_analytics))
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-79DWTMCYTS"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{$google_analytics}}');
        </script>
    @endif


    @if(!empty($facebook_pixels))
        <!-- FB Pixels -->
        <script>
            {!!$facebook_pixels!!}
        </script>
    @endif
    @if(!empty($google_adsense))
        <!-- Google Adsense -->
        <script>
            {!!$google_adsense!!}
        </script>
    @endif
    @if(!empty($other_head))
        <!-- Extra JS Code -->
        <script>
            {!!$other_head!!}
        </script>
    @endif

</head>
