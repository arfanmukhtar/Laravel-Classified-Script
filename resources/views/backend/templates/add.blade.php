@extends('backend.layouts.app')

@section('content')
<link href="{{url('assets/backend/css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
<script src="{{url('assets/backend/js/plugins/summernote/summernote-bs4.js')}}"></script>


<script>
        $(document).ready(function(){

            $('.summernote').summernote({height: 150});

       });
    </script>

<div class="row wrapper border-bottom white-bg page-heading">

                <div class="col-lg-10">
                <h2></h2>
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                            <a href="{{url('')}}">@lang('common.home')</a>
                        </li>
                        <li class="breadcrumb-item">
                             <a href="{{url('admin/tempaltes')}}">@lang('Templates')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>@lang('common.add_new')</strong>
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
                            <h5>Add Template</h5>
                           
                        </div>
						<div class="ibox-content">
                        <form action="{{route('save-template')}}" method="POST" id="client-template" class="form-horizontal">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                            
                            @if(!empty($template_row['id']))
                            <input type="hidden" id="id" name="id" value="{{$template_row['id']}}" />
                            @else 
                            <input type="hidden" id="id" name="id" value="add" />
                            @endif

                            <div class="form-group row">
                        <label class="col-form-label col-md-3">{{trans('Label Name')}}
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <input type="text" name="template_name" id="template_name" class="form-control" value="{{ @$template_row['template_name'] }}" />
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-3">{{trans('Module Name')}}
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <select class="form-control m-select2" data-placeholder="Select Modules" id="modules" name="modules">
                                    <option value="">Select Modules</option>
                                    @foreach($template_modules as $module)
                                    <option @if(!empty($template_row) and $template_row['module_id'] == $module->id) selected @endif value="{{$module->id}}">{{$module->module_name}}</option>
                                    @endforeach
                                                                   
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-3">{{trans('Subject')}}
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <input type="text" name="subject" id="subject" class="form-control" value="{{ @$template_row['subject_title'] }}" />
                            </div>
                        </div>
                       
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-md-3">{{trans('Body')}}
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <textarea name="content_html" id="content_html" class="summernote">{{ @$template_row['email_template'] }}</textarea>
                               

                            </div>
                        </div>
                        
                    </div>


                    <div class="form-group row">
                        <label class="col-form-label col-md-3">{{ trans('Templates Variables') }}
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                               
                                
                                <div class="btn-group dropup templatetags"> 
                                    <a href="javascript:void(0)" data-toggle="dropdown" class="btn btn-success  btn-xs dropdown-toggle" aria-expanded="false">
                                        {{ trans('Client Variables') }}<span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu kt-scroll" data-scroll="true" data-height="250" data-mobile-height="250" id="template_variables2">
                                        <li><a href="javascript:;" onclick="selectTag('name','content_html')"> Name </a></li>
                                        <li><a href="javascript:;" onclick="selectTag('email','content_html')"> Email </a></li>
                                        <li><a href="javascript:;" onclick="selectTag('country','content_html')"> Country </a></li>
                                        <li><a href="javascript:;" onclick="selectTag('address','content_html')"> Address  </a></li>
                                        <li><a href="javascript:;" onclick="selectTag('city','content_html')"> City </a></li>
                                        <li><a href="javascript:;" onclick="selectTag('phone','content_html')"> Phone </a></li>
                                        <li><a href="javascript:;" onclick="selectTag('mobile','content_html')"> Mobile </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr/>

                    <div class="form-group row">
                        <label class="col-form-label col-md-3">{{trans('Notification')}}
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <input type="text" name="notification_text" id="notification_text" class="form-control" value="{{ @$template_row['notification_text'] }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-form-label col-md-3">{{ trans('Notification Labels') }}
                        </label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <div class="btn-group dropup templatetags"> 
                                    <a href="javascript:void(0)" data-toggle="dropdown" class="btn btn-success  btn-xs dropdown-toggle" aria-expanded="false">
                                        {{ trans('Notification Variables') }}<span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu kt-scroll" data-scroll="true" data-height="250" data-mobile-height="250" id="template_variables3">
                                        <li><a href="javascript:;" onclick="selectTag2('name','notification_text')"> Name </a></li>
                                        <li><a href="javascript:;" onclick="selectTag2('email','notification_text')"> Email </a></li>
                                        <li><a href="javascript:;" onclick="selectTag2('country','notification_text')"> Country </a></li>
                                        <li><a href="javascript:;" onclick="selectTag2('address_line_1','notification_text')"> Address line 1 </a></li>
                                        <li><a href="javascript:;" onclick="selectTag2('address_line_2','notification_text')"> Address line 2 </a></li>
                                        <li><a href="javascript:;" onclick="selectTag2('city','notification_text')"> City </a></li>
                                        <li><a href="javascript:;" onclick="selectTag2('state','notification_text')"> State </a></li>
                                        <li><a href="javascript:;" onclick="selectTag2('post_code','notification_text')"> Post code </a></li>
                                        <li><a href="javascript:;" onclick="selectTag2('phone','notification_text')"> Phone </a></li>
                                        <li><a href="javascript:;" onclick="selectTag2('mobile','notification_text')"> Mobile </a></li>
                                      
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
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

			



<script type="text/javascript">
    function selectTag(field, ckeditor_id) {
        if(field == 'Unsubscribe Link')
            field = '<a href="%%unsubscribelink%%">{{trans('common.label.unsubscribe')}}</a>';
        else if(field == 'Confirm Link')
            field = '<a href="%%confirmurl%%">{{trans('common.label.confirm')}}</a>';
        else
            field = '%%'+field+'%%';

            var oldvalue = $("#"+ckeditor_id).val();
           
        // $("#"+ckeditor_id).val(oldvalue+" "+field);
        $("#"+ckeditor_id).summernote('pasteHTML', field);
    }
    function selectTag2(field, field_id) {
        field = '%%'+field+'%%';
        var oldvalue = $("#"+field_id).val();
        $("#"+field_id).val(oldvalue+" "+field);
    }

  

</script>


@endsection
