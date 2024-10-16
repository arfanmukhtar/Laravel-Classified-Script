@extends('backend.layouts.app')

@section('content')

<link href="/assets/css/select2.min.css" rel="stylesheet" />
<link href="/assets/backend/css/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
<script src="/assets/backend/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>


<?php 
    $settings = getApplicationSettings();
?>
		<div class="row wrapper border-bottom white-bg page-heading">
			<div class="col-lg-10">
				<h2> </h2>
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="{{url('')}}">@lang('common.home')</a>
					</li>
					<li class="breadcrumb-item active">
						<strong>Application Settings</strong>
					</li>
				</ol>
			</div>
		</div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
				<div class="col-lg-12">
						<div class="alert alert-success alert-dismissable" id="successMsg" style="display:none">
							<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
							Saved Successfully 
						</div>

						<div class="tabs-container">
							<ul class="nav nav-tabs" role="tablist">
								<li><a class="nav-link active" data-toggle="tab" href="#general">General</a></li>
								<li><a class="nav-link" data-toggle="tab" href="#mail">SMTP</a></li>
								<li><a class="nav-link" data-toggle="tab" href="#social">Social Links</a></li>
								<li><a class="nav-link" data-toggle="tab" href="#logins">Social Logins</a></li>
								<li><a class="nav-link" data-toggle="tab" href="#frontend">Color & Style</a></li>
								<li><a class="nav-link" data-toggle="tab" href="#google_captcha">Google Captcha</a></li>
								<!-- <li><a class="nav-link" data-toggle="tab" href="#credits">Credits</a></li> -->
							</ul>
							<div class="tab-content">
								<div role="tabpanel" id="general" class="tab-pane active">
									<div class="panel-body">
										<form  method="POST" action="{{route('save-settings')}}" id="generalSetting">
										@csrf
											<div class="row">
											<div class="col-lg-10">

												<div class="form-group row" >         
													<div class="col-md-6">
														<label class="col-form-label">Application Title</label>
														<div class="input-icon right" data-name="AcUUxgGk">
														<input type="text" required name="title" class="form-control" id="title" value="{{ $settings['title'] ?? ''}}">
														</div>
													</div>
													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Application Slogon</label>
														<div class="input-icon right" data-name="lAbpofdC">
														<input type="text" required name="slogan" class="form-control" id="slogan" value="{{ $settings['slogan'] ?? ''}}">
														</div>
													</div>
												</div>

												<div class="form-group row" >         
													<div class="col-md-6">
														<label class="col-form-label">Application Type</label>
														<div class="input-icon right" data-name="AcUUxgGk">
														<select class="select2 form-control" name="application_type" id="type">
															<option value="All">All</option>
															<option @if(!empty($settings['application_type']) and  $settings['application_type'] == "Classified") selected @endif value="Classified">Classified</option>
															<option @if(!empty($settings['application_type']) and  $settings['application_type'] == "Real Estate") selected @endif  value="Real Estate">Real Estate</option>
															<option @if(!empty($settings['application_type']) and  $settings['application_type'] == "Automobile") selected @endif  value="Automobile">Automobile</option>
															<option @if(!empty($settings['application_type']) and  $settings['application_type'] == "Other") selected @endif value="Other">Other</option>
													 </select>
														</div>
													</div>


													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Operating Country</label>
														<div class="input-icon right" data-name="lAbpofdC">
														<select class="select2 form-control"  name="op_country" style="height: 36px;width: 100%;">
														<?php  $countries = getTableData("countries"); ?> 
															  
															   @foreach( $countries as $country)
															   <?php  $name = json_decode($country->name , true); 
																		$name = $name["en"];
																   ?>
																   <option @if(!empty($settings['op_country']) and $settings['op_country'] == $country->id) selected @endif  value="{{$country->id}}">{{$name}}</option>
															   @endforeach
														</select>
														</div>
													</div>

													
													<?php /* <div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Operating Countries</label>
														<div class="input-icon right" data-name="lAbpofdC">
															<select class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" name="op_country[]" id="op_country" data-width="100%" data-filter="true" data-action-onchange="true" data-select-all="true" data-placeholder="Filter by admin">
															   <?php  $countries = getTableData("countries");
															   	$selected_countries = array();
																if(!empty($settings['op_country']))
															   		$selected_countries = json_decode($settings['op_country'], true);
																	
															 	  ?> 
															   <!-- <option value="All">All</option> -->
															   @foreach( $countries as $country)
																   <?php  $name = json_decode($country->name , true); 
																		$name = $name["en"];
																   ?>
																   <option @if(!empty($selected_countries) and in_array($country->id, $selected_countries)) selected @endif  value="{{$country->id}}">{{$name}}</option>
															   @endforeach
															</select>
														</div>
													</div> */ ?>
												</div>

												<div class="form-group row" >
													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Currency</label>
														<div class="input-icon right" data-name="lAbpofdC">
														<select class="select2 form-control"  name="currency" style="height: 36px;width: 100%;">
															   <?php  $currencies = getTableData("currencies");?> 
															  
															    @foreach( $currencies as $currency)
																   <?php  $name = $currency->name;
																   ?>
																   <option @if(!empty($settings['currency']) and $settings['currency'] == $currency->id) selected @endif  value="{{$currency->id. "-" . $currency->symbol}}">{{$name}} ({{$currency->symbol}})</option>
															   @endforeach
														</select>
														</div>
													</div>

													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Timezone</label>
														<div class="input-icon right" data-name="lAbpofdC">
														<select class="select2 form-control"  name="timezone" style="height: 36px;width: 100%;">
															<option value="All">All (Not Specific)</option>
															    @foreach( $timezones as $timezone)
																   <option @if(!empty($settings['timezone']) and $settings['timezone'] == $timezone->timezone) selected @endif  value="{{$timezone->timezone}}">{{$timezone->timezone_location}}</option>
															   @endforeach
														</select>
														</div>
													</div>

												</div>


												<div class="form-group row" >
													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Currency View (K, M)</label>
														<div class="input-icon right" data-name="lAbpofdC">
															<select class=" form-control"  name="currency_view" style="height: 36px;width: 100%;">
																<option value="Simple">Simple</option>
																<option value="HumanReadable">Human Readable</option>
															</select>
														</div>
													</div>

													<!-- <div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Timezone</label>
														<div class="input-icon right" data-name="lAbpofdC">
														
														</div>
													</div> -->

												</div>


												<div class="form-group row">
													<div class="col-sm-4 col-sm-offset-2">
														
														<button class="btn btn-primary btn-sm" type="submit">Save changes</button>
													</div>
												</div>

											</div>

										</div>
										</form>

									</div>
								</div>
								<div role="tabpanel" id="mail" class="tab-pane">
									<div class="panel-body">
                                    <form  method="POST" action="{{route('save-settings')}}" id="mailSetting">
										@csrf
                                        <div class="row">
											<div class="col-lg-10">

												<div class="form-group row" >         
													<div class="col-md-6">
														<label class="col-form-label">From Name</label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<input type="text" required name="from_name" class="form-control" id="from_name" @if(!empty($settings['from_name'])) value="{{ $settings['from_name']}}" @endif>
														</div>
													</div>
													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">From Email</label>
														<div class="input-icon right" data-name="lAbpofdC">
															<input type="text" required name="from_email" class="form-control" id="from_email" @if(!empty($settings['from_email'])) value="{{ $settings['from_email']}}" @endif>
														</div>
													</div>
												</div>

												<div class="form-group row" >         
													<div class="col-md-6">
														<label class="col-form-label">Host</label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<input type="text" required name="mail_host" class="form-control" id="mail_host" @if(!empty($settings['mail_host'])) value="{{ $settings['mail_host']}}" @endif>
														</div>
													</div>
													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Port</label>
														<div class="input-icon right" data-name="lAbpofdC">
															<input type="text" required name="mail_port" class="form-control" id="mail_port" @if(!empty($settings['mail_port'])) value="{{ $settings['mail_port']}}" @endif>
														</div>
													</div>
												</div>

												<div class="form-group row" >         
													<div class="col-md-6">
														<label class="col-form-label">Username</label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<input type="text" required name="mail_username" class="form-control" id="mail_username" @if(!empty($settings['mail_username'])) value="{{ $settings['mail_username']}}" @endif>
														</div>
													</div>
													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Password</label>
														<div class="input-icon right" data-name="lAbpofdC">
															<input type="text" required name="mail_password" class="form-control" id="mail_password" @if(!empty($settings['mail_password'])) value="{{ $settings['mail_password']}}" @endif>
														</div>
													</div>
												</div>


												<div class="form-group row" >         
													<div class="col-md-6">
														<label class="col-form-label">Mail Encryption</label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<select name="mail_encryption" class="form-control" >
																<option value="">None</option>
																<option @if(!empty($settings['mail_encryption']) && $settings['mail_encryption']== "ssl") selected @endif value="ssl">SSL</option>
																<option @if(!empty($settings['mail_encryption']) && $settings['mail_encryption']== "tls") selected @endif value="tls">TLS</option>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<label class="col-form-label">Allow Self Assign</label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<select name="allow_self_signed" class="form-control">
																<option @if(!empty($settings['allow_self_signed']) && $settings['allow_self_signed']== "false") selected @endif  value="false">False</option>
																<option value="true" @if(!empty($settings['allow_self_signed']) && $settings['allow_self_signed']== "true") selected @endif >True</option>
															</select>
														</div>
													</div>
													
												</div>

												<div class="form-group row" >         
													<div class="col-md-6">
														<label class="col-form-label">Verify Peer</label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<select name="verify_peer" class="form-control">
															<option @if(!empty($settings['verify_peer']) && $settings['verify_peer']== "false") selected @endif  value="false">False</option>
																<option value="true" @if(!empty($settings['verify_peer']) && $settings['verify_peer']== "true") selected @endif >True</option>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<label class="col-form-label">Verify Peer Name</label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<select name="verify_peer_name" class="form-control">
															<option @if(!empty($settings['verify_peer_name']) && $settings['verify_peer_name']== "false") selected @endif  value="false">False</option>
																<option value="true" @if(!empty($settings['verify_peer_name']) && $settings['verify_peer_name']== "true") selected @endif >True</option>
															</select>
														</div>
													</div>
													
												</div>


												

                                                <div class="form-group row">
													<div class="col-sm-4 col-sm-offset-2">
														
														<button class="btn btn-primary btn-sm" type="submit">Save changes</button>
														<button class="btn btn-success btn-sm" id="validateSmtp" type="button">Validate SMTP</button>
													</div>
												</div>

											</div>
										</div>
                                    </form>
									</div>
								</div>
								<div role="tabpanel" id="social" class="tab-pane">
									<div class="panel-body">
									<form  method="POST" action="{{route('save-settings')}}" id="socialLinks">
										@csrf
										<div class="form-group row" >
											
											<div class="col-md-6">
												<label class="col-form-label">Facebook
													
												</label>
												<div class="input-icon right" data-name="AcUUxgGk">
													<input type="text" name="facebook_url" @if(!empty($settings['facebook_url'])) value="{{ $settings['facebook_url']}}" @endif class="form-control" />
												</div>
											</div>
											<div class="col-md-6" >
												<label class="col-form-label">Twitter</label>
												<div class="input-icon right" data-name="lAbpofdC">
													<input type="text" name="twitter_url" @if(!empty($settings['twitter_url'])) value="{{ $settings['twitter_url']}}" @endif class="form-control"/>
												</div>
											</div>
										</div>	
										<div class="form-group row" >
											<div class="col-md-6" >
												<label class="col-form-label">Youtube</label>
												<div class="input-icon right" data-name="lAbpofdC">
													<input type="text" name="youtube_url" @if(!empty($settings['youtube_url'])) value="{{ $settings['youtube_url']}}" @endif class="form-control"/>
												</div>
											</div>
											<div class="col-md-6" >
												<label class="col-form-label">LinkendIn</label>
												<div class="input-icon right" data-name="lAbpofdC">
													<input type="text" name="linkedin_url" @if(!empty($settings['linkedin_url'])) value="{{ $settings['linkedin_url']}}" @endif class="form-control"/>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<div class="col-sm-4 col-sm-offset-2">
												
												<button class="btn btn-primary btn-sm" type="submit">Save changes</button>
											</div>
										</div>
										</form>
									</div>
								</div>

								<!-- Tab Close -->

								<div role="tabpanel" id="logins" class="tab-pane">
									<div class="panel-body">
									<form  method="POST" action="{{route('save-settings')}}" id="socialSetting">
										@csrf
										<div class="form-group row" >
											
											<div class="col-md-6">
												<label class="col-form-label">Facebook Status</label>
												<div class="input-icon right" data-name="AcUUxgGk">
													<select name="facebook_switch" class="form-control">
														<option value="on">Enable</option>
														<option value="off">Disable</option>
													</select>
													
												</div>
											</div>
											<div class="col-md-6">
												<label class="col-form-label">Facebook  Callback URL</label>
												<div class="input-icon right" data-name="AcUUxgGk">
													<input type="text" name="fb_callback" @if(!empty($settings['fb_callback'])) value="{{ $settings['fb_callback']}}" @endif class="form-control" />
												</div>
											</div>
											<div class="col-md-6">
												<label class="col-form-label">Facebook App ID</label>
												<div class="input-icon right" data-name="AcUUxgGk">
													<input type="text" name="fb_app_id" @if(!empty($settings['fb_app_id'])) value="{{ $settings['fb_app_id']}}" @endif class="form-control" />
												</div>
											</div>
											<div class="col-md-6" >
												<label class="col-form-label">Facebook Seceret Key </label>
												<div class="input-icon right" data-name="lAbpofdC">
													<input type="text" name="fb_secret" @if(!empty($settings['fb_secret'])) value="{{ $settings['fb_secret']}}" @endif class="form-control"/>
												</div>
											</div>
										</div>	

										<div class="form-group row" >
											
										<div class="col-md-6">
												<label class="col-form-label">Google Status</label>
												<div class="input-icon right" data-name="AcUUxgGk">
													<select name="google_switch" class="form-control">
														<option value="on">Enable</option>
														<option value="off">Disable</option>
													</select>
													
												</div>
											</div>
											<div class="col-md-6">
												<label class="col-form-label">Google  Callback URL</label>
												<div class="input-icon right" data-name="AcUUxgGk">
													<input type="text" name="google_callback" @if(!empty($settings['google_callback'])) value="{{ $settings['google_callback']}}" @endif class="form-control" />
												</div>
											</div>

											<div class="col-md-6">
												<label class="col-form-label">Google App ID</label>
												<div class="input-icon right" data-name="AcUUxgGk">
													<input type="text" name="google_app_id" @if(!empty($settings['google_app_id'])) value="{{ $settings['google_app_id']}}" @endif class="form-control" />
												</div>
											</div>
											<div class="col-md-6" >
												<label class="col-form-label">Google Seceret Key</label>
												<div class="input-icon right" data-name="lAbpofdC">
													<input type="text" name="google_secret" @if(!empty($settings['google_secret'])) value="{{ $settings['google_secret']}}" @endif class="form-control"/>
												</div>
											</div>
										</div>	


										<div class="form-group row" >
											
										<div class="col-md-6">
												<label class="col-form-label">LinkedIn Status</label>
												<div class="input-icon right" data-name="AcUUxgGk">
													<select name="linkedin_switch" class="form-control">
														<option value="on">Enable</option>
														<option value="off">Disable</option>
													</select>
													
												</div>
											</div>
											<div class="col-md-6">
												<label class="col-form-label">LinkedIn Callback URL</label>
												<div class="input-icon right" data-name="AcUUxgGk">
													<input type="text" name="linkedin_login_key" @if(!empty($settings['linkedin_login_key'])) value="{{ $settings['linkedin_login_key']}}" @endif class="form-control" />
												</div>
											</div>

											<div class="col-md-6">
												<label class="col-form-label">Google App ID</label>
												<div class="input-icon right" data-name="AcUUxgGk">
													<input type="text" name="linkedin_login_key" @if(!empty($settings['linkedin_login_key'])) value="{{ $settings['linkedin_login_key']}}" @endif class="form-control" />
												</div>
											</div>
											<div class="col-md-6" >
												<label class="col-form-label">Google Seceret Key</label>
												<div class="input-icon right" data-name="lAbpofdC">
													<input type="text" name="linkedin_login_secret" @if(!empty($settings['linkedin_login_secret'])) value="{{ $settings['linkedin_login_secret']}}" @endif class="form-control"/>
												</div>
											</div>
										</div>	

										
										<div class="form-group row">
											<div class="col-sm-4 col-sm-offset-2">
												
												<button class="btn btn-primary btn-sm" type="submit">Save changes</button>
											</div>
										</div>
										</form>
									</div>
								</div>

								<!-- Tab Close -->

								<div role="tabpanel" id="frontend" class="tab-pane">
									<div class="panel-body">
									<form  method="POST" action="{{route('save-settings')}}" id="colorScheme">
										@csrf
										<div class="form-group row" >
											<div class="col-md-6">
												<label class="col-form-label">Main Color</label>
												<div class="input-icon right" data-name="AcUUcxgGk">
													<input type="text" name="main_color" class="form-control demo1" @if(!empty($settings['main_color'])) value="{{ $settings['main_color']}}" @endif  />
												</div>
											</div>
											<div class="col-md-6">
												<label class="col-form-label">Links Color</label>
												<div class="input-icon right" data-name="AcUUxgGk">
													<input type="text"  name="link_color" class="form-control demo1" @if(!empty($settings['link_color'])) value="{{ $settings['link_color']}}" @endif  />
												</div>
											</div>

										</div>	
										
										<div class="form-group row">
											<div class="col-sm-4 col-sm-offset-2">
												
												<button class="btn btn-primary btn-sm" type="submit">Save changes</button>
											</div>
										</div>
										</form>
									</div>
								</div>

								<!-- Tab Close -->
								<div role="tabpanel" id="google_captcha" class="tab-pane">
									<div class="panel-body">
									<form  method="POST" action="{{route('save-settings')}}" id="googleRecaptcha">
										@csrf
										<div class="form-group row" >
											
											<div class="col-md-6">
												<label class="col-form-label"> ID </label>
												<div class="input-icon right" data-name="AcUUxgGk">
												<select  class="form-control" name="recaptcha_version" id="recaptcha_version" >
													<option value="">Disable</option>
													<option <?php if(!empty($settings['recaptcha_version']) and $settings['recaptcha_version'] == "v2")  echo "selected"; ?> value="v2">v2</option>
													<option <?php if(!empty($settings['recaptcha_version']) and $settings['recaptcha_version'] == "v3")  echo "selected"; ?> value="v3">v3 (invisible)</option>
												</select>
												</div>
											</div>
											<div class="col-md-6">
												<label class="col-form-label"> Site Key </label>
												<div class="input-icon right" data-name="AcUUxgGk">
													<input type="text" name="recaptcha_site_key" @if(!empty($settings['recaptcha_site_key'])) value="{{ $settings['recaptcha_site_key']}}" @endif class="form-control" />
												</div>
											</div>
											<div class="col-md-6" >
												<label class="col-form-label">Site Sercet</label>
												<div class="input-icon right" data-name="lAbpofdC">
													<input type="text" name="recaptcha_secret_key" @if(!empty($settings['recaptcha_secret_key'])) value="{{ $settings['recaptcha_secret_key']}}" @endif class="form-control"/>
												</div>
											</div>
										</div>	
										
										<div class="form-group row">
											<div class="col-sm-4 col-sm-offset-2">
												
												<button class="btn btn-primary btn-sm" type="submit">Save changes</button>
											</div>
										</div>
										</form>
									</div>
								</div>

							
								
							</div>
					   </div>
					</div>
            </div>
        </div>
            

<script src="/assets/js/bootstrap-multiselect.js"></script>
<script src="/assets/js/components-bootstrap-multiselect.min.js"></script>
<script src="/assets/js/select2.min.js"></script>
<script> 
    $(document).ready(function() {
		$("#op_country").multiselect();
		$(".select2").select2();

		$("body").on("click", "#validateSmtp", function() { 
			var form = $("#mailSetting");

			$.ajax({
                url: "validate_smtp",
                method: "POST",
                data: form.serialize(),
                success: function(response) {
                    // Handle the success response
                    console.log(response);
                    $("#successMsg").show();
                    setTimeout(function() { 
                        $("#successMsg").hide();
                    } , 1000)
                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    console.log(xhr.responseText);
                }
            });

		});
        $('#generalSetting , #mailSetting , #socialSetting, #googleRecaptcha, #socialLinks, #colorScheme').submit(function(e) {
            e.preventDefault(); // Prevent form submission

            var form = $(this);

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    // Handle the success response
                    console.log(response);
                    $("#successMsg").show();
                    setTimeout(function() { 
                        $("#successMsg").hide();
                    } , 1000)
                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script> 


<script> 
 $('.demo1').colorpicker();
 </script>



@endsection