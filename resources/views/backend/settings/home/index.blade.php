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
                 <div class="ibox ">
                    <div class="ibox-title">
                        <h5><?php echo $title; ?> </h5>
                        <div class="ibox-tools">
                            <a class="add_new  btn-xs btn btn-primary pull-right" href="javascript:void(0)" data-toggle="modal" data-target="#myModal" style="margin-bottom:-5px"><i class="fa fa-plus"> </i> @lang('common.add_new') </a>
                           
                        </div>
                    </div>

              
                    

<div class="ibox-content">
           
            <div class="table-responsive">
            <table class="table table-striped">
            <thead>
                <tr>

                    <th>Title</th>
                    <th>Video Link</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($videos)) { foreach ($videos as $row) { ?>
                    <tr id="{{$row->id}}">
                        <td>{{$row->title}}</td>
                        <td>{{$row->link}}</td>
                         <td> 
                            <a data-title="{{$row->title}}" data-link="{{$row->link}}" data-id="{{$row->id}}" class="edit" href="javascript:void(0)" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit"> </i> </a>
                            <a data-id="{{$row->id}}" class="delete" href="javascript:void(0)" > <i class="fa fa-trash"> </i> </a> 
                        </td>
                    </tr>
                <?php } 
                } else {  ?>
                <tr>
                    <td rowspan=4> Not Found </td> 
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


?>




<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add New</h4>
            </div>
            <form role="form" action="<?php echo route("save-home-video"); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    {!! csrf_field() !!} 

                    <div class="form-group">
                        <label>  Title</label>
                        <input class="form-control" required type="text" id="title" name="title">
                        <input class="form-control" type="hidden" id="id" name="id">
                    </div>
                    <div class="form-group">
                        <label> Video Link </label>
                        <input class="form-control" required type="text" id="link" name="link">
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
        $("#title").val("");
        $("#link").val("");
        $("#id").val("");
    });
    $("body").on("click", ".edit", function () {
        var id = $(this).attr("data-id");
        $("#title").val($(this).attr("data-title"));
        $("#link").val($(this).attr("data-link"));
        $("#id").val(id);

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
            url: '<?php echo route("delete-home-video"); ?>',
            data: form_data,
            success: function (msg) {
                $("#" + id).hide(1);
            }
        });
    });

</script>



@endsection
