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
                            <strong>Application Settings</strong>
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
								<li><a class="nav-link active" data-toggle="tab" href="#BankTransfer">Bank Transfer</a></li>
								<li><a class="nav-link" data-toggle="tab" href="#general">Stripe</a></li>
								<li><a class="nav-link" data-toggle="tab" href="#mail">Paypal</a></li>
							</ul>
							<div class="tab-content">
							<div role="tabpanel" id="BankTransfer" class="tab-pane active">
									<div class="panel-body">
										<form  method="POST" action="{{route('save-settings')}}" id="bankSetting">
										@csrf
											<div class="row">
											<div class="col-lg-10">

												
													<div class="form-group row" > 
														<div class="col-md-6">
															<label class="col-form-label">Bank Accounts</label>
															<div class="input-icon right" data-name="AcUUxgGk">
															<textarea type="text" rows="10" required name="bank_account" class="form-control" id="bank_account">@if(!empty($settings['bank_account'])){{ $settings['bank_account']}}@endif</textarea>
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

								<div role="tabpanel" id="general" class="tab-pane">
									<div class="panel-body">
										<form  method="POST" action="{{route('save-settings')}}" id="stripeSetting">
										@csrf
											<div class="row">
											<div class="col-lg-10">

												<div class="form-group row" >    
												<div class="col-md-12">
														<label class="col-form-label">Sandbox Key</label>
														<div class="input-icon right" data-name="AcUUxgGk">
																<select name="stripe_mode" class="form-control">
																	<option  @if(!empty($settings['stripe_mode']) AND $settings['stripe_mode'] == "sandbox") selected @endif value="sandbox">Sandbox</option>
																	<option  @if(!empty($settings['stripe_mode']) AND $settings['stripe_mode'] == "live" ) selected @endif value="live">Live</option>
																</select>
														</div>
													</div>
													</div>
													<div class="form-group row" > 
													<div class="col-md-6">
														<label class="col-form-label">Sandbox Key</label>
														<div class="input-icon right" data-name="AcUUxgGk">
														<input type="text" required name="sandbox_key" class="form-control" id="sandbox_key" @if(!empty($settings['sandbox_key'])) value="{{ $settings['sandbox_key']}}" @endif>
														</div>
													</div>
													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Sandbox Secret</label>
														<div class="input-icon right" data-name="lAbpofdC">
														<input type="text" required name="sandbox_secret" class="form-control" id="sandbox_secret" @if(!empty($settings['sandbox_secret'])) value="{{ $settings['sandbox_secret']}}" @endif>
														</div>
													</div>
												</div>

												<div class="form-group row" >         
													<div class="col-md-6">
														<label class="col-form-label">Live Key</label>
														<div class="input-icon right" data-name="AcUUxgGk">
														<input type="text" required name="live_key" class="form-control" id="live_key" @if(!empty($settings['live_key'])) value="{{ $settings['live_key']}}" @endif>
														</div>
													</div>
													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Live Secret</label>
														<div class="input-icon right" data-name="lAbpofdC">
														<input type="text" required name="live_secret" class="form-control" id="live_secret"  @if(!empty($settings['live_secret'])) value="{{ $settings['live_secret']}}" @endif>
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
								<div role="tabpanel" id="mail" class="tab-pane">
									<div class="panel-body">
                                    <form  method="POST" action="{{route('save-settings')}}" id="paypalSetting">
										@csrf
											<div class="row">
											<div class="col-lg-10">

												<div class="form-group row" >    
												<div class="col-md-12">
														<label class="col-form-label">Sandbox Key</label>
														<div class="input-icon right" data-name="AcUUxgGk">
																<select name="paypal_mode" class="form-control">
																	<option  @if(!empty($settings['paypal_mode']) AND $settings['paypal_mode'] == "sandbox") selected @endif value="sandbox">Sandbox</option>
																	<option  @if(!empty($settings['paypal_mode']) AND $settings['paypal_mode'] == "live" ) selected @endif value="live">Live</option>
																</select>
														</div>
													</div>
													</div>
													<div class="form-group row" > 
													<div class="col-md-6">
														<label class="col-form-label">Sandbox Key</label>
														<div class="input-icon right" data-name="AcUUxgGk">
														<input type="text" required name="paypal_sandbox_key" class="form-control" id="paypal_sandbox_key" @if(!empty($settings['paypal_sandbox_key'])) value="{{ $settings['paypal_sandbox_key']}}" @endif>
														</div>
													</div>
													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Sandbox Secret</label>
														<div class="input-icon right" data-name="lAbpofdC">
														<input type="text" required name="paypal_sandbox_secret" class="form-control" id="paypal_sandbox_secret" @if(!empty($settings['paypal_sandbox_secret'])) value="{{ $settings['paypal_sandbox_secret']}}" @endif>
														</div>
													</div>
												</div>

												<div class="form-group row" >         
													<div class="col-md-6">
														<label class="col-form-label">Live Key</label>
														<div class="input-icon right" data-name="AcUUxgGk">
														<input type="text" required name="paypal_live_key" class="form-control" id="paypal_live_key" @if(!empty($settings['paypal_live_key'])) value="{{ $settings['paypal_live_key']}}" @endif>
														</div>
													</div>
													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Live Secret</label>
														<div class="input-icon right" data-name="lAbpofdC">
														<input type="text" required name="paypal_live_secret" class="form-control" id="paypal_live_secret"  @if(!empty($settings['paypal_live_secret'])) value="{{ $settings['live_secret']}}" @endif>
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
        $('#stripeSetting , #paypalSetting , #bankSetting ').submit(function(e) {
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