<footer class="main-footer">
    	<div class="footer-content">
    		<div class="container">
    			<div class="row">
				<?php 
					$footer = getTableFieldData("pages" , "title" , "footer" , "body");
					$sections = json_decode($footer,true);
					
				?>
    				<div class=" col-xl-2 col-xl-2 col-md-2 col-6  ">
						@if(!empty($sections["section1"])){!!$sections["section1"]!!}@endif
    				</div>

    				<div class=" col-xl-2 col-xl-2 col-md-2 col-6  ">
					@if(!empty($sections["section1"])){!!$sections["section2"]!!}@endif
    				</div>

    				<div class=" col-xl-2 col-xl-2 col-md-2 col-6  ">
					@if(!empty($sections["section1"])){!!$sections["section3"]!!}@endif
    				</div>
    				<div class=" col-xl-2 col-xl-2 col-md-2 col-6  ">
					@if(!empty($sections["section1"])){!!$sections["section4"]!!}@endif
    				</div>
    				<div class=" col-xl-4 col-xl-4 col-md-4 col-12">
    					<div class="footer-col row">

    						

    						<div class="col-sm-12 col-xs-6 col-xxs-12 no-padding-lg">
    							<div class="hero-subscribe">
    								<h4 class="footer-title no-margin">Follow us on</h4>
    								<ul class="list-unstyled list-inline footer-nav social-list-footer social-list-color footer-nav-inline">
										@php
											$facebookUrl = (!empty($app_setting["facebook_url"])) ? $app_setting["facebook_url"] : "";
											$twitterUrl = (!empty($app_setting["twitter_url"])) ? $app_setting["twitter_url"] : "";
											$youtubeUrl = (!empty($app_setting["youtube_url"])) ? $app_setting["youtube_url"] : "";
											$linkedinUrl = (!empty($app_setting["linkedin_url"])) ? $app_setting["linkedin_url"] : "";
										@endphp
										@if($facebookUrl)
										<li><a class="icon-color fb" title="Facebook" data-placement="top" data-toggle="tooltip" href="{{$facebookUrl}}"><i class="fab fa-facebook-f"></i> </a></li>
										@endif
										@if($twitterUrl)
    									<li><a class="icon-color tw" title="Twitter" data-placement="top" data-toggle="tooltip" href="{{$twitterUrl}}"><i class="fab fa-twitter"></i> </a></li>
										@endif
										@if($linkedinUrl)
    									<li><a class="icon-color lin" title="Linkedin" data-placement="top" data-toggle="tooltip" href="{{$linkedinUrl}}"><i class="fab fa-linkedin"></i> </a></li>
										@endif
										@if($youtubeUrl)
    									<li><a class="icon-color pin" title="Youtube" data-placement="top" data-toggle="tooltip" href="{{$youtubeUrl}}"><i class="fab fa-youtube-p"></i> </a></li>
    									@endif
    								</ul>
    							</div>

    						</div>
    					</div>
    				</div>
    				<div style="clear: both"></div>

    				<div class="col-xl-12">
    			

    					<div class="copy-info text-center">
    						&copy; <?php echo date("Y") ?> Changan Auto Parts. All Rights Reserved.
    					</div>

    				</div>

    			</div>
    		</div>
    	</div>
    </footer>