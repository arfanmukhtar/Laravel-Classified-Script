@extends('backend.layouts.app')

@section('content')

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
                            <strong>SEO Setitngs</strong>
                        </li>
                    </ol>
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
				<div class="col-lg-10">
					<div class="alert alert-success alert-dismissable" id="successMsg" style="display:none">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Saved Successfully 
					</div>

						<div class="tabs-container">
							<ul class="nav nav-tabs" role="tablist">
								<li><a class="nav-link active" data-toggle="tab" href="#verification">Verification Tools</a></li>
								<li><a class="nav-link " data-toggle="tab" href="#tracking_codes">Tracking Codes</a></li>
								<li><a class="nav-link" data-toggle="tab" href="#robots">Robots.txt</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" id="verification" class="tab-pane active">
									<div class="panel-body">
										<form  method="POST" action="{{route('save-settings')}}" id="VerificationCodes">
										@csrf
											<div class="row">
											<div class="col-lg-10">
													<div class="form-group row" > 
													<div class="col-md-6">
														<label class="col-form-label">Google site verification</label>
														<div class="input-icon right" >
														<input type="text"  name="google_site_verify" class="form-control" id="google_site_verify" @if(!empty($settings['google_site_verify'])) value="{{ $settings['google_site_verify']}}" @endif>
														</div>
													</div>
													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Alexa site verification</label>
														<div class="input-icon right" data-name="lAbpofdC">
														<input type="text"  name="alexa_site_verify" class="form-control" id="alexa_site_verify" @if(!empty($settings['alexa_site_verify'])) value="{{ $settings['alexa_site_verify']}}" @endif>
														</div>
													</div>
												</div>

												<div class="form-group row" >         
													<div class="col-md-6">
														<label class="col-form-label">Bing site verification</label>
														<div class="input-icon right" >
														<input type="text"  name="bing_site_verify" class="form-control" id="bing_site_verify" @if(!empty($settings['bing_site_verify'])) value="{{ $settings['bing_site_verify']}}" @endif>
														</div>
													</div>
													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Yandex site verification</label>
														<div class="input-icon right" data-name="lAbpofdC">
														<input type="text"  name="yandex_site_verification" class="form-control" id="yandex_site_verification"  @if(!empty($settings['yandex_site_verification'])) value="{{ $settings['yandex_site_verification']}}" @endif>
														</div>
													</div>
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
								<div role="tabpanel" id="tracking_codes" class="tab-pane">
									<div class="panel-body">
										<span><b>Note:</b> This code will be add in head section.</span>
										<br>
                                    <form  method="POST" action="{{route('save-settings')}}" id="TrakingCodes">
										@csrf
											<div class="row">
											<div class="col-lg-10">
												<div class="form-group row" > 
													<div class="col-md-6">
														<label class="col-form-label">Google Analytics</label>
														<div class="input-icon right" >
														<textarea type="text" rows="5"  name="google_analytics" class="form-control"  >@if(!empty($settings['google_analytics'])) {{ $settings['google_analytics']}} @endif</textarea>
														</div>
													</div>
													<div class="col-md-6" data-name="UkCYUnJK">
                                                        <label class="col-form-label">Facebook Pixel</label>
														<div class="input-icon right" >
														<textarea type="text"  rows="5"  name="facebook_pixels" class="form-control" >@if(!empty($settings['facebook_pixels'])) {{ $settings['facebook_pixels']}} @endif</textarea>
														</div>
													</div>
													
													<div class="col-md-6" data-name="UkCYUnJK">
                                                        <label class="col-form-label">Google Adsense</label>
														<div class="input-icon right" >
														<textarea type="text" rows="5"  name="google_adsense" class="form-control"  >@if(!empty($settings['google_adsense'])) {{ $settings['google_adsense']}} @endif</textarea>
														</div>
													</div>
													<div class="col-md-6" data-name="UkCYUnJK">
                                                        <label class="col-form-label">Any Other</label>
														<div class="input-icon right" >
														<textarea type="text" rows="5"  name="other_head" class="form-control" id="other_head" >@if(!empty($settings['other_head'])) {{ $settings['other_head']}} @endif</textarea>
														</div>
													</div>
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
							
								<!-- Tab Close -->


                                <div role="tabpanel" id="robots" class="tab-pane">
									<div class="panel-body">
                                    <form  method="POST" action="{{route('save-settings')}}" id="robotsTxt">
										@csrf
											<div class="row">
											<div class="col-lg-10">
												<div class="form-group row" > 
													<div class="col-md-12">
														<label class="col-form-label">Robots.txt</label>
														<div class="input-icon right" >
														<textarea type="text" rows="5"  name="robotstxt" class="form-control" id="robotstxt" >@if(!empty($settings['robotstxt'])) {{ $settings['robotstxt']}} @endif</textarea>
														</div>
													</div>
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
							
								<!-- Tab Close -->

							</div>
					   </div>
					</div>
            </div>
        </div>
            


    <script> 
        $(document).ready(function() {
        $('#VerificationCodes , #TrakingCodes, #robotsTxt ').submit(function(e) {
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
</script> @endsection