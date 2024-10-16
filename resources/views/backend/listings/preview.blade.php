@extends('backend.layouts.app')

@section('content')

<link href="{{url('assets/backend/css/plugins/slick/slick.css')}}" rel="stylesheet">
    <link href="{{url('assets/backend/css/plugins/slick/slick-theme.css')}}" rel="stylesheet">


        
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2></h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                      <a href="{{url('')}}">@lang('common.home')</a>
                    </li>
                  
                    <li class="breadcrumb-item active">
                        <strong>Ads detail</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">
                <div class="col-lg-12">

                    <div class="ibox product-detail">
                        <div class="ibox-content">

                            <div class="row">
                                <div class="col-md-5">


                                    <div class="product-images">
                                    @foreach($images as $img)
                                    <div>
                                            <div class="image-imitation">
                                            <img
                                            src="{{url('storage/' . $img->filename)}}" width="100%"  alt="img"/>
                                            </div>
                                        </div>

                                   
                                @endforeach
                                      


                                    </div>

                                </div>
                                <div class="col-md-7">

                                    <h2 class="font-bold m-b-xs">
									{{$item->title}}
                                    </h2>
                                    <small>Many desktop publishing packages and web page editors now.</small>
                                    <div class="m-t-md">
                                        @if($item->status == 0)
                                        <button class="btn btn-w-m btn-success float-right">Pending</button>
                                        @endif
                                        @if($item->status == 1)
                                        <button class="btn btn-w-m btn-success float-right">Published</button>
                                        @endif
                                        @if($item->status == 2)
                                        <button class="btn btn-w-m btn-danger float-right">Rejected</button>
                                        @endif
                                        @if($item->status == 3)
                                        <button class="btn btn-w-m btn-warning float-right">Archived</button>
                                        @endif
                                        <h2 class="product-main-price">{{$item->price}}  </h2>
                                    </div>
                                    <hr>

                                    <h4>Product description</h4>

                                    {!!$item->description!!}
                                    <hr>

                                    <div>
                                        <div class="btn-group">
                                            <button class="btn btn-primary btn-sm changeStatus" data-id="1"><i class="fa fa-plus"></i> Publish</button>&nbsp;&nbsp;
                                            <button class="btn btn-danger btn-sm changeStatus" data-id="2"><i class="fa fa-plus"></i> Reject</button>&nbsp;&nbsp;
                                            <button class="btn btn-warning btn-sm changeStatus" data-id="3"><i class="fa fa-plus"></i> Archive</button>&nbsp;&nbsp;
                                            
                                        </div>
                                    </div>



                                </div>
                            </div>

                        </div>
                        <div class="ibox-footer">
                            <span class="float-right">
                                Full stock - <i class="fa fa-clock-o"></i> 14.04.2016 10:04 pm
                            </span>
                            The generated Lorem Ipsum is therefore always free
                        </div>
                    </div>

                </div>
            </div>
            




        </div>
       



<script src="{{url('assets/backend/js/plugins/slick/slick.min.js')}}"></script>
<link href="{{url('assets/backend/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
 <script src="{{url('assets/backend/js/plugins/toastr/toastr.min.js')}}"></script>

<script>
    $(document).ready(function(){


        $('.product-images').slick({
            dots: true
        });

    });


$("body").on("click", ".changeStatus", function() {
    var form_data = {
        id : <?php echo $item->id ?>,
        status: $(this).attr("data-id")
    };
    $.ajax({
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '<?php echo route("change-status"); ?>',
        data: form_data,
        success: function (msg) {
        
            toastr.success("Successfully Changed");  
            setTimeout(function() { 
                location.reload();
            }, 1000)
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
