@extends('backend.layouts.app')

@section('content')



<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                   
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{url('')}}">@lang('common.home')</a>
                        </li>
                        <li>
                             <a href="{{url('admin/types')}}">@lang('Types')</a>
                        </li>
                        <li class="active">
                            <strong>@lang('common.add_new')</strong>
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
                            <h5>Add Type</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                
                                
                            </div>
                        </div>
						<div class="ibox-content">
                              

						<form action="{{ url('admin/types/'  . $category->id) }}" class="form-horizontal" method="POST" enctype='multipart/form-data'>
                        <input type="hidden" name="_method" value="put">
                                {{csrf_field()}}
								 <div class="form-group"><label class="col-sm-2 control-label">@lang('common.name')</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" ></div>
                                </div>
						<div class="hr-line-dashed"></div>
								 <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        
										 <a class="btn btn-white" href="{{ url('categories') }}">@lang('common.cancel')</a>
                                        <button class="btn btn-primary" type="submit">@lang('common.save')</button>
                                    </div>
                                </div>
								
								
                            </form>
                        </div>
                    </div>
                </div>
                


            </div>
			</div>	

    
@endsection
