
<div class="header">
        <nav class="navbar  fixed-top navbar-site navbar-light bg-light navbar-expand-md"
             role="navigation">
            <div class="container-fluid">

                <div class="navbar-identity">

                    <?php $logo = setting_by_key('app_logo'); 
                        $title = setting_by_key('title'); 
                   
                    ?>
                    <a href="{{url('/')}}" class="navbar-brand logo logo-title">
                        <img src="{{url('storage/branding/' . $logo)}}" alt="{{$title}}" class="logo-img" />
                    </a>

                    <button class="navbar-toggler -toggler pull-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsDefault" aria-controls="navbarsDefault" aria-expanded="false" aria-label="Toggle navigation">
                        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 30 30" width="30" height="30"
                             focusable="false"><title>Menu</title>
                            <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-miterlimit="10" d="M4 7h22M4 15h22M4 23h22"/>
                        </svg>
                    </button>

                </div>


                <div class="navbar-collapse collapse" id="navbarsDefault">
                    <ul class="nav navbar-nav me-md-auto navbar-left">
                        {!!mainMenu()!!}
                    </ul>
                    <ul class="nav navbar-nav ml-auto navbar-right">
                        @if(Auth::user())
                        
                        <li class="dropdown no-arrow nav-item">
                            <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="dropdown-nav-01" data-bs-toggle="dropdown" aria-expanded="false">

                            <span class="uname">{{Auth::user()->name}}</span> <i class="fas fa-user-circle fa-lg"></i> <i class=" icon-down-open-big fa"></i></a>
                            <ul
                                    class="dropdown-menu user-menu dropdown-menu-right" aria-labelledby="dropdown01">
                                <li class="@if(Request::segment(2) == 'home') active @endif dropdown-item"><a href="{{route('personal_home')}}"><i class="icon-home"></i>
                                    Personal Home

                                </a>
                                </li>
                                <li class="@if(Request::segment(2) == 'my-ads') active @endif dropdown-item"><a href="{{route('my_ads')}}"><i class="icon-th-thumb"></i> My ads
                                </a>
                                </li>
                                <li class="@if(Request::segment(2) == 'favourite-ads') active @endif dropdown-item"><a href="{{route('favourite_ads')}}"><i class="icon-heart"></i>
                                    Favourite ads </a>
                                </li>
                                <li class="@if(Request::segment(2) == 'saved_search') active @endif dropdown-item"><a href="{{route('saved_search')}}"><i
                                        class="icon-star-circled"></i> Saved search

                                </a>
                                </li>
                                <li class="@if(Request::segment(2) == 'archived_ads') active @endif dropdown-item"><a href="{{route('archived_ads')}}"><i
                                        class="icon-folder-close"></i> Archived ads

                                </a>
                                </li>
                                <li class="@if(Request::segment(2) == 'home') active @endif dropdown-item"><a href="{{route('pending_approval')}}"><i
                                        class="icon-hourglass"></i> Pending  approval </a>
                                </li>
                                <!-- <li class="@if(Request::segment(2) == 'pending_approval') active @endif dropdown-item"><a href="{{route('pending_approval')}}"><i
                                        class="icon-hourglass"></i> Pending  approval </a>
                                </li> -->
                                <!-- <li class="dropdown-item"><a href="{{route('my_ads')}}"><i class=" icon-money "></i> Payment
                                    history </a>
                                </li> -->
                                <li class="dropdown-item"><a class="logoutForm" href="javascript:void(0);"><i class=" icon-logout "></i> Log out </a>
                                </li>
                            </ul>
                        </li>
                        @else
                        <li class="nav-item">
                            <a href="/login" class="nav-link">
                                <svg xmlns="http://www.w3.org/2000/svg" class="login-icon" viewBox="0 0 32.1 32" aria-label="Login"><g data-name="Layer 2"><path d="M15.6 32a101.4 101.4 0 0 1-12.3-.7A3.8 3.8 0 0 1 0 27.2a17.3 17.3 0 0 1 8.7-12.5l.6-.3.5.5a10 10 0 0 0 6.2 2.4h.1a8.7 8.7 0 0 0 6.1-2.4l.5-.5.6.3A17.3 17.3 0 0 1 32 27.1a3.6 3.6 0 0 1-3 4.2h-.3a111 111 0 0 1-12.8.7zM3.4 29.5a103.6 103.6 0 0 0 12.5.7 104.8 104.8 0 0 0 12.5-.7 1.8 1.8 0 0 0 1.6-2 15 15 0 0 0-7.2-10.7 10.7 10.7 0 0 1-6.9 2.4A11.6 11.6 0 0 1 9 16.8a15.2 15.2 0 0 0-7.2 10.6 2 2 0 0 0 1.6 2.1zM16 16.2a8.1 8.1 0 1 1 8-8.1 8 8 0 0 1-8 8.1zm0-14.3a6.2 6.2 0 1 0 6.2 6.2A6.2 6.2 0 0 0 16 1.9z" data-name="Layer 1"></path></g></svg>
                            </a>
                        </li>

                        @endif
                       
                        <!-- <li class="postadd nav-item"><a class="btn btn-block btn-border btn-post btn-danger nav-link" href="{{url('post-an-ad')}}">Post Free Add</a>
                        </li>
                        <li class="postadd nav-item"><a class="btn btn-block   btn-border btn-post btn-success nav-link" href="{{url('post-a-request')}}">Post a Request</a>
                        </li> -->
                        <li class="postadd nav-item">
                            <a href="{{url('post-an-ad')}}" class="btn btn-block btn-border btn-post btn-danger nav-link" title="Post an Ad"> Post an Ad 
                                <!-- <i class="fa fa-caret-down"></i> -->
                            </a>            
                            <!-- <ul class="dropdown-menu">
                                <li>
                                    <a href="{{url('post-an-ad')}}" class="nav-link" title="">
                                    <strong>Post Free Add</strong>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('post-a-request')}}" class="nav-link" title="">
                                    <strong>Post a Request</strong>
                                    </a>
                                </li>
                            </ul> -->
                        </li>
                       
                    </ul>

                  

                </div>
                <!--/.nav-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    </div>
    <!-- /.header -->

        <form id="logoutForm" method="POST" action="{{url('logout')}}"> 
            @csrf
        </form>

        <script> 
        $("body").on("click", ".logoutForm", function() { 
            $("#logoutForm").submit()
        });
        </script> 