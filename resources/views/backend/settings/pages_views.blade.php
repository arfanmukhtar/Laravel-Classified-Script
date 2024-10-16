@extends('backend.layouts.app')

@section('content')

<?php 
    $settings = getApplicationSettings();
?><script src="/assets/js/bootstrap-multiselect.js"></script>
<script src="/assets/js/components-bootstrap-multiselect.min.js"></script>
<script src="/assets/js/select2.min.js"></script>
<script> 
    $(document).ready(function() {
		$("#op_country").multiselect();
	});
</script>
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
								<li><a class="nav-link active" data-toggle="tab" href="#verification">Homepage</a></li>
								<li><a class="nav-link " data-toggle="tab" href="#search">Search Page</a></li>
								<li><a class="nav-link " data-toggle="tab" href="#postanAd">Post an Ad</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" id="verification" class="tab-pane active">
									<div class="panel-body">
										<form  method="POST" action="{{route('save-settings')}}" id="homeSetting">
										@csrf
											<div class="row">
											<div class="col-lg-10">
													<div class="form-group row" > 
														<div class="col-md-6">
															<label class="col-form-label">Show Categories</label>
															<div class="input-icon right" data-name="AcUUxgGk">
																<select class="form-control" name="show_home_categories" id="type">
																		<option @if(!empty($settings['show_home_categories']) and $settings['show_home_categories'] == "Yes") selected @endif value="Yes">Yes</option>
																		<option @if(!empty($settings['show_home_categories']) and $settings['show_home_categories'] == "No") selected @endif value="No">No</option>
																</select>
															</div>
														</div>

													<div class="col-md-6">
														<label class="col-form-label">Category View</label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<select class="form-control" name="categories_view" id="type">
																	<option @if(!empty($settings['categories_view']) and $settings['categories_view'] == "Slide") selected @endif value="Slide">Slide</option>
																	<option @if(!empty($settings['categories_view']) and $settings['categories_view'] == "Simple") selected @endif value="Simple">Simple</option>
															</select>
														</div>
													</div>


													<div class="col-md-6">
														<label class="col-form-label">Show Filters</label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<select class="form-control" name="show_filters" id="type">
																	<option @if(!empty($settings['show_filters']) and $settings['show_filters'] == "Yes") selected @endif value="Yes">Yes</option>
																	<option @if(!empty($settings['show_filters']) and $settings['show_filters'] == "No") selected @endif value="No">No</option>
															</select>
														</div>
													</div>

													<?php 
													$filters_list = array();
														if(!empty($settings['filters_list']))
															$filters_list = json_decode($settings['filters_list'] , true);
														
													?>

													<div class="col-md-6">
														<label class="col-form-label">Filters List</label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<select class="mt-multiselect btn btn-default" multiple="multiple" name="filters_list[]"  data-label="left"  id="op_country" data-width="100%" data-filter="true" data-action-onchange="true" data-select-all="true" data-placeholder="Filter by admin">
																	<option @if(!empty($settings['filters_list']) and in_array("categories" , $filters_list) ) selected @endif value="categories">Top Categories</option>
																	<option @if(!empty($settings['filters_list']) and in_array("locations" , $filters_list)) selected @endif value="locations">Top Locations</option>
																	<option @if(!empty($settings['filters_list']) and in_array("budget" , $filters_list) ) selected @endif value="budget">Budget Filter</option>
															</select>
														</div>
													</div>



													
												</div>

												<div class="form-group row" > 
													
													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Show Featured List</label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<select class="form-control" name="show_home_featured" id="type">
																	<option @if(!empty($settings['show_home_featured']) and $settings['show_home_featured'] == "Yes") selected @endif value="Yes">Yes</option>
																	<option @if(!empty($settings['show_home_featured']) and $settings['show_home_featured'] == "No") selected @endif value="No">No</option>
															</select>
														</div>
													</div>

													<div class="col-md-6">
													<label class="col-form-label">Show Latest Ads </label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<select class="form-control" name="show_lastest_ads" id="type">
																	<option @if(!empty($settings['show_lastest_ads']) and $settings['show_lastest_ads'] == "Yes") selected @endif value="Yes">Yes</option>
																	<option @if(!empty($settings['show_lastest_ads']) and  $settings['show_lastest_ads'] == "No") selected @endif value="No">No</option>
															</select>
														</div>
													</div>
													<div class="col-md-6" data-name="UkCYUnJK">
														<label class="col-form-label">Latest Ads Count</label>
														<div class="input-icon right" data-name="lAbpofdC">
															<input type="text" required name="last_ads_count" class="form-control" id="last_ads_count"  @if(!empty($settings['last_ads_count'])) value="{{ $settings['last_ads_count']}}" @endif>
														</div>
													</div>

													<div class="col-md-6">
														<label class="col-form-label">Home Videos</label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<select class="form-control" name="show_home_videos" id="type">
																	<option @if(!empty($settings['show_home_videos']) and $settings['show_home_videos'] == "Yes") selected @endif value="Yes">Yes</option>
																	<option @if(!empty($settings['show_home_videos']) and $settings['show_home_videos'] == "No") selected @endif value="No">No</option>
															</select>
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

								<div role="tabpanel" id="search" class="tab-pane">
									<div class="panel-body">
                                    <form  method="POST" action="{{route('save-settings')}}" id="searchPage">
										@csrf
											<div class="row">
											<div class="col-lg-10">
												<div class="form-group row" > 
													<div class="col-md-6">
														<label class="col-form-label">Search Ads Count </label>
														<div class="input-icon right" data-name="AcUUxgGk">
														<input type="text" required name="search_ads_count" class="form-control" id="search_ads_count"  @if(!empty($settings['search_ads_count'])) value="{{ $settings['search_ads_count']}}" @endif>
														</div>
													</div>
													<div class="col-md-6" data-name="UkCYUnJK">
                                                        <label class="col-form-label">Load More Count</label>
														<div class="input-icon right" data-name="AcUUxgGk">
														<input type="text" required name="load_more_count" class="form-control" id="load_more_count"  @if(!empty($settings['load_more_count'])) value="{{ $settings['load_more_count']}}" @endif>
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

								<div role="tabpanel" id="postanAd" class="tab-pane">
									<div class="panel-body">
                                    <form  method="POST" action="{{route('save-settings')}}" id="postAnAd">
										@csrf
											<div class="row">
											<div class="col-lg-10">
												<div class="form-group row" > 
													<div class="col-md-6">
														<label class="col-form-label"> Photos Limit</label>
														<div class="input-icon right" data-name="AcUUxgGk">
														<input type="text" required name="post_photo_limit" class="form-control"  @if(!empty($settings['post_photo_limit'])) value="{{ $settings['post_photo_limit']}}" @endif>
														</div>
													</div>
													<div class="col-md-6">
														<label class="col-form-label">Show Editor</label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<select class="form-control" name="show_editor" id="type">
																	<option @if(!empty($settings['show_editor']) and $settings['show_editor'] == "No") selected @endif value="No">No</option>
																	<option @if(!empty($settings['show_editor']) and $settings['show_editor'] == "Yes") selected @endif value="Yes">Yes</option>
																	
															</select>
														</div>
													</div>

													<div class="col-md-6">
														<label class="col-form-label"> Posting Status</label>
														<div class="input-icon right" data-name="AcUUxgGk">
															<select class="form-control" name="new_post_status" id="type">
																	<option @if(!empty($settings['new_post_status']) and $settings['new_post_status'] == 0) selected @endif value="0">Approve First</option>
																	<option @if(!empty($settings['new_post_status']) and $settings['new_post_status'] == 1) selected @endif value="1">Active</option>
																	
															</select>
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


                              

							</div>
					   </div>
					</div>
            </div>
        </div>
            


    <script> 
        $(document).ready(function() {
        $('#homeSetting , #searchPage , #postAnAd').submit(function(e) {
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