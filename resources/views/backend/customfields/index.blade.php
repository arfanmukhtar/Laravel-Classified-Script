@extends('backend.layouts.app')

@section('content')
<link href="{{url('assets/backend/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">


<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <ol class="breadcrumb">
                       
                    <li class="breadcrumb-item">
                            <a href="{{url('')}}">@lang('common.home')</a>
                        </li>
                     
                        <li class="breadcrumb-item active">
                            <strong>@lang('Custom Fields')</strong>
                        </li>

                       
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Custom Fields</h5>
                        <div class="ibox-tools">
						    <a href="{{ url('admin/customfields/create') }}" class="btn btn-primary btn-xs">@lang('common.add_new')</a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                    
                  
<thead>
                                            <tr>
                                               <th>Title</th>
                                                <th>Type</th>
                                                <th>Required</th>
                                                <th>Associate Categories</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($custom_fields as $custom_field)
                                            <tr>
                                                <td>{{$custom_field->name}}</td>
                                                <td>{{$custom_field->type}}</td>
                                                <td>{{$custom_field->is_required}}</td>
                                                <td>
                                                    {{$custom_field->categories}}
                                                    <!-- <br> -->
                                                    <!-- <a href="javascript:void(0)" data-id="{{$custom_field->id}}"> Add </a> -->
                                                </td>
                                                <td>
                                               
                                                    &nbsp; <a href="{{ url('admin/customfields/' . $custom_field->id . '/edit') }}" class="btn btn-primary btn-xs pull-right">Edit </a>
                                                     <a style="margin-right:10px" href="{{ url('admin/customfields/' . $custom_field->id . '/edit') }}" class="btn btn-danger btn-xs pull-right">Delete </a>
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



       


<script src="{{url('assets/backend/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{url('assets/backend/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>

<script> 

$(document).ready(function(){
            $('.dataTables').DataTable({
                pageLength: 25,
                responsive: true,
               

            });

        });

</script>



@endsection
