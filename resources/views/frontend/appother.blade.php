<!DOCTYPE html>
<html lang="en" dir="ltr">

@include('frontend.head')
<body>
<div class="loadings" id="loadings"><div class="loader"></div></div>
<div id="wrapper">
@include('frontend.header')
    
        @yield('content')

@include('frontend.footer') 

<script>window.jQuery || document.write('<script src="{{url("assets/js/jquery/jquery-3.3.1.min.js")}}">\x3C/script>')</script>
<script src="{{url('assets/bootstrap/js/bootstrap.bundle.js')}}"></script>
<script src="{{url('assets/js/vendors.min.js')}}"></script>
<script src="{{url('assets/js/main.min.js')}}"></script>


<script> 
  $('.bxslider').bxSlider({
        pagerCustom: '#bx-pager'
    });

</script>

</body>
</html>
