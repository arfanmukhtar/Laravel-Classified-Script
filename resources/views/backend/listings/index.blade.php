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
                            <strong>Ads</strong>
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
                        <h5>@lang('All Listings')</h5>
                        <div class="ibox-tools">
                        <a href="{{ url('admin/categories/create') }}" class="btn btn-primary btn-xs">@lang('common.add_new')</a>
                       
                           
                        </div>
                    </div>
                    <div class="ibox-content">
                    <select class="form-control" id="adsStatus">
                            <option value="">All</option>
                            <option value="0">Pending</option>
                            <option value="1">Published</option>
                            <option value="2">Rejected</option>
                            <option value="3">Archived</option>
                        </select>
                        <div class="table-responsive">
                            <table id="allListings" class="table table-striped table-bordered table-hover dataTables-example" >
                                
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Post Date</th>
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
    var page_limit= 10;  // Params (table,page,default_limit=10)
    var table=$('#allListings').DataTable({
        "aoColumnDefs": [{"bSortable": false, "aTargets": [0,5]}],
        "bProcessing": true,
        "bServerSide": true,
        responsive: true,
        "aaSorting": [[4, "desc"]],
        "sPaginationType": "full_numbers",
        "sAjaxSource": "{{ url('admin/getListings') }}",
        "pageLength" : page_limit,
        "fnServerParams": function (aoData) {
            aoData.push({"name": "status", "value": $("#adsStatus").val()});
        },
        "aLengthMenu": [[10, 50, 100, 500], [10, 50, 100, 500]],
        initComplete: function() {
            $(this.api().table().container()).find('input').attr('autocomplete', 'off');
            $(this.api().table().container()).find('input').val('');
        },

    });

    $("#adsStatus").change(function () {
        table.draw();
    });


});


$("body").on("click", ".reviewAd" , function() { 
    var id = $(this).attr("data-id");
    var title = $(this).attr("data-title");
    $("#reviewModel").modal("show");
    $("#ad_id").val(id);
    $("#adsTitle").html(title);
});

$("body").on("click", "#ChangeStatus", function() {
    $.ajax({
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '<?php echo route("update-password"); ?>',
        data: form_data,
        success: function (msg) {
        
            var obj = JSON.parse(msg);
            if(obj['error'] == 1) {
                toastr.error(obj['message']);	
            }
            
            if(obj['error'] == 0) {
                toastr.success(obj['message']);
                $('#resetPasswordModal').modal('hide');
                $('#changeEmailModal').modal('hide');
            }
                
        }
    });
})

</script>




<!-- resetPasswordModal -->
<div class="modal fade" id="reviewModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Review Ad <small id="adsTitle"> </small></h4>
      </div>
      <div class="modal-body">
       
		  	<div class="form-group">
			  <label class="font-14px">Status</label>
			  <select class="form-control">
                <option value="0">Pending</option>
                <option value="1">Publish</option>
                <option value="2">Reject</option>
                <option value="3">Archive</option>
              </select>
		  </div>
</div>
     		
   
      <div class="modal-footer">
      <input type="hidden" id="ad_id">
        <button type="button" id="Update_Password" data-id="pass" class="btn btn-primary">Save Change</button>
      </div>
    </div>
  </div>
</div>

   
@endsection
