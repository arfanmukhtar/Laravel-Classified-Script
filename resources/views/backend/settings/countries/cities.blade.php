@extends('backend.layouts.app')

@section('content')
<link href="{{url('assets/backend/css/plugins/dataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{url('assets/backend/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2></h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{url('/')}}">@lang('common.home')</a>
                        </li>
                     
                        <li class="breadcrumb-item active">
                            <strong>@lang('Cities')</strong>
                        </li>
                    </ol>
                </div>
               
            </div>

             <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>@lang('Cities')	</h5>
                        <div class="ibox-tools">
						    <a href="javascript:void(0);" class="btn btn-primary btn-xs importList">Import {{$code}} List</a>
						    <a href="javascript:void(0);" class="btn btn-primary btn-xs add_new">@lang('common.add_new')</a>
                        </div>
                    </div>
                    

<div class="ibox-content">
           
<div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
            <thead>
                <tr>

                    <th>@lang('common.name')</th>
                    <th>@lang('Areas')</th>
                    <th>@lang('Total Ads')</th>
                    <th>@lang('Requested Ads')</th>
                    <th>@lang('Country Code')</th>
                    <th>@lang('common.options')</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($cities)) { foreach ($cities as $row) { ?>
                    <tr id="{{$row->id}}">

                         <td>{{$row->name}}</td>
                         <td><a data-id="{{$row->id}}" class="edit" href="{{url('admin/settings/cities/areas/' . $row->id)}}" > {{App\Models\City::totalAreas($row->id)}} </a></td>
                         <td>{{App\Models\City::totalPosts($row->id)}}</td>
                         <td>{{App\Models\City::totalRequestedPosts($row->id)}}</td>
                         <td>{{$row->country_code}}</td>
                         <td> 
                            <a data-id="{{$row->id}}" class="edit" href="javascript:void(0)" data-toggle="modal" data-target="#cityModal"> <i class="fa fa-edit"> </i> </a>
                            <a data-id="{{$row->id}}" class="delete" href="javascript:void(0)" > <i class="fa fa-trash"> </i> </a>
                        </td>
                    </tr>
                <?php } 
                } else {  ?>
                <tr>
                    <td rowspan="5">@lang('common.no_record_found') </td> 
                </tr>
<?php } ?>

            </tbody>
        </table>
		
    </div>
    <!-- /.table-responsive -->
</div>
</div>
</div>
</div>
</div>



<div class="modal fade" id="cityModal" tabindex="-1" role="dialog" aria-labelledby="cityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">City</h4>
        </div>
            <form role="form"  method="post" enctype="multipart/form-data" id="cityForm">
                <div class="modal-body">
                    {!! csrf_field() !!} 
                    <div class="form-group">
                        <label> Name </label>
                        <input class="form-control" required type="text" id="name" name="name">
                        <input class="form-control" type="hidden" id="id" name="id" >
                    </div>
                    <div class="form-group">
                        <label> Slug </label>
                        <input class="form-control" required type="text" id="slug" name="slug">
                    </div>
                    
                    <div class="form-group">
                        <label> Country Code </label>
                        <input class="form-control" required type="text" id="country_code" name="country_code">
                    </div>
                    <div class="form-group">
                        <label> Longitude  </label>
                        <input class="form-control" required type="text" id="longitude" name="longitude">
                    </div>
                    <div class="form-group">
                        <label> Latitude  </label>
                        <input class="form-control" required type="text" id="latitude" name="latitude">
                    </div>
                 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitForm">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script src="{{url('assets/backend/js/plugins/dataTables/datatables.min.js')}}"></script>
    <script src="{{url('assets/backend/js/plugins/dataTables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('assets/backend/js/plugins/toastr/toastr.min.js')}}"></script>


<script type="text/javascript">

var dTable = $(document).ready(function(){
            $('.dataTables').DataTable({
                pageLength: 25,
                responsive: true,
            });

        });


    $("body").on("click", ".add_new", function () {
        $("#name").val("");
        $("#slug").val("");
        $("#longitude").val("");
        $("#latitude").val("");
        $("#country_code").val("<?php echo Request::segment(4); ?>");
        $("#id").val("");
        $("#cityModal").modal("show");
    });
    $("body").on("click", ".edit", function () {
        var id = $(this).attr("data-id");
        var form_data = {
            id: id
        };
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '<?php echo route("get-city"); ?>',
            data: form_data,
            success: function (msg) {
                var obj = $.parseJSON(msg);
                $("#name").val(obj['name']);
                $("#slug").val(obj['slug']);
                $("#longitude").val(obj['longitude']);
                $("#latitude").val(obj['latitude']);
                $("#country_code").val(obj['country_code']);
                $("#id").val(obj['id']);
               
            }
        });

    });
    $("body").on("click", ".delete", function () {
        var id = $(this).attr("data-id");
        var form_data = {
            id: id
        };
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '<?php echo route("delete-city"); ?>',
            data: form_data,
            success: function (msg) {
                toastr.success('Deleted Successfully');
            }
        });

    });


    $("body").on("click", "#submitForm", function () {
        var id = $(this).attr("data-id");
        var form_data = $("#cityForm").serialize();
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '<?php echo route("save-city"); ?>',
            data: form_data,
            success: function (msg) {
                toastr.success('Saved Successfully');
                $("#cityModal").modal("hide");
                $('.dataTables').DataTable().ajax.reload();
                // dTable.ajax.reload();

            }
        });

    });



    $("body").on("click", ".importList", function () {
    
        var form_data = {
            code: "<?php echo $code; ?>"
        };
        $("#loading").show();
        $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '<?php echo route("import-cities-list"); ?>',
            data: form_data,
            success: function (msg) {
                 location.reload();
            },
            complete: function(msg) { 
                $("#loading").hide();
            }
        });

    });
    </script>


@endsection
