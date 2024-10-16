@extends('backend.layouts.app')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2></h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{url('/')}}">@lang('common.home')</a>
                        </li>
                     
                        <li class="breadcrumb-item active">
                            <strong>@lang('Timezones')</strong>
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
                        <h5>@lang('Timezones')	</h5>
                       
                    </div>
                    

<div class="ibox-content">
           
<div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
            <thead>
                <tr>

                    <th>@lang('Name')</th>
                    <th>@lang('Location')</th>
                    <th>@lang('common.options')</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($timezones)) { foreach ($timezones as $row) { ?>
                    <tr id="{{$row->id}}">

                         <td>{{$row->timezone}}</td>
                         <td>{{$row->timezone_location}}</td>
                         <td> 
                            <a data-id="{{$row->id}}" class="edit" href="javascript:void(0)" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit"> </i> </a>
                           
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

<?php

function clean($string) 
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
?>




<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form role="form" action="<?php echo route("save-timezone"); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    {!! csrf_field() !!} 

                    <div class="form-group">
                        <label> Name </label>
                        <input class="form-control" required type="text" id="timezone" readonly name="timezone">
                        <input class="form-control" type="hidden" id="id" name="id">
                    </div>
                    <div class="form-group">
                        <label> Description </label>
                        <input class="form-control" required type="text" id="timezone_location" name="timezone_location">
                       
                    </div>
                  


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    $("body").on("click", ".add_new", function () {
        $("#name").val("");
        $("#description").val("");
        $("#keywords").val("");
        $("#id").val("");
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
            url: '<?php echo route("get-timezone"); ?>',
            data: form_data,
            success: function (msg) {
                var obj = $.parseJSON(msg);
                $("#timezone").val(obj['timezone']);
                $("#timezone_location").val(obj['timezone_location']);
                $("#id").val(obj['id']);
            }
        });

    });


   

</script>


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
