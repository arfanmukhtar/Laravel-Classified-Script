@extends('backend.layouts.app')

@section('content')


<!-- Image cropper -->
    <script src="{{url('assets/backend/js/plugins/summernote/summernote-bs4.js')}}"></script>

	<link href="{{url('assets/backend/css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">

	
    <script>
        $(document).ready(function(){

            $('.summernote').summernote();

       });
        var edit = function() {
            $('.click2edit').summernote({focus: true});
        };
        var save = function() {
            var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).
            $('.click2edit').destroy();
        };
    </script>
	

			<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Add Page</h2>
                    <ol class="breadcrumb">
                        <li  class="breadcrumb-item">
                             <a href="{{url('/')}}">@lang('common.home')</a>
                        </li>
                        <li  class="breadcrumb-item">
                             <a href="{{url('pages')}}">Pages</a>
                        </li>
                        <li  class="breadcrumb-item active">
                            <strong><?php echo $title; ?></strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
                <div class="col-lg-12">
                
                <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Add Product</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                
                                
                            </div>
                        </div>
                        <div class="ibox-content">
                        <form action="{{ url('admin/pages/save') }}" class="form-horizontal" method="POST" enctype='multipart/form-data'>
                        {{ csrf_field() }}
                                <div class="form-group"><label class="col-sm-2 control-label">Title</label>
                                    <div class="col-sm-10">
                                        <input placeholder="Title" type="text" required name="title" value="{{$page->title}}" class="form-control">
                                        <input type="hidden" value="<?php echo $page->id; ?>" name="id" >
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                <div class="form-group"><label class="col-sm-2 control-label">URL/Slug</label>
                                    <div class="col-sm-10">
                                        <input placeholder="Slug" type="text" required name="slug" value="{{$page->slug}}" class="form-control">
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                
                               <div class="form-group"><label class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-10"><textarea name="body" class="form-control summernote" placeholder="description here" rows="10"><?php echo $page->body; ?></textarea></div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>
                                
                               <div class="form-group"><label class="col-sm-2 control-label">Image</label>
                                    <div class="col-sm-10"><input type="file" name="file" accept=".png, .jpg, .jpeg"  ></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
                                
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        
                                         <a class="btn btn-white" href="{{ url('pages') }}">Cancel</a>
                                        <button class="btn btn-primary" type="submit">Save changes</button>
                                    </div>
                                </div>
                                
                                
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>

@endsection

