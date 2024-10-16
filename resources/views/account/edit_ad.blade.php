@extends('frontend.app')

@section('content')

<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
<script type="text/javascript">

$(function(){
    var $ckfield = CKEDITOR.replace( 'description' );

    $ckfield.on('change', function() {
      $ckfield.updateElement();         
    });
});

   

 
</script>

<div class="main-container">
        <div class="container">
            <div class="row">
               
               @include('account.sidebar')

               <div class="col-md-9 page-content">
                   
               <form class="form-horizontal" method="POST" action="{{route('updateProfile')}}" role="form" id="postAnAd">
                   @csrf
                    <div class="inner-box">
                        <div class="welcome-msg">
                            <h3 class="page-sub-header2 clearfix no-padding">{{ trans('account.edit_ads.update_ad') }}</h3>
                            <span class="page-sub-header-sub small"><strong>{{ trans('account.edit_ads.updating') }}</strong> {{$post->title}}</span>
                        </div>
                        <div id="accordion" class="panel-group">
                            <div class="card card-default">
                                <div class="card-header">
                                    <h4 class="card-title"><a href="#collapseB1" aria-expanded="true"  data-bs-toggle="collapse" > 
                                    {{ trans('account.edit_ads.ad_details') }}</a></h4>
                                </div>
                                <div class="panel-collapse collapse show" id="collapseB1">
                                    <div class="card-body">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> {{ trans('account.edit_ads.name') }}</label>
                                                <div class="col-sm-9">
                                                <input type="hidden" value="{{$post->id}}" name="post_id" id="post_id">
                                                <select name="category_id" id="category_id" class="form-control">
                                                    <option value="">{{ trans('account.edit_ads.select _category') }}</option>
                                                    @foreach($categories as $cat)
                                                    <option value="{{$cat->id}}" @if($cat->id == $post->category_id) selected @endif>{{$cat->name}}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> {{ trans('account.edit_ads.title') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="title" value="{{$post->title}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> {{ trans('account.edit_ads.description') }} </label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" id="description" name="description">{{$post->description}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"> {{ trans('account.edit_ads.price') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="price" value="{{$post->price}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{ trans('account.edit_ads.city') }}</label>
                                                <div class="col-sm-9">
                                                <select id="seller-Location" name="city_id" class="form-control">
                                                    @foreach($cities as $city)
                                                    <option value="{{$city->id}}" @if($post->city_id == $city->id) selected @endif>{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h4 class="card-title"><a href="#collapseB2" aria-expanded="true"  data-bs-toggle="collapse" >{{ trans('account.edit_ads.aditional_information') }} </a>
                                        </h4>
                                    </div>
                                    <div class="panel-collapse collapse" id="collapseB2">
                                        <div class="card-body" id="customFields">

                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card card-default"> -->
                                    <!-- <div class="card-header">
                                        <h4 class="card-title"><a href="#collapseB3" aria-expanded="true"  data-bs-toggle="collapse" >
                                            Preferences </a></h4>
                                    </div> -->
                                    <!-- <div class="panel-collapse collapse" id="collapseB3">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox">
                                                            I want to receive newsletter. </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox">
                                                            I want to receive advice on buying and selling. </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                <!-- </div> -->
                            </div>
                            <!--/.row-box End-->
                            <br><br>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" id="PostNow" class="btn btn-success">{{ trans('account.edit_ads. update') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>


    <script> 
        $(document).ready(function() {


            $('#postAnAd').submit(function() {
            var form_data = $(this).serialize();

            $.ajax({
                url: "{{ route('update-ad') }}",
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(".blockUI").show();
                    $("#PostNow").text("Updating...");
                },
                complete: function () {
                    $(".blockUI").hide();
                },
                success: function(result) {
                    var obj = JSON.parse(result);
                    var err = "";
                    if(obj["status"] == false) { 
                        err += '<div class="alert alert-danger" role="alert">';
                        err += obj["errors"];
                        err += '</div>';
                    }
                    if(obj["status"] == true) { 
                        err += '<div class="alert alert-success" role="alert">';
                        err += obj["errors"];
                        err += '</div>';
                    }

                    
                    $("#PostNow").text("Update");
                    $("#showError").html(err);

                    if(obj["status"] == true) { 
                        alert("Updated Successfully");
                        // setTimeout(() => {
                        //     location.reload();
                        // }, 1000);
                    }
                   
                },
                error: function(result) { 
                     var obj = JSON.parse(result);
                    console.log(result);
                }
            });
            return false;
        });



        setTimeout(() => {
            $("#category_id").change();
        }, 1000);
        
        $("body").on("change", "#category_id", function() { 
            var form_data = {
                id: $("#category_id").val(),
                post_id: <?php echo $post->id; ?>
            }
            $.ajax({
                url: "{{ route('get-additional-fields') }}",
                type: 'POST',
                data: form_data,
                headers: {
                    'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                },
                beforeSend: function () {
                    $(".blockUI").show();
                },
                complete: function () {
                    $(".blockUI").hide();
                },
                success: function(html) {
                    $("#customFields").html(html);
                }
            });
        });

        $('#profileForm, #userPassword').submit(function(e) {
            e.preventDefault(); // Prevent form submission
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    // Handle the success response
                    if(response == "success") {
                        $("#success").show();
                        $("#failed").hide();
                    } else { 
                        $("#success").hide();
                        $("#failed").show();
                    }
                   
                    setTimeout(function() { 
                        $("#successMsg").hide();
                    } , 1000)
                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>


@endsection
