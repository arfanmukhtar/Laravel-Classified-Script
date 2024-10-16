@extends('backend.layouts.app')

@section('content')




<link href="{{url('assets/backend/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">

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
                        <h5>@lang('All Users')</h5>
                        <div class="ibox-tools">
                        <a href="{{ route('add-template') }}" class="btn btn-primary btn-xs">@lang('common.add_new')</a>
                           
                           
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table id="allListings" class="table table-striped table-bordered table-hover" >
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                                
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





$(document).ready(function() {


// function in master2 layout
    var table=$('#allListings').DataTable({
        "aoColumnDefs": [{"bSortable": false, "aTargets": [0,1]}],
        "bProcessing": true,
        "bServerSide": true,
        "sPaginationType": "full_numbers",
        "sAjaxSource": "{{ url('/admin/templates/get-all-templates') }}",
        "aLengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]],

    });
});



</script>

@endsection
