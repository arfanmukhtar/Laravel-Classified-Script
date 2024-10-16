@extends('backend.layouts.app')

@section('content')
<?php $currency =  setting_by_key("currency"); ?>

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>@lang('common.roles')</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{url('/')}}">@lang('common.home')</a>
                        </li>
                     
                        <li class="active">
                            <strong>@lang('common.roles')</strong>
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
                        <h5>@lang('common.roles')</h5>
                       
                    </div>
                    

<div class="ibox-content">
           
            <div class="table-responsive">
            <table class="table table-striped">
            <thead>
                <tr>

                    <th>@lang('common.name')</th>
                    <th>@lang('common.description')</th>
                    <th>@lang('common.options')</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($roles)) { foreach ($roles as $row) { ?>
                    <tr id="{{$row->id}}">

                         <td>{{$row->name}}</td>
                         <td>{{$row->description}}</td>
                         <td> 
                            <a class="edit" href="{{url('admin/roles/edit/' . $row->id)}}"> <i class="fa fa-edit"> </i> </a>
                            
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




<script type="text/javascript">
    $("body").on("click", ".add_new", function () {
        $("#name").val("");
        $("#description").val("");
        $("#price").val("");
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
            url: '<?php echo url("expenses/get"); ?>',
            data: form_data,
            success: function (msg) {
                var obj = $.parseJSON(msg);
                $("#title").val(obj['title']);
                $("#description").val(obj['description']);
                $("#price").val(obj['price']);
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
            url: '<?php echo url("expenses/delete"); ?>',
            data: form_data,
            success: function (msg) {
                $("#" + id).hide(1);
            }
        });
    });

</script>



@endsection
