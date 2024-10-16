<!DOCTYPE html>
<html lang="en" dir="ltr">

@include('frontend.head')
<body>
<div id="wrapper">
<div class="loadings" id="loadings"><div class="loader"></div></div>
@include('frontend.header')

        <!-- END MAIN CONTENT -->
<div class="main_content">
        
        @yield('content')
</div>
@include('frontend.footer') 



<script src="{{url('assets/bootstrap/js/bootstrap.bundle.js')}}"></script>
<script src="{{url('assets/js/vendors.min.js')}}"></script>

</body>

</html>
