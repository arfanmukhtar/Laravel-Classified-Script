@extends('frontend.appother')

@section('content')

<div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-8 page-content">
                    <div class="inner-box category-content">
                        <h2 class="title-2"><i class="icon-user-add"></i> Create your account, Its free </h2>

                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form-horizontal" method="POST" action="{{ route('resend.email') }}">
                                    @csrf

                                    @if (Session::has('alert'))
                                    <div class="alert alert-danger" data-name="amYMrJFP">
                                        {{ Session::get('alert') }}
                                    </div>
                                    @endif

                                    @if (Session::has('msg'))
                                    <div class="alert alert-success" data-name="eEneDZzN">
                                        {{ Session::get('msg') }}
                                    </div>
                                    @endif

                                    <div class="alert alert-primary" data-name="amYMrJFP">
                                    Before proceeding with any actions, please ensure that your email is verified. You also have the option to modify your name and email during the verification process.
                                    </div>


                                    <fieldset>
                                    
                                        <div class="form-group  row required">
                                            <label class="col-md-4 control-label"> Name <sup>*</sup></label>

                                            <div class="col-md-6">
                                                <input name="name" value="{{Auth::user()->name}}"  class="form-control input-md"
                                                       required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group  row required">
                                            <label for="inputEmail3"  class="col-md-4 control-label">Email
                                                <sup>*</sup></label>

                                            <div class="col-md-6">
                                                <input type="email" value="{{Auth::user()->email}}" name="email" class="form-control" id="email"
                                                       placeholder="Email">
                                            </div>
                                        </div>
                                       
                                        
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label"></label>

                                            <div class="col-md-8">
                                                <button type="submit" id="resendEmail" class="btn btn-primary">Resend & Verify</button></div>
                                            </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.page-content -->

                <div class="col-md-4 reg-sidebar">
                    <div class="reg-sidebar-inner text-center">
                        <div class="promo-text-box"><i class=" icon-picture fa fa-4x icon-color-1"></i>

                            <h3><strong>Post a Free Classified</strong></h3>

                            <p> Post your free online classified ads with us. Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. </p>
                        </div>
                        <div class="promo-text-box"><i class=" icon-pencil-circled fa fa-4x icon-color-2"></i>

                            <h3><strong>Create and Manage Items</strong></h3>

                            <p> Nam sit amet dui vel orci venenatis ullamcorper eget in lacus.
                                Praesent tristique elit pharetra magna efficitur laoreet.</p>
                        </div>
                        <div class="promo-text-box"><i class="  icon-heart-2 fa fa-4x icon-color-3"></i>

                            <h3><strong>Create your Favorite ads list.</strong></h3>

                            <p> PostNullam quis orci ut ipsum mollis malesuada varius eget metus.
                                Nulla aliquet dui sed quam iaculis, ut finibus massa tincidunt.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.main-container -->

   
    @endsection

