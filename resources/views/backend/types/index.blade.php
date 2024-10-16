@extends('backend.layouts.app')

@section('content')

<link href="{{url('assets/backend/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">



<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                <h2></h2>
                    <ol class="breadcrumb">
                       
                    <li class="breadcrumb-item">
                            <a href="{{url('')}}">@lang('common.home')</a>
                        </li>
                     
                        <li class="breadcrumb-item active">
                            <strong>@lang('Types')</strong>
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
                 
            
                        <h5>Types</h5>
                        <div class="ibox-tools">
						    <a href="{{ url('admin/types/create') }}" class="btn btn-primary btn-xs">@lang('common.add_new')</a>
                        </div>
                        
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                    
                    <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($types as $key => $type)
                                            <tr>
                                                <td>{{ $type->name }}</td>
                                                <td>
                                                <!-- <form id="delete-customer" action="{{ url('admin/types/' . $type->id) }}" method="POST" class="form-inline">
                                                    <input type="hidden" name="_method" value="delete">
                                                    {{ csrf_field() }}
                                                    <input type="submit" value="Delete" class="btn btn-danger btn-xs pull-right btn-delete"> 
                                                </form> -->
                                                    &nbsp; <a href="{{ url('admin/types/' . $type->id . '/edit') }}" class="btn btn-primary btn-xs pull-right">Edit </a>
                                                    &nbsp; <a style="margin-right:10px" href="{{ url('admin/types/' . $type->id . '/edit') }}" class="btn btn-danger btn-xs pull-right btn-delete">Delete </a>
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
