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
                            <input type="hidden" name="token" value="{{ $reset->token }}">
                                 {{csrf_field()}}

                                 @if (Session::has('alert'))
                                <div class="alert alert-danger" data-name="amYMrJFP">
                                    {{ Session::get('alert') }}
                                </div>
                                @endif

                                <div class="form-group">
                                    <label for="sender-email" class="control-label">Email</label>

                                    <div class="input-icon"><i class="icon-user fa"></i>
                                        <input type="email" name="email" value="{{old('email', $reset->email)}}"  required  placeholder="Email"
                                               class="form-control email">
                                    </div>
                                </div>
                                <div class="form-group">
                                <label for="sender-email" class="control-label">Password</label>
                                    <div class="input-icon"><i class="icon-user fa"></i>
                                        <input type="password" name="password"  required  placeholder="Password"
                                               class="form-control email">
                                    </div>
                                </div>
                                <div class="form-group">
                                <label for="sender-email" class="control-label">Confirm Password</label>
                                    <div class="input-icon"><i class="icon-user fa"></i>
                                        <input  type="password" name="password_confirmation" required     placeholder="Confirm Password"
                                               class="form-control email">
                                    </div>
                                </div>
                                
                                 <div class="form-group">
                                    <button type="submit" class="btn btn-primary  btn-block">Update Password</button>
                                </div>

                            </form>
                        </div>
                        
                    </div>
                    <div class="login-box-btm text-center">
                        <p> Have an account? <br>
                            <a href="{{route('login')}}"><strong>Sign In !</strong> </a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.main-container -->

@endsection

