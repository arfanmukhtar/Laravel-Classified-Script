@extends('backend.layouts.app')

@section('content')
@include("backend.products/cropper")
 <!-- Image cropper -->
    <script src="{{url('assets/js/plugins/cropper/cropper.js')}}"></script>

	<link href="{{url('assets/css/plugins/cropper/cropper.css')}}" rel="stylesheet">

			<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>@lang('common.edit') @lang('common.product')</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{url('')}}">>@lang('common.home')<</a>
                        </li>
                        <li>
                             <a href="{{url('products')}}">@lang('common.products')</a>
                        </li>
                        <li class="active">
                            <strong>@lang('common.edit')</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
			<div class="row">
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Edit Product</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                
                                
                            </div>
                        </div>
                        <div class="ibox-content">
						 <form action="{{ url('products/' . $product->id) }}" class="form-horizontal" method="POST" enctype='multipart/form-data'>
                        <input type="hidden" name="_method" value="put">
                        {{ csrf_field() }}
						
                                <div class="form-group"><label class="col-sm-2 control-label">@lang('common.name')</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
								
                               <div class="form-group"><label class="col-sm-2 control-label">@lang('common.description')</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" id="desc" name="description" value="{{ old('description', $product->description) }}"></div>
                                </div>
								
								 <div class="form-group"><label class="col-sm-2 control-label">Category</label>
                                    <div class="col-sm-10">
										<select class="form-control" id="category_id" name="category_id"> 
											@foreach($categories as $cat)
											<option <?php if($product->category_id == $cat->id) echo "selected"; ?> value="{{$cat->id}}">  {{$cat->name}} </option>
											@endforeach
										</select>
									</div>	
                                </div>
								
								
								<?php 
									$prices = json_decode($product->prices); 
									$titles = json_decode($product->titles); 
								?>
								
						@foreach($titles as $key=>$t)				
						<div class="form-group" id="price_div">
                            <label for="input-Default" class="col-sm-2 control-label">Price {{$key+1}}</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control price_title"  id="" name="title[]" value="{{$t}}" placeholder="Title">
                            </div> 
                            <div class="col-sm-2">
                                <input type="text" class="form-control price_amt" id="" name="price[]" value="{{$prices[$key]}}" placeholder="Price">
                            </div>
                            @if($key == 0)
                            <div class="col-sm-2">
                                <input type="button" name="add_row" id="add_row" class="uibutton" value="More" />
                            </div>
							@endif
							 @if($key > 0)
							<a href="javascript:void(0)" id="{{$key+1}}" class="remove_field" >Remove</a>  
						@endif
						</div>
						

                       
						<input type="hidden" name="price_counter" value="{{$key+1}}" id="counter">
                        
						@endforeach
						
						<div id="new_row"> </div>
						
			
					<div class="hr-line-dashed"></div>
	
                                
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        
										 <a class="btn btn-white" href="{{ url('products') }}">@lang('common.cancel')</a>
                                        <button class="btn btn-primary" type="submit">@lang('common.save')</button>
                                    </div>
                                </div>
								
								
                            </form>
							
							
			
                        </div>
                    </div>
                </div>
				
				<div class="col-lg-4">
                    <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="cropped_value" id="cropped_value" value="">
                <input type="hidden" name="image_edit" id="image_edit" value="{{$product->id}}">
                    
                <label title="Upload image file" for="inputImage" class="">
                
                     <div class="upload-pic img-circle" style="">
                        <img id="image_source"  src="<?php echo url("uploads/products/thumb/" . $product->id . ".jpg?rand=".rand(0,100)); ?>">
                    </div>
                   <div class="upload-pic-new btn btn-primary text-center">
                        <input type="file"  name="file" id="cropper" style="display:none" />
                        <label for="cropper">
                        <div class="pic-placeholder">
                          
                            <span class="upload_button"> <i class="fa fa-picture-o"></i>
                            Upload Photo </span>
                        </div>
                        </label>
                    </div>               
                                    
            </form>
                </div>
				
            </div>
			</div>
			
			<style> 
.cropper-container.cropper-bg {
  background: #fff !important;
  background-image:none !important;
}

.cropper-modal {
    opacity: .5;
    background-color: #fff;
}

.upload-pic { 
	height:200px;
	width:200px; 
	background:#ccc;
	margin:10px;
}

.upload_button { 
	margin-top:10px;
}
</style>
			
			<script>
			
			$(document).ready(function() {
        // Confirm Delete.
        $("body").on('click', ".remove_field", function() {
			$(this).parent('div').remove();
        });

        $("body").on("click" , "#add_row", function() {
            var counter = $("#counter").val();
            counter = parseInt(counter) + 1;
            var new_field = ' <div class="form-group"> <label for="input-Default" class="col-sm-2 control-label">Price ' + counter + '</label>';
            new_field += ' <div class="col-sm-3"><input type="text" class="form-control price_title" id="" name="title[]" placeholder="Title"></div>';
            new_field += ' <div class="col-sm-2"> <input type="text" class="form-control price_amt" id="" name="price[]" placeholder="Price"> </div>';
            
            new_field += ' <a href="javascript:void(0)" id="' + counter + '" class="remove_field">Remove</a>  </div>';
            $("#new_row").append(new_field);
            $("#counter").val(counter);  
        });
        
        //$('#related_items').multiSelect();
    });

			</script>

@endsection