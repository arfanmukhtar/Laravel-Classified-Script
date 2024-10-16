@extends('backend.layouts.app')

@section('content')
@include("backend.category/cropper")
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>@lang('common.edit') @lang('common.category')</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{url('')}}">@lang('common.home')</a>
                        </li>
                        <li>
                             <a href="{{url('admin/categories')}}">@lang('common.categories')</a>
                        </li>
                        <li class="active">
                            <strong>@lang('common.edit') @lang('common.category')</strong>
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
                            <h5>@lang('common.edit') @lang('common.category')</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                
                                
                            </div>
                        </div>
						<div class="ibox-content">
						<form action="{{ url('admin/categories/'  . $category->id) }}" class="form-horizontal" method="POST" enctype='multipart/form-data'>
                                <input type="hidden" name="_method" value="put">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">@lang('Parent Category')</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="parent_id" name="parent_id">
                                        <option value="">No Parent</option>
                                            @foreach($parent_categories as $cat)
                                            <option @if($category->id == $cat->id) selected @endif value="{{$cat->id}}">{{$cat->name}}</option>
                                            @if($cat->hasChildren()) 
                                                @foreach($cat->children as $child)
                                                    <option @if($category->id == $child->id) selected @endif value="{{$child->id}}">  &nbsp&nbsp&nbsp- {{$child->name}}</option>
                                                @endforeach
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

								 <div class="form-group">
                                    <label class="col-sm-2 control-label">@lang('common.name')</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" id="cat_image" name="cat_image" >
                                    </div>
                                </div>
                                
						<div class="hr-line-dashed"></div>
								 <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        
										 <a class="btn btn-white" href="{{ url('categories') }}">@lang('common.cancel')</a>
                                        <button class="btn btn-primary" type="submit"> @lang('common.save')</button>
                                    </div>
                                </div>
								
								
                            </form>
                        </div>
                    </div>
                </div>
				<!-- <div class="col-lg-4">
                    <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="cropped_value" id="cropped_value" value="">
                <input type="hidden" name="image_edit" id="image_edit" value="{{$category->id}}">
                    
                <label title="Upload image file" for="inputImage" class="">
                
                     <div class="upload-pic " style="">
                        <img id="image_source"  src="<?php echo url("storage/categories/thumb/" . $category->id . ".jpg?rand=".rand(0, 100)); ?>">
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
                </div> -->
                
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
    height: 125px;
    width: 125px;
    background: #ccc;
    margin: 10px 0;
}
.modal-dialog.modal-lg {
    max-width: 640px;
}
.upload-pic-new label {
    margin: 0;
}
.upload_button { 
    margin-top:10px;
}
</style>			
    
@endsection
