@extends('backend.layouts.app')

@section('content')

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
							
							<div class="tab-content">
								<div role="tabpanel" id="verification" class="tab-pane active">
									<div class="panel-body">
										<form  method="POST" action="{{route('save-footer')}}" id="VerificationCodes">
										@csrf
										
											<div class="row">
											<div class="col-lg-10">
													<div class="form-group row" > 
														<div class="col-md-6">
															<label class="col-form-label">Tab 1</label>
															<div class="input-icon right" >
															<textarea type="text" rows="5"  name="content[section1]" class="form-control" id="" >@if(!empty($sections["section1"])){{$sections["section1"]}}@endif</textarea>
															</div>
														</div>
														<div class="col-md-6">
															<label class="col-form-label">Tab 2</label>
															<div class="input-icon right" >
															<textarea type="text" rows="5"  name="content[section2]" class="form-control" id="" >@if(!empty($sections["section1"])){{$sections["section2"]}}@endif</textarea>
															</div>
														</div>
													</div>

													<div class="form-group row" > 
														<div class="col-md-6">
															<label class="col-form-label">Tab 3</label>
															<div class="input-icon right" >
															<textarea type="text" rows="5"  name="content[section3]" class="form-control" id="" >@if(!empty($sections["section1"])){{$sections["section3"]}}@endif</textarea>
															</div>
														</div>
														<div class="col-md-6">
															<label class="col-form-label">Tab 4</label>
															<div class="input-icon right" >
															<textarea type="text" rows="5"  name="content[section4]" class="form-control" id="" >@if(!empty($sections["section1"])){{$sections["section4"]}}@endif</textarea>
															</div>
														</div>
													</div>

													<div class="form-group row" > 
														<div class="col-md-6">
															<label class="col-form-label">Tab 5</label>
															<div class="input-icon right" >
															<textarea type="text" rows="5"  name="content[section5]" class="form-control" id="" >@if(!empty($sections["section1"])){{$sections["section5"]}}@endif</textarea>
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
        $('#VerificationCodes  ').submit(function(e) {
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