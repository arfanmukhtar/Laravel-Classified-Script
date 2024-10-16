@extends('frontend.appother')

@section('content')

@php
		$recaptcha_version = getSetting("recaptcha_version");
		$recaptcha_site_key = getSetting("recaptcha_site_key");
	@endphp

    <?php if(!empty($recaptcha_version)) { ?>
			<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<?php } ?>

 <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-sm-5 login-box">
                    <div class="card card-default">
                    <!-- <span class="logo-icon">
                    <img src="{{url('assets/backend/assets/images/logo-icon.png')}}" </span> -->
                        <div class="card-body">
                            <form role="form" action="{{ route('login') }}" method="POST">
                                 {{csrf_field()}}
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

                                <div class="form-group">
                                    <label for="sender-email" class="control-label">Username:</label>

                                    <div class="input-icon"><i class="icon-user fa"></i>
                                        <input id="sender-email" type="email" name="email"  placeholder="Username"
                                               class="form-control email">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="user-pass" class="control-label">Password:</label>

                                    <div class="input-icon"><i class="icon-lock fa"></i>
                                        <input type="password"  name="password" class="form-control" placeholder="Password"
                                               id="user-pass">
                                    </div>
                                </div>


                                <?php if(isset($recaptcha_version) and $recaptcha_version == "v2") { ?>
										<div class="g-recaptcha" 
											data-sitekey="<?php echo $recaptcha_site_key; ?>">
										</div> <br>
									<?php } ?>
									<?php if(isset($recaptcha_version) and $recaptcha_version == "v3") { ?>
                                        <div class="form-group">
                                            <button type="submit" data-sitekey="<?php echo $recaptcha_site_ke; ?>" class="g-recaptcha btn btn-primary  btn-block">Submit</button>
                                        </div>

									<?php } else { ?>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary  btn-block">Submit</button>
                                        </div>
                                    <?php } ?>

                                <h3 class="or-divider"><span>or</span></h3>

                                <div class="button-wrap">
                                    <a href="{{ url('auth/facebook') }}" class="btn-social btn-fbk"><i class="fab fa-facebook-f"></i>facebook<br>connect</a>
                                    <a href="{{ url('auth/google') }}" class="btn-social btn-ggl"><i class="fab fa-google-plus-g"></i>google<br>connect</a>
                                </div>

                            </form>
                        </div>
                        <div class="card-footer">

                            <div class="checkbox pull-left">
                                <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                                    <input type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description"> Keep me logged in</span>
                                </label>
                            </div>


                            <p class="text-center pull-right"><a href="{{ route('password.request') }}"> Lost your password? </a>
                            </p>

                            <div style=" clear:both"></div>
                        </div>
                    </div>
                    <div class="login-box-btm text-center">
                        <p> Don't have an account? <br>
                            <a href="{{route('register')}}"><strong>Sign Up !</strong> </a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.main-container -->

@endsection

