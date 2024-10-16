<link href="{{ asset('assets/backend/cropper/cropper.css')}}" rel="stylesheet">
  <script src="{{ asset('assets/backend/cropper/cropper.js') }}"></script>
<style> 
.cropper-container.cropper-bg {
  background: #fff !important;
  background-image:none !important;
}

.cropper-modal {
    opacity: .5;
    background-color: #fff;
}
.modal-dialog.modal-lg {
    max-width: 640px;
}

/*.modal-body { padding-left:0px; padding-right:0px;}*/

</style>
 <script>

$(function() {
var cropper;
				
				var options = {
					  minContainerWidth:550,
					  minContainerHeight:250,
					  minCropBoxWidth:265,
					  minCropBoxHeight:205,
					  cropBoxResizable: false,
					  scalable:false,
					  crop: function(e) {
						 $("#cropped_value").val(parseInt(e.detail.width) + "," + parseInt(e.detail.height) + "," + parseInt(e.detail.x) + "," + parseInt(e.detail.y) + "," +  parseInt(e.detail.rotate));
					  },
					   ready: function () {
							$("#image_loader").html('');
					   }
					};
	
					

$("body").on("click" , "#image_source" , function() {

					var src = $("#image_source").attr("src");
					src = src.replace("/thumb", "");
					
					$('#image_cropper').attr('src', src);
					
					
					$("#myModal").modal("show");
					
});

$(".modal").on("hide.bs.modal", function() {
	// $(".cropper-container").remove();
	// cropper.destroy();
	var src = $("#image_source").attr("src");
	src = src.replace("/thumb", "");			
	$('#image_cropper').attr('src', src);
	cropper.replace(src);
						

});
$(".modal").on("show.bs.modal", function() {
	
	if($("#check_cropper").val() != 1) { 
		$("#image_loader").html('<i class="fa fa-spinner fa-spin " style="font-size:36px;color:#f79426"></i>');
		
		var image = document.getElementById('image_cropper');
		cropper = new Cropper(image, options);
		$("#check_cropper").val(1);
	}
	
	// var image = document.getElementById('image_cropper');
	// cropper = new Cropper(image, options);

});


$("body").on("click" , ".rotate" , function() {
		var degree = $(this).attr("data-option");
		cropper.rotate(degree);
});

$("body").on("click" , "#Save" , function() {
	var form_data = $('#uploadimage')[0];
	$("#loader").html('<i class="fa fa-spinner fa-spin " style="font-size:24px;color:#f79426"></i>');
	$("#Save").prop("disabled" , true);
	$.ajax({
				url: "<?php echo url('admin/category/upload_photo_crop'); ?>", // Url to which the request is send
                type: "POST",
                mimeType: "multipart/form-data",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },            // Type of request to be send, called as method
                data: new FormData(form_data), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                success: function(res)   // A function to be called if request succeeds
                {
                    var num = Math.random();
                        res = res + "?v="+num;
                       $('#image_source,#image,#user_pro_image').attr('src', res);
                      
                       $("#loader").html('');
                       $("#Save").prop("disabled" , false);
                        $("#myModal").modal("hide");
                        $('.upload-pic,.choose-profile-pic,#image_preview').show();
                        $(document).find('#js_image_exists').val(1);
                       
                       
                }
            });            
});


$(document).on("change","#cropper",function() {
       var imagecheck=$(this).data('imagecheck'),
           file = this.files[0],
           imagefile = file.type,
           _URL = window.URL || window.webkitURL;
           img = new Image();
           img.src = _URL.createObjectURL(file);
           img.onload = function() {
            
 
        var match= ["image/jpeg","image/png","image/jpg"];
        if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
        {
        alert('Please Select A valid Image File');
        return false;
        }
        else
        {
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = function () { // set image data as background of div
                
                $(document).find('#image_cropper').attr('src', "");
                $(document).find('#image_cropper').attr('src', this.result);
                 
                 // var image = document.getElementById('image_cropper');
                  
                  //cropper = new Cropper(image, options);

                  $("#myModal").modal("show");
                    cropper.replace(this.result);

    
                }
        }
        }
        });

});

    <!-- $(function () { -->
      
    <!-- }); -->
  </script>
<style> 
img {
  max-width: 100%; /* This rule is very important, please do not ignore this! */
}
</style>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Category Photo</h4>
      </div>
      <div class="modal-body">
      <div>
         <div width="100%" style="text-align:center" id="image_loader">  </div>
         <img width="100%"  src="" id="image_cropper">
            <br>
        <p class="text-center"> 
                      <button type="button" class="btn btn-primary rotate" data-method="rotate" data-option="-30"><i class="fa fa-undo"></i></button>
                      <button type="button" class="btn btn-primary rotate" data-method="rotate" data-option="30"><i class="fa fa-repeat"></i></button>
</p>
      
      </div>
      <input type="hidden" id="check_cropper" value="0" />
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="loader"></button>
      
          <input type="button" class="btn btn-primary" id="Save" value="Save Image">  </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>

  </div>
</div>
