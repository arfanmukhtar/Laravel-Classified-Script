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
                                <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <fieldset>
                                        <div class="form-group row required">
                                            <label class="col-md-4 control-label">You are a <sup>*</sup></label>

                                            <div class="col-md-6">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="account_type" id="optionsRadios1"
                                                               value="professional" checked>
                                                        Professional </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="account_type" id="optionsRadios2"
                                                               value="individual">
                                                        Individual </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="form-group  row required">
                                            <label class="col-md-4 control-label"> Name <sup>*</sup></label>

                                            <div class="col-md-6">
                                                <input name="name" placeholder="First Name" class="form-control input-md"
                                                       required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group  row required">
                                            <label for="inputEmail3" class="col-md-4 control-label">Email
                                                <sup>*</sup></label>

                                            <div class="col-md-6">
                                                <input type="email" name="email" class="form-control" id="email"
                                                       placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group  row required">
                                            <label for="password" class="col-md-4 control-label">Password </label>

                                            <div class="col-md-6">
                                                <input type="password" class="form-control" id="password" name="password"
                                                       placeholder="Password">
                                                        <small id="passwordHelpBlock" class="form-text text-muted"> At least 6 characters
                                                        </small>
                                            </div>
                                        </div>
                                        <div class="form-group  row required">
                                            <label for="confirmPassword" class="col-md-4 control-label">Confirm Password </label>

                                            <div class="col-md-6">
                                                <input type="password" name="password_confirmation"  class="form-control" id="confirmPassword" name="password"
                                                       placeholder="Confirm Password">
                                                      
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-4 control-label"></label>

                                            <div class="col-md-8">
                                                <div class="termbox mb10">
                                                    <div class="col-auto my-1 no-padding">
                                                        <div class="custom-control custom-checkbox mr-sm-2">
                                                            <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                                            <label class="custom-control-label" for="customControlAutosizing">  <span class="custom-control-description"> I have read and agree to the <a href="terms-conditions.html">Terms
                                                        & Conditions</a> </span></label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div style="clear:both"></div>
                                                <button type="submit" class="btn btn-primary" >Register</submit></div>
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

