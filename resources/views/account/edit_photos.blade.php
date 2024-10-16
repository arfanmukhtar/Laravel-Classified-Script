@extends('frontend.app')

@section('content')

<link href="{{url('assets/backend/css/plugins/cropper/cropper.min.css')}}" rel="stylesheet">
<script src="{{url('assets/backend/js/plugins/cropper/cropper.min.js')}}"></script>

<style> 
.img-preview {
  overflow: hidden;
  text-align: center;
  width: 100%;
}
.img-preview-sm {
  height: 200px;
  width: 200px;
}
</style>

<div class="main-container">
        <div class="container">
            <div class="row">
               
               @include('account.sidebar')

               <div class="col-md-9 page-content">
                   
               
                    <div class="inner-box">
                        <div class="welcome-msg">
                            <h3 class="page-sub-header2 clearfix no-padding">{{ trans('acount.edit_photo.update_ad') }}
                            <button class="btn btn-success btn-sm">{{ trans('acount.edit_photo.add_more') }}</button>
                            </h3>
                            <span class="page-sub-header-sub small"><strong>{{ trans('acount.edit_photo.updating') }}</strong> {{$post->title}}</span>
                            
                            
                        </div>
                        

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox ">
                                    <div class="ibox-title  back-change">
                                        <h5>{{ trans('acount.edit_photo.image_cropper') }} </h5>
                                        
                                    </div>
                                    <div class="ibox-content">
                                        <?php
                                            $editPhoto = "";
                                            $editPhotoId = ""; 
                                            if(!empty($photos)) {
                                                $editPhoto = $photos[0]->filename;
                                                $editPhotoId = $photos[0]->id;
                                            }
                                            
                                            if(!empty($photo)) { 
                                                $editPhoto = $photo->filename;
                                                $editPhotoId = $photo->id;
                                            }
                                             
                                        ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="image-crop">
                                                    <img id="image-crop" src="{{url('storage/' . $editPhoto)}}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                               
                                                <h4>{{ trans('acount.edit_photo.preview_image') }}</h4>
                                                <div class="img-preview img-preview-sm"></div>
                                                <br>
                                               <input type="hidden" id="cropped_value" >
                                               <input type="hidden" id="photo_id" value="{{$editPhotoId}}">
                                               <input type="hidden" id="post_id" value="{{$post->id}}">
                                                <div class="btn-group">
                                                    <label title="" id="Save" class="btn btn-primary">{{ trans('acount.edit_photo.save_update') }}</label>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-12 content-box ">
                            <div class="row row-featured row-featured-category">
                               
                                @foreach($photos as $photo)
                                    <div class="col-xl-3 col-md-4 col-sm-4 col-xs-4 f-category">
                                        <img src="{{url('storage/' . $photo->filename)}}" class="img-responsive" alt="img">
                                        <br>
                                        <a href="javascript:void(0);" class="changePhoto" data-id="{{url('account/edit-photos/' . $post->id . '?p=' . $photo->id)}}">{{ trans('acount.edit_photo.edit') }}</a>
                                        <a href="javascript:void(0);" class="deletePhoto" data-id="{{ $photo->id }}">{{ trans('acount.edit_photo.delete') }}</a>
                                    </div>
                                   
                                @endforeach
                            </div>


                        </div>

                       
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>


    <script> 
        $(document).ready(function() {
            var $image = $(".image-crop > img")
            $($image).cropper({
                // aspectRatio: 1.1,
                preview: ".img-preview",
                done: function(e) {
                    $("#cropped_value").val(parseInt(e.width) + "," + parseInt(e.height) + "," + parseInt(e.x) + "," + parseInt(e.y));
                    
                    // Output the result data for cropping image.
                }
            });


            $("body").on("click", ".changePhoto", function() { 
               window.location.href= $(this).attr("data-id");
            });
            $("body").on("click", ".deletePhoto", function() { 
                $.ajax({
                    url: "<?php echo route('delete-photo'); ?>", // Url to which the request is send
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },            // Type of request to be send, called as method
                    data: { photo_id: $("#photo_id").val()}, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    success: function(res)   // A function to be called if request succeeds
                    {      
                        location.reload();
                    }
                });         
            });

    });



    $("body").on("click" , "#Save" , function() {
            $(".loader").show();
            // $("#Save").prop("disabled" , true);
            $.ajax({
				url: "<?php echo route('update-photo'); ?>", // Url to which the request is send
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },            // Type of request to be send, called as method
                data: {value:$("#cropped_value").val(), photo_id: $("#photo_id").val(), post_id: $("#post_id").val()}, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                success: function(res)   // A function to be called if request succeeds
                {      
                    location.reload();
                }
            });            
});

</script>


@endsection
