@extends('frontend.appother')

@section('content')

   <!-- Header Area Start 
    ====================================================== -->

    <section class="banner-sec internal-banner" style="background-image:url(assets/frontend/img/contact-page.jpg)">

        <!-- Start: slider-overview -->
        <div class="balck-solid">
        
        	<!-- Start: slider -->
            <div class="container">
                <div class="banner-mid-text internal-header">
                
                    <!-- Start: flexslider -->
                    <div class="flexslider">
                        <ul>
                            <!-- Start: flexslider-one -->
                            <li>
                            	<h2>Contact Us</h2>
                                <div class="hr-outtr-line"><hr><i class="fa fa-heart" aria-hidden="true"></i><hr></div>
                            </li>
                            <!-- End: flexslider-one -->
                        </ul>
                    </div>
                    <!-- End: flexslider -->
            
                </div>
            </div> 
            <!-- End: slider -->
            
        </div>  
        <!-- End: slider-overview -->
    </section>
    <!-- =================================================
    Header Area End -->
    
    
   <!-- Contact Us Area Start 
    ====================================================== -->
    <section class="contact-area" id="Welcome">
        <div class="container">
            <div class="row">
            	<!-- Start: Contact Us Content-->
                <div class="contact-middle-area">

                    <p>Please enter correct information in input. you can test email functionality thanks.</p>

                </div>
                <!-- End: Contact Us Content-->
                
                <!-- Start: contact area-->
                <div class="quick-contact-area">
                    <div class="container">
                            <!-- Start: contact left Form-->
                            <div class="quick-contact-box-left">
                                <!-- Start: Quick Contact-Map Form-->
                                
                                <form name="contact" id="contact" method="post">
                                    <div class="contact-form-details">
                                        <ul id="contact-form">
                                            <li><input id="name" type="text" name="name" class="first-field" placeholder="Your Name"></li>
                                            <li><input type="text" name="email" id="email" class="second-field" placeholder="Your Email"></li>
                                            <li><textarea placeholder="Your Message" name="message" id="message" class="forth-field"></textarea></li>
                                            <li><button name="contact" type="button" id="contact-submit" class="input-submit submit">Submit</button></li>
                                        </ul>
                                    </div>
                                    <div id="contact-loading">
                                        Email Sending...
                                    </div>
                                    <div id="contact-success">
                                        Your message sent sucessfully to our team and they will be in touch with you asap.
                                    </div>
                                    <div id="contact-failed">
                                        Error...!, message sending faild , try after sometime.
                                    </div>
                                </form>
                                <!-- End: Quick Contact-Map Form-->
                            </div> 
                            <!-- End: contact left Form-->
                            
                            <!-- Start: Contact-Map-right-->
                            <div class="quick-contact-box-right">
                                <div id="map"></div> 
                            </div>
                            <!-- End: Contact-Map-right-->
                            
                        </div>
                    </div>
                </div>
                <!-- End: contact area-->
                
                
                <!-- Start: Contact Us Address-->
                <div class="contact-list clearfix">
                	<ul>
                    	<!-- Start: Phone Number list-->
                    	<li class="col-md-4">
                        	<i class="fa fa-phone"></i>
                            <h5>Phone Number</h5>
                            <h6>We are happy to answer any time</h6>

                            <a href="#">PH :{!! setting_by_key('phone')!!}</a>

                        </li>
                        <!-- End: Phone Number-->
                        
                        <!-- Start: Contact Address-->
                    	<li class="col-md-4">
                        	<i class="fa fa-home"></i>
                            <h5>Contact Address</h5>
                            <h6>You can directly visit our office</h6>

                            <a href="#">{!! setting_by_key('address')!!}</a>
                            <a href="#">{!! setting_by_key("country") !!}</a>

                        </li>
                        <!-- End: Contact Address-->
                        
                        <!-- Start: Email Address-->
                    	<li class="col-md-4">
                        	<i class="fa fa-envelope-o"></i>
                            <h5>Email Address</h5>
                            <h6>We are happy to answer any questions</h6>

                            <a href="#">{!! setting_by_key('email')!!}</a>

                        </li>
                        <!-- End: Email Address-->
                    </ul>
                </div>
                <!-- End: Contact Us Address list-->
                
        </div>
    </section>
    <!-- =================================================
    Contact Us Area End -->

	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyBRy4cuNgPMeS5sDUj8rZ8Ql4_BkMMf4TM"></script>
	<script> 
	
	function validateEmail(email) {
	  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	  return re.test(email);
	}

	
	$(".submit").on("click" , function() {
		var form_data = {
			name: $("#name").val(),
			email: $("#email").val(),
			message: $("#message").val()
		};
				if($("#name").val() == "" || $("#email").val() == "" || $("#message").val() == "") { 
				swal("Oops" , "Required all fields" , "error");
					return false;
				}
				
				if (!validateEmail($("#email").val())) {
					swal("Oops" , "Your email is invalid" , "error");
					return false;
				}
				
				
				$("#contact-loading").show(200);
				$.ajax({
						type: 'POST',
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						url: '<?php echo url("contact/save"); ?>',
                        data: form_data,
                        success: function (msg) {
                            $("#contact-loading").hide(200);
                            $("#contact-success").show(200);
                            $("#name").val("");
                            $("#email").val("");
                            $("#message").val("");
                        }    
                    });
    });
    
    (function() {
    "use strict";
    
    // --------------------- 01 Map Settings ---------------------
    // --------------------------------------------------------

    // When the window has finished loading create our google map below
    google.maps.event.addDomListener(window, 'load', init);

    function init() {
        // Basic options for a simple Google Map
        // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions = {
            // How zoomed in you want the map to start at (always required)
            zoom: 11,
            scrollwheel: false,

            // The latitude and longitude to center the map (always required)
            center: new google.maps.LatLng({{ setting_by_key("lat") }}, {{ setting_by_key("lng") }}), // New York

            // How you would like to style the map. 
            // This is where you would paste any style found on Snazzy Maps.
            styles: 
            
[{"stylers":[{"saturation":-100},{"gamma":0.8},{"lightness":4},{"visibility":"on"}]},{"featureType":"landscape.natural","stylers":[{"visibility":"on"},{"color":"#5dff00"},{"gamma":4.97},{"lightness":-5},{"saturation":100}]}]

        };

        // Get the HTML DOM element that will contain your map 
        // We are using a div with id="map" seen below in the <body>
        var mapElement = document.getElementById('map');

        // Create the Google Map using our element and options defined above
        var map = new google.maps.Map(mapElement, mapOptions);
        

        // Let's also add a marker while we're at it
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(40.6700, -73.9400),
            map: map,
            title: 'Lumen!'
        });
    }


})(jQuery);
</script>
    

@endsection
