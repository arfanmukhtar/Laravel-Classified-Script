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
                            <strong>@lang('common.add_new')</strong>
                        </li>
                    </ol>
                </div>
               
            </div>
			
			<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-10">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>@lang('common.add') @lang('Custom Fields')</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                
                                
                            </div>
                        </div>
						<div class="ibox-content">
						<form action="{{route('custom-fields-store')}}" class="form-horizontal" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="col-sm-2 control-label">@lang('common.name')</label>
                            <div class="col-sm-9"><input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"></div>
                        </div>
                        <div class="form-group">
                             <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-md-3"> 
                                        <select name="required" class="form-control">
                                            <option value="0">Not Required</option>
                                            <option value="1">Required</option>
                                        </select>  </div>
                                    <div class="col-md-3">
                                        <input type="number" placeholder="Field Length" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" placeholder="Default Value" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                               
                        <div class="form-group">

                            <label class="col-sm-3 control-label">@lang('Select Categories')</label>
                            <div class="col-sm-9">
                            <select class="form-control chosen-select" placeholder="Select Categories"  name="category_ids[]"  multiple>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">@lang('Input Type')</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="type" id="type">
                                    <option value="text">Text</option>
                                    <option value="textarea">Textarea</option>
                                    <option value="radio">Radio Box (Single Selection)</option>
                                    <option value="checkbox">Checkbox (Multiple Selecton)</option>
                                    <option value="dropbox">Drop Box</option>
                                    <option value="url">URL</option>
                                    <option value="number">Number</option>
                                    <option value="date">Date</option>
                                    <option value="date_time">Date Time</option>
                                    <option value="video">Video (Youtube, Vimeo)</option>
                                </select>

                            </div>
                        </div>

                            <div class="email-repeater" id="showOptions" style="display:none">
                                    <div data-repeater-list="repeater-group">
                                        <div data-repeater-item class="row form-group">
                                                <div class="col-sm-9">
                                                    <input type="text" name="option" class="form-control" placeholder=" Value">
                                                </div>
                                                <div class="col-sm-2">
                                                    <button data-repeater-delete="" class="btn btn-danger waves-effect waves-light" type="button"> X </button>
                                                </div>
                                            
                                        </div>
                                       
                                    </div>
                                    <button type="button" data-repeater-create="" class="btn btn-sm btn-info waves-effect waves-light">Add More
                                            </button>
                            </div>
                               


                        <!-- <div id="repeater" style="display:nonen">
                            <div class="form-group items" data-group="test"  >
                                <label class="col-sm-2 control-label">Options</label>
                                <div class="col-sm-5">
                                    <input type="text" name="" class="form-control" placeholder="Option Value">
                                </div>
                                <div class="col-sm-5">
                                <button data-repeater-delete="" class="btn btn-danger waves-effect waves-light" type="button"> X </button>
                                </div>

                                <button class="btn btn-primary pt-5 pull-right repeater-add-btn">Add </button>

                            </div>
                        </div> -->
                          
                   
                                
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
        $('.repeater-default').repeater();

        // Custom Show / Hide Configurations
        $('.file-repeater, .email-repeater').repeater({
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