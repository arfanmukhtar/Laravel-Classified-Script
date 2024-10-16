@extends('backend.layouts.app')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2><?php echo $title; ?> </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{url('/')}}">@lang('common.home')</a>
                        </li>
                     
                        <li class="active">
                            <strong><?php echo $title; ?></strong>
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
                        <h5><?php echo $title; ?> </h5>
                        <div class="ibox-tools">
                        <a class="add_new btn btn-primary pull-right" href="javascript:void(0)" data-toggle="modal" data-target="#myModal" style="margin-bottom:5px"><i class="fa fa-plus"> </i> Add</a>
                        
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            
                          
                           
                        </div>
                    </div>
                    

<div class="ibox-content">
           
            <div class="table-responsive">
            <table class="table table-striped">
            <thead>
                <tr>

                    <th>Package Name</th>
                    <th>Price</th>
                    <th>Post Limits</th>
                    <th>Feature Post Limits</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($packages)) { foreach ($packages as $row) { ?>
                    <tr id="{{$row->id}}">
                        <td>{{$row->package_name}}</td>
                        <td>{{$row->price}}</td>
                        <td>{{$row->posts_limit}}</td>
                        <td>{{$row->feature_posts_limit}}</td>
                         <td> 
                            <a data-id="{{$row->id}}" class="edit" href="javascript:void(0)" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit"> </i> </a>
                            <a data-id="{{$row->id}}" class="delete" href="javascript:void(0)" > <i class="fa fa-trash"> </i> </a> 
                        </td>
                    </tr>
                <?php } 
                } else {  ?>
                <tr>
                    <td rowspan=4> No Package Found </td> 
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
                <h4 class="modal-title" id="myModalLabel">Add New</h4>
            </div>
            <form role="form" action="<?php echo url("admin/packages/save"); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    {!! csrf_field() !!} 

                    <div class="form-group">
                        <label> Package Name</label>
                        <input class="form-control" required type="text" id="package_name" name="package_name">
                        <input class="form-control" type="hidden" id="id" name="id">
                    </div>
                    <div class="form-group">
                        <label> Package Price</label>
                        <input class="form-control" required type="text" id="price" name="price">
                    </div>
                    <div class="form-group">
                        <label> Posts Limit</label>
                        <input class="form-control" required type="text" id="posts_limit" name="posts_limit">
                    
                    </div>
                    <div class="form-group">
                        <label> Post Request Limit</label>
                        <input class="form-control" required type="text" id="post_request_limit" name="post_request_limit">
                       
                    </div>
                    <div class="form-group">
                        <label> Feature Post Limit</label>
                        <input class="form-control" required type="text" id="feature_posts_limit" name="feature_posts_limit">
                        
                    </div>
                    <div class="form-group">
                        <label> Ecommerce Post Limit </label>
                        <input class="form-control" required type="text" id="ecommerce_posts_limit" name="ecommerce_posts_limit">
                        
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
        $("#package_name").val("");
        $("#price").val("");
        $("#posts_limit").val("");
        $("#feature_post_limit").val("");
        $("#post_request_limit").val("");
        $("#feature_posts_limit").val("");
        $("#ecommerce_posts_limit").val("");
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
            url: '<?php echo url("admin/packages/get"); ?>',
            data: form_data,
            success: function (msg) {
                var obj = $.parseJSON(msg);
                $("#package_name").val(obj['package_name']);
                $("#posts_limit").val(obj['posts_limit']);
                $("#price").val(obj['price']);
                $("#feature_post_limit").val(obj['feature_post_limit']);
                $("#post_request_limit").val(obj['post_request_limit']);
                $("#feature_posts_limit").val(obj['feature_posts_limit']);
                $("#ecommerce_posts_limit").val(obj['ecommerce_posts_limit']);
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
            url: '<?php echo url("admin/packages/delete"); ?>',
            data: form_data,
            success: function (msg) {
                $("#" + id).hide(1);
            }
        });
    });

</script>



@endsection
