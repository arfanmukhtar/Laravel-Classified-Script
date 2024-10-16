@include('backend.partials.header')
 
<body>

<div id="wrapper">
	
        @include('backend.partials.navbar')
		 <div id="page-wrapper" class="gray-bg">
        @include('backend.partials.topbar')
		<br>
        @include('backend.partials.notification')

        @yield('content')
		
		 <div class="footer">
            <div class="pull-right">
               
            </div>
            <div>
                <strong>Copyright</strong>  &copy; {{date("Y")}}
            </div>
        </div>
		</div>
    </div>
    <!-- Scripts -->
     <!-- Mainly scripts -->

    <script src="{{url('assets/backend/js/popper.min.js')}}"></script>
    <script src="{{url('assets/backend/js/bootstrap.js')}}"></script>
    <script src="{{url('assets/backend/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{url('assets/backend/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{url('assets/backend/js/inspinia.js')}}"></script>
    <script src="{{url('assets/backend/js/plugins/pace/pace.min.js')}}"></script>

   
</body>
</html>