@extends('frontend.appother')

@section('content')


 <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-sm-5 login-box">
                    <div class="card card-default">
                    <!-- <span class="logo-icon">
                    <img src="{{url('assets/backend/assets/images/logo-icon.png')}}" </span> -->
                        <div class="card-body">
                            <form role="form" action="{{ route('reset.passw') }}" method="POST">
                                 {{csrf_field()}}
                                <div class="form-group">
                                    <label for="sender-email" class="control-label">:</label>

                                    <div class="input-icon"><i class="icon-user fa"></i>
                                        <input type="email" name="email" :value="old('email')" required  placeholder="Email"
                                               class="form-control email">
                                    </div>
                                </div>
                                
                                 <div class="form-group">
                                    <button type="submit" class="btn btn-primary  btn-block">Submit</button>
                                </div>
                                <h3 class="or-divider"><span>or</span></h3>

                               

                            </form>
                        </div>
                        <div class="card-footer">


                            <p class="text-center pull-right"><a href="{{ route('login') }}"> Already have account? </a>
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

