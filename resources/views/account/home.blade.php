@extends('frontend.app')

@section('content')


<div class="main-container">
        <div class="container">
            <div class="row">
               
               @include('account.sidebar')

               <div class="col-md-9 page-content">
                    <div class="inner-box">
                    <form id="ImageuploadForm" action="" method="POST"  enctype="multipart/form-data">
                                    @csrf
                        <div class="row">
                      
                            <div class="col-md-4 col-xs-4 col-xxs-12">
                                <h3 class="no-padding text-center-480 useradmin">
                                
                                <input style="display:none" name="profile_img" type='file' id="imageUpload" id="profile_img" accept=".png, .jpg, .jpeg" />
                                <label for="imageUpload" class="uload-icon"><i class="fa fa-pencil-alt" ></i></label>
                                <?php 
                                    $user_id = Auth::user()->id;
                                    $userImage = storage_path("/users/$user_id/$user_id.jpg");
                                    if(!file_exists($userImage)) { 
                                        $userImage = "/storage/no-photo-available.png";
                                    } else { 
                                        $userImage = "/storage/users/$user_id/$user_id.jpg";
                                    }
                                ?>
                                <a href="#">
                                    <img class="userImg" id="userImg"  src="{{$userImage}}" alt="user"> {{Auth::user()->name}}
                                </a></h3>
                            </div>
                            
                            <div class="col-md-8 col-xs-8 col-xxs-12">
                                <div class="header-data text-center-xs">
                                    <!-- revenue data -->
                                    <div class="hdata">
                                        <div class="mcol-left">
                                            <!-- Icon with green background -->
                                            <i class="icon-th-thumb ln-shadow"></i></div>
                                        <div class="mcol-right">
                                            <!-- Number of visitors -->
                                            <p><a href="#">{{getCount("posts" , "user_id" , Auth::user()->id)}}</a><em>{{ trans('account.home.ads') }}</em></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <!-- revenue data -->
                                    <div class="hdata">
                                        <div class="mcol-left">
                                            <!-- Icon with blue background -->
                                            <i class="fa fa-user ln-shadow"></i></div>
                                        <div class="mcol-right">
                                            <!-- Number of visitors -->
                                            <p><a href="#">{{getCount("user_favourite_ads" , "user_id" , Auth::user()->id)}}</a> <em>{{ trans('account.home.favorites') }}</em></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        </form>
                    </div>

                    <div class="inner-box">
                        <div class="welcome-msg">
                            <h3 class="page-sub-header2 clearfix no-padding">Hi,  {{Auth::user()->name}} </h3>
                            <span class="page-sub-header-sub small">{{ trans('account.home.logged_in') }} {{Auth::user()->last_loggedin}}</span>
                        </div>
                        <div id="accordion" class="panel-group">
                            <div class="card card-default">
                                <div class="card-header">
                                    <h4 class="card-title"><a href="#collapseB1" aria-expanded="true"  data-bs-toggle="collapse" >{{ trans('account.home.my_details') }} 
                                        </a></h4>
                                </div>
                                <div class="panel-collapse collapse show" id="collapseB1">
                                    <div class="card-body">
                                        <form class="form-horizontal" method="POST" action="{{route('updateProfile')}}" role="form" id="profileForm">
                                            @csrf
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{ trans('account.home.name') }}</label>

                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{ trans('account.home.email') }}</label>

                                                <div class="col-sm-9">
                                                    <input type="email" class="form-control" disabled name="email" placeholder="jhon.deo@example.com" value="{{Auth::user()->email}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="Phone" class="col-sm-3 control-label">{{ trans('account.home.phone')}}</label>

                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="Phone" value="{{$user->phone}}" name="phone" placeholder="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{ trans('account.home.address') }}</label>

                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="{{$user->address}}" name="address" placeholder="..">
                                                </div>
                                            </div>
                                           
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{ trans('account.home.country') }}</label>

                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="{{$user->country}}" name="country" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{ trans('account.home.city') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="{{$user->city}}" name="city" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{ trans('account.home.postcode') }}</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="{{$user->postcode}}"  name="postcode" placeholder="">
                                                </div>
                                            </div>

                                            <div class="form-group hide"> <!-- remove it if dont need this part -->
                                                <label class="col-sm-3 control-label">{{ trans('account.home.facebook_account') }}</label>

                                                <div class="col-sm-9">
                                                    <div class="form-control"><a class="link"  href="">{{ trans('account.home.jhone') }}</a> 
                                                    <a class=""> <i class="fa fa-minus-circle"></i></a></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9"></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    <button type="submit" class="btn btn-default">{{ trans('account.home.update') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-default">
                                <div class="card-header">
                                    <h4 class="card-title"><a href="#collapseB2" aria-expanded="true"  data-bs-toggle="collapse" >{{ trans('account.home.settings') }} </a>
                                    </h4>
                                </div>
                                <div class="panel-collapse collapse" id="collapseB2">
                                    <div class="card-body">
                                        <form class="form-horizontal"  method="POST" action="{{route('updatePassword')}}" role="form" id="userPassword" role="form">
                                            @csrf
                                            <!-- <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox">
                                                            Comments are enabled on my ads </label>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <span class="success" id="failed" style="display:none">{{ trans('account.home.failed') }}</span>
                                            <span class="success" id="success" style="display:none">{{ trans('account.home.success') }}</span>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{ trans('account.home.new_password') }}</label>

                                                <div class="col-sm-9">
                                                    <input type="password" name="password" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">{{ trans('account.home.confirm _password') }}</label>

                                                <div class="col-sm-9">
                                                    <input type="password" name="conf_password" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    <button type="submit" class="btn btn-default">{{ trans('account.home.update') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-default">
                                <div class="card-header">
                                    <h4 class="card-title"><a href="#collapseB3" aria-expanded="true"  data-bs-toggle="collapse" >
                                    {{ trans('account.home.preferences') }}</a></h4>
                                </div>
                                <div class="panel-collapse collapse" id="collapseB3">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox">
                                                        {{ trans('account.home.newsletter') }}</label>
                                                </div>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox">{{ trans('account.home.buying_selling') }}
                                                        </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/.row-box End-->

                    </div>
                </div>


            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </div>


    <script> 
        $(document).ready(function() {
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


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#userImg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        var formData = new FormData($('#ImageuploadForm')[0]);
        readURL(this);
        $.ajax({
            url:"{{ route('uploadUserPhoto') }}",
            method:"POST",
            data: formData,
            contentType: false,
            processData: false,
            success:function(data)
            {
                
            }
        });

        
    });

</script>


@endsection
