@extends('backend.layouts.app')

@section('content')

<?php 
    $settings = getApplicationSettings();
	$general = "";
	$homepage = "";
	$search = "";
	$detail = "";
	if(request()->input("p") == "") $general = "active";
	if(request()->input("p") == "homepage") $homepage = "active";
	if(request()->input("p") == "search") $search = "active";
	if(request()->input("p") == "detail") $detail = "active";
?>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
					<h2> </h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{url('')}}">@lang('common.home')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Advertisements</strong>
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
								<li><a class="nav-link {{$general}}" data-toggle="tab" href="#general">General</a></li>
								<li><a class="nav-link {{$homepage}}" data-toggle="tab" href="#homePage">Homepage</a></li>
								<li><a class="nav-link {{$search}}" data-toggle="tab" href="#searchPage">Search Page</a></li>
								<li><a class="nav-link {{$detail}}" data-toggle="tab" href="#detailPage">Detail Page</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" id="general" class="tab-pane active">
									<div class="panel-body">
										<form  method="POST" action="{{route('save-settings')}}" id="AdsSetting" enctype="multipart/form-data">
										@csrf
											<div class="row">
											<div class="col-lg-10">
													<div class="form-group row" >
													<div class="col-md-6">
														<label class="col-form-label">Display Ads</label>
														<div class="input-icon right" >
														<textarea type="text" rows="5"  name="adsense_display_ads" class="form-control"  >@if(!empty($settings['adsense_display_ads'])) {{ $settings['adsense_display_ads']}} @endif</textarea>
														</div>
													</div>

													<div class="col-md-6">
														<label class="col-form-label">In-Feed Ads</label>
														<div class="input-icon right" >
														<textarea type="text" rows="5"  name="adsense_in_feed_ads" class="form-control"  >@if(!empty($settings['adsense_in_feed_ads'])) {{ $settings['adsense_in_feed_ads']}} @endif</textarea>
														</div>
													</div>
													
												</div>

												<div class="form-group row" >         
													<div class="col-md-6">
														<label class="col-form-label">Other Ads 1 <br> 
															<small>These code will be added in footer</small>
														</label>
														<div class="input-icon right" data-name="AcUUxgGk">
														<textarea type="text" rows="5"  name="other_ads_1" class="form-control"  >@if(!empty($settings['other_ads_1'])) {{ $settings['other_ads_1']}} @endif</textarea>
														</div>
													</div>
													<div class="col-md-6" >
														<label class="col-form-label">Other Ads 2 <br> 
															<small>These code will be added in footer</small></label>
														<div class="input-icon right" data-name="lAbpofdC">
														<textarea type="text" rows="5"  name="other_ads_2" class="form-control"  >@if(!empty($settings['other_ads_2'])) {{ $settings['other_ads_2']}} @endif</textarea>
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
								<div role="tabpanel" id="homePage" class="tab-pane">
									<div class="panel-body">
                                    <form  method="POST" action="{{route('save-settings')}}" id="HomeAds" enctype="multipart/form-data">
										@csrf
											<div class="row">
											<div class="col-lg-10">
												<div class="form-group row" > 
												<div class="col-md-6" >
														<label class="col-form-label">Home Ad 1</label>
														<div class="input-icon right" data-name="AcUUxgGk">
														<?php 
                                                            $login_background = url("public/img/bg.png");
                                                            if(!empty(getSetting("home_ad_image1"))) { 
                                                                $login_background = url("storage/images/advertisements/" . getSetting("home_ad_image1"));
                                                            }
                                                            ?>
                                                        <img src="<?php echo $login_background; ?>" alt=""  width="100%"  height="100px">
														<br>
														<br>
														<?php 
															$home_ad_1_url = getSetting("home_ad_1_url");
															$home_ad_2_url = getSetting("home_ad_2_url");
														?>
														<input type="text" placeholder="Ad 1 Link" value="{{$home_ad_1_url}}"  name="home_ad_1_url" class="form-control">
															<br>
														    <input type="file"  name="home_ad_image1" class="form-control" id="title">
															
														</div>
													</div>

													
													
													<div class="col-md-6" >
														<label class="col-form-label">Home Ad 2 </label>
														<div class="input-icon right" data-name="AcUUxgGk">
                                                        <?php 
                                                            $login_background = url("public/img/bg.png");
                                                            if(!empty(getSetting("home_ad_image2"))) { 
                                                                $login_background = url("storage/images/advertisements/" . getSetting("home_ad_image2"));
                                                            }
                                                            ?>
                                                        <img src="<?php echo $login_background; ?>" alt=""  width="100%"  height="100px">
														<br>
														<br>
														
															<input type="text" placeholder="Ad 2 Link" value="{{$home_ad_2_url}}"  name="home_ad_2_url" class="form-control">
															<br>
														    <input type="file"  name="home_ad_image2" class="form-control" id="title">
															
														    
														</div>
													</div>

													<div class="col-md-6" >
                                                        <label class="col-form-label"> Home Ad 1  </label>
														<div class="input-icon right" data-name="lAbpofdC">
														<textarea type="text" rows="5"  name="home_ads_1" class="form-control"  >@if(!empty($settings['home_ads_1'])) {{ $settings['home_ads_1']}} @endif</textarea>
														</div>
													</div>


													
													<div class="col-md-6" >
                                                        <label class="col-form-label"> Home Ad 2</label>
														<div class="input-icon right" data-name="lAbpofdC">
														

														<textarea type="text" rows="5"  name="home_ads_2" class="form-control"  >@if(!empty($settings['home_ads_2'])) {{ $settings['home_ads_2']}} @endif</textarea>
														</div>
													</div>
													<div class="col-md-12" >
													<small>Code Ads will be prefered first</small>
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


                                <div role="tabpanel" id="searchPage" class="tab-pane">
									<div class="panel-body">
                                    <form  method="POST" action="{{route('save-settings')}}" id="SearchAds">
										@csrf
											<div class="row">
											<div class="col-lg-10">
												<div class="form-group row" > 
												<div class="col-md-8" >
													<label class="col-form-label">On Top <br><small>(768 x 90) OR (786 x 200)</small></label>
														<div class="input-icon right" data-name="AcUUxgGk">
                                                        <?php 
                                                            $search_top_ad_link = getSetting("search_top_ad_link");
                                                            $login_background = url("public/img/bg.png");
                                                            if(!empty(getSetting("search_top_ad"))) { 
                                                                $login_background = url("storage/images/advertisements/" . getSetting("search_top_ad"));
                                                            }
                                                            ?>
                                                        <img src="<?php echo $login_background; ?>" alt=""  height="100px">
															<br><br>
															<input type="text" placeholder="Ad Link" value="{{$search_top_ad_link}}"  name="search_top_ad_link" class="form-control">
															<br>
														    <input type="file"  name="search_top_ad" class="form-control" id="title">
														</div>
													</div>

													
													<div class="col-md-8" >
                                                        <label class="col-form-label"> Top Ad 1  <small>(768 x 90) OR (786 x 200) </small></label>
														<div class="input-icon right" data-name="lAbpofdC">
														<textarea type="text" rows="5"  name="search_top_1" class="form-control"  >@if(!empty($settings['search_top_1'])) {{ $settings['search_top_1']}} @endif</textarea>
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



								<div role="tabpanel" id="detailPage" class="tab-pane">
									<div class="panel-body">
                                    <form  method="POST" action="{{route('save-settings')}}" id="detailAds">
										@csrf
											<div class="row">
											<div class="col-lg-10">
												<div class="form-group row" > 
												<div class="col-md-8" >
													<label class="col-form-label">On Top <br><small>(768 x 90) OR (786 x 200)</small></label>
														<div class="input-icon right" data-name="AcUUxgGk">
                                                        <?php 
															$detail_top_1_link = getSetting("detail_top_1_link");
                                                            $login_background = url("public/img/bg.png");
                                                            if(!empty(getSetting("detail_top_ad"))) { 
                                                                $login_background = url("storage/images/advertisements/" . getSetting("detail_top_ad"));
                                                            }
                                                            ?>
                                                        	<img src="<?php echo $login_background; ?>" alt=""  height="100px">
															<br><br>
															<input type="text" placeholder="Ad Link" value="{{$detail_top_1_link}}"  name="detail_top_1_link" class="form-control">
															<br>
														    <input type="file"  name="detail_top_ad" class="form-control" id="title">
														</div>
													</div>


													<div class="col-md-8" >
													<label class="col-form-label">On Top <br><small>(768 x 90) OR (786 x 200)</small></label>
														<div class="input-icon right" data-name="AcUUxgGk">
                                                        <?php 
															$detail_top_2_link = getSetting("detail_top_2_link");
                                                            $login_background = url("public/img/bg.png");
                                                            if(!empty(getSetting("detail_right_ad"))) { 
                                                                $login_background = url("storage/images/advertisements/" . getSetting("detail_right_ad"));
                                                            }
                                                            ?>
                                                        	<img src="<?php echo $login_background; ?>" alt=""  height="100px">
															<br><br>
															<input type="text" placeholder="Ad Link" value="{{$detail_top_2_link}}"  name="detail_top_2_link" class="form-control">
															<br>
														    <input type="file"  name="detail_right_ad" class="form-control" id="detail_right_ad">
														</div>
													</div>


													
													<div class="col-md-8" >
                                                        <label class="col-form-label"> Top Ad 1  <small>(768 x 90) OR (786 x 200) </small></label>
														<div class="input-icon right" data-name="lAbpofdC">
														<textarea type="text" rows="5"  name="detail_top_1" class="form-control"  >@if(!empty($settings['detail_top_1'])) {{ $settings['detail_top_1']}} @endif</textarea>
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
        $('#HomeAds ,  #SearchAds , #detailAds').submit(function(e) {
			e.preventDefault(); // Prevent form submission
			var formData = new FormData(this);
			$.ajax({
				type:'POST',
				url: $(this).attr('action'),
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				success:function(data){
					$("#successMsg").show();
                    setTimeout(function() { 
                        $("#successMsg").hide();
                    } , 1000)
                },
				error: function(data){
					console.log("error");
					console.log(data);
				}
			});
		});

        $('#AdsSetting').submit(function(e) {
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
@endsection