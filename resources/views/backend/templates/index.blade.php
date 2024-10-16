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
                            <strong>@lang('Email Templates')</strong>
                        </li>
                    </ol>
                </div>

               
               
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>@lang('Map Email Templates')</h5>
                        <div class="ibox-tools">
                       
                           
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table id="allListings" class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <th>{{trans(' Module ')}}</th>
                                    <th>{{trans(' Email ')}}</th>
                                    <th>{{trans(' Notification ')}}</th>
                                    <th>{{trans(' Templates ')}}</th>
                                    <th>{{trans(' Actions ')}}</th>
                                </thead>
                                <tbody>
                            @foreach($systemClientTemplatesData as $systemClientTemplatesRow)
                            
                            <tr>
                                <td>{{ $systemClientTemplatesRow->module_name }}</td>
                                <td>
                                    <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                        <label>
                                            <input type="checkbox"  name="email_template" @if($systemClientTemplatesRow->email_status==1) checked @endif  value="1" id="email_template{{ $systemClientTemplatesRow->id }}">
                                            <span></span>
                                        </label>
                                    </span>
                                </td>
                                <td>
                                    <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                        <label>
                                            <input type="checkbox" name="email_text" @if($systemClientTemplatesRow->notification_status==1) checked @endif value="1" id="email_text{{ $systemClientTemplatesRow->id}}">
                                            <span></span>
                                        </label>
                                    </span>
                                </td>
                                <td>
                                    <select class="form-control m-select2" data-placeholder="Select Template" name="template_id" id="template_id_{{ $systemClientTemplatesRow->id }}">
                                        <option>{{trans('Select Template')}}</option>
                                        @foreach($clientTemplatesData as $clientTemplatesRow)
                                            <option value="{{ $clientTemplatesRow->id }}" @if($systemClientTemplatesRow->template_id==$clientTemplatesRow->id) selected @endif >{{ $clientTemplatesRow->template_name }}</option>
                                        @endforeach    
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success save-settings" id="{{ $systemClientTemplatesRow->id }}"> @lang('Save') </button>
                                </td>
                            </tr>
                            
                            @endforeach
                        </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            </div>
        </div>


        <script>
  
        $(document).ready(function() {
            $(".save-settings").click(function() {
                var id = $(this).attr('id');
                var email_template =  0;
                var email_text =  0;
                var template_id = $("#template_id_"+id).val();
                if($("#email_template"+id).is(":checked")){
                    email_template = $("#email_template"+id).val();
                }
                if($("#email_text"+id).is(":checked")){
                    email_text = $("#email_text"+id).val();
                }
                $.ajax({
                    type: "POST",
                    url: "{{ route('save-map-template') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {"id":id,"email_template":email_template,"email_text":email_text,'template_id':template_id},
                    cache: false,
                    dataType:'json',
                    success: function (data) {
                        if (data.status == "success") {
                            Command: toastr["success"] (data.message);
                        } else {                            
                            $("#alert_save").hide();
                            Command: toastr["error"] (data.message);
                        }
                    }
                });
            });
        });
    </script>

@endsection
