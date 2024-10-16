@extends('backend.layouts.app')

@section('content')


<link href="{{url('assets/backend/css/plugins/chosen/chosen.css')}}" rel="stylesheet">
    <script src="{{url('assets/backend/js/plugins/chosen/chosen.jquery.js')}}"></script>
        <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                <h2></h2>
                    <ol class="breadcrumb">
                        
                    <li class="breadcrumb-item">
                            <a href="{{url('')}}">@lang('common.home')</a>
                        </li>
                        <li class="breadcrumb-item">
                             <a href="{{url('admin/customfields')}}">@lang('Custom Fields')</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>@lang('Edit')</strong>
                        </li>
                    </ol>
                </div>
               
            </div>
			
			<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-10">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>@lang('common.add') @lang('Edit Custom Fields')</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                
                                
                            </div>
                        </div>
						<div class="ibox-content">
						<form action="{{route('custom-fields-store')}}" class="form-horizontal" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$custom_field->id}}">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">@lang('common.name')</label>
                            <div class="col-sm-9"><input type="text" class="form-control" id="name" name="name" value="{{ $custom_field->name }}"></div>
                        </div>
                        <div class="form-group">
                             <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-md-3"> 
                                        <select name="required" class="form-control">
                                        <option @if($custom_field->is_required == 0) selected @endif value="0">Not Required</option>
                                        <option @if($custom_field->is_required == 1) selected @endif value="1">Required</option>
                                        </select>  </div>
                                    <div class="col-md-3">
                                        <input type="number" value="{{$custom_field->field_length}}"  placeholder="Field Length" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" value="{{$custom_field->field_length}}"  placeholder="Default Value" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                               
                        <div class="form-group">

                            <label class="col-sm-3 control-label">@lang('Select Categories')</label>
                            <div class="col-sm-9">
                            <select class="form-control chosen-select" placeholder="Select Categories"  name="category_ids[]"  multiple>
                                <?php $custom_categories = json_decode($custom_field->category_ids, true); ?>
                                @foreach($categories as $category)
                                <option @if(in_array($category->id, $custom_categories)) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">@lang('Input Type')</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="type" id="type">
                                    <option @if($custom_field->type == "text") selected @endif value="text">Text</option>
                                    <option @if($custom_field->type == "textarea") selected @endif value="textarea">Textarea</option>
                                    <option @if($custom_field->type == "radio") selected @endif value="radio">Radio Box (Single Selection)</option>
                                    <option @if($custom_field->type == "checkbox") selected @endif value="checkbox">Checkbox (Multiple Selecton)</option>
                                    <option @if($custom_field->type == "dropbox") selected @endif value="dropbox">Drop Box</option>
                                    <option @if($custom_field->type == "url") selected @endif value="url">URL</option>
                                    <option @if($custom_field->type == "number") selected @endif value="number">Number</option>
                                    <option @if($custom_field->type == "date") selected @endif value="date">Date</option>
                                    <option @if($custom_field->type == "date_time") selected @endif value="date_time">Date Time</option>
                                    <option @if($custom_field->type == "video") selected @endif value="video">Video (Youtube, Vimeo)</option>
                                </select>

                            </div>
                        </div>

                        <?php 
                                $customOptions = json_decode($custom_field->options , true);
                            ?>
                                <div class="email-repeater form-group" id="showOptions" style="display:nonne">
                                   
                                        <div data-repeater-list="repeater-group">
                                            @foreach( $customOptions as $value)
                                                <div data-repeater-item class="row form-group">
                                                        <div class="col-sm-9">
                                                            <input type="text" name="option" value="{{$value}}" class="form-control" placeholder=" Value">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <button data-repeater-delete="" class="btn btn-danger waves-effect waves-light" type="button"> X </button>
                                                        </div>
                                                    
                                                </div>
                                            @endforeach
                                        </div>
                                    
                                    <button type="button" data-repeater-create="" class="btn btn-sm btn-info waves-effect waves-light">Add More</button>
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



            <script src="{{url('assets/backend/jquery.repeater/jquery.repeater.min.js')}}"></script>

<script> 
$('.chosen-select').chosen({width: "100%"});



    $(function() {
        $("body").on("change" , "#type" , function() { 
            $("#showOptions").hide();
            if($(this).val() == "dropbox") { 
                $("#showOptions").show();
            }
            if($(this).val() == "checkbox") { 
                $("#showOptions").show();
            }
            if($(this).val() == "radio") { 
                $("#showOptions").show();
            }
        })
    });

    $(function() {
        'use strict';

        // Default
    


        // Custom Show / Hide Configurations
        var repeater = $('.email-repeater').repeater({
            show: function() {
            $(this).slideDown();
            },
            hide: function(remove) {
                if (confirm('Are you sure you want to remove this item?')) {
                $(this).slideUp(remove);
                }
            }
        });

       
    });
</script>


<script>


// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict';
    window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
    form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
    });
    }, false);
})();
</script>

@endsection