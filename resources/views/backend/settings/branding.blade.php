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
                            <strong>Branding</strong>
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
								<li><a class="nav-link {{$homepage}}" data-toggle="tab" href="#homepage">Homepage</a></li>
							</ul>
							<div class="tab-content">
								<div role="tabpanel" id="general" class="tab-pane {{$general}}">
									<div class="panel-body">
										
                                    <form  method="POST" action="{{route('save-branding')}}" enctype='multipart/form-data'>
										@csrf
											<div class="row">
											<div class="col-lg-10">

												<div class="form-group row" data-name="TmEutCJy">         
													<div class="col-md-6" >
														<label class="col-form-label">Application Logo</label>
														<div class="input-icon right" data-name="AcUUxgGk">
                                                        <?php 
                                                            $login_background = url("public/img/bg.png");
                                                            if(!empty(getSetting("app_logo"))) { 
                                                                $login_background = url("storage/branding/" . getSetting("app_logo"));
                                                            }
                                                            ?>
                                                        <img src="<?php echo $login_background; ?>" alt=""  height="100px">

														    <input type="file"  name="app_logo" class="form-control" id="title">
														</div>
													</div>
													<div class="col-md-6" >
														<label class="col-form-label">Admin Logo</label>
														<div class="input-icon right" data-name="lAbpofdC">
                                                            <?php 
                                                                $login_background = url("public/img/bg.png");
                                                                if(!empty(getSetting("admin_logo"))) { 
                                                                    $login_background = url("/storage/branding/" . getSetting("admin_logo"));
                                                                }
                                                            ?>
                                                            <img src="<?php echo $login_background; ?>" alt=""  height="100px"> 
														    <input type="file"  name="admin_logo" class="form-control" id="admin_logo" >
														</div>
													</div>
                                                    
												</div>

                                                
                                                <div class="form-group row" data-name="TmEutCJy">         
													<div class="col-md-6" >
														<label class="col-form-label">Favicon</label>
														<div class="input-icon right" data-name="AcUUxgGk">
                                                        <?php 
                                                            $login_background = url("public/img/bg.png");
                                                            if(!empty(getSetting("favicon"))) { 
                                                                $login_background = url("storage/branding/" . getSetting("favicon"));
                                                            }
                                                            ?>
                                                        <img src="<?php echo $login_background; ?>" alt=""  height="100px">

														    <input type="file"  name="favicon" class="form-control" id="favicon">
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
								<div role="tabpanel" id="homepage" class="tab-pane {{$homepage}}">
									<div class="panel-body">
                                    <form  method="POST" action="{{route('save-branding')}}" enctype='multipart/form-data' id="homePageSetting">
										@csrf
											<div class="row">
											<div class="col-lg-10">
												<input type="hidden" name="page" value="homepage">
												
												<div class="form-group row" data-name="TmEutCJy">         
													<div class="col-md-6" >
														<label class="col-form-label">Search Image</label>
														<div class="input-icon right" data-name="AcUUxgGk">
                                                        <?php 
                                                            $login_background = url("public/img/bg.png");
                                                            if(!empty(getSetting("home_search"))) { 
                                                                $login_background = url("storage/branding/" . getSetting("home_search"));
                                                            }
                                                            ?>
                                                        <img src="<?php echo $login_background; ?>" alt=""  height="100px">

														    <input type="file"  name="home_search" class="form-control" id="home_search">
														</div>
													</div>
													<div class="col-md-6" >
														<label class="col-form-label">Above Footer</label>
														<div class="input-icon right" data-name="lAbpofdC">
                                                            <?php 
                                                                $login_background = url("public/img/bg.png");
                                                                if(!empty(getSetting("home_footer_image"))) { 
                                                                    $login_background = url("/storage/branding/" . getSetting("home_footer_image"));
                                                                }
                                                            ?>
                                                            <img src="<?php echo $login_background; ?>" alt=""  height="100px"> 
														    <input type="file"  name="home_footer_image" class="form-control" id="home_footer_image" >
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
            

@endsection