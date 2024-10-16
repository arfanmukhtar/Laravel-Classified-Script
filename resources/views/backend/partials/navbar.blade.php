<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">

<?php $logo = setting_by_key('app_logo'); ?>

<div class="loading" id="loading">
    <div class="loader"></div>
</div>
                  

<nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" width="110" class="" src="{{url('storage/branding/' . $logo)}}" /> <br>
                             </span>
                       
                    </div>
                    <div class="logo-element">
                        
                    </div>
                </li>
				
				 <li @if(Request::segment(1) == "admin" or Request::segment(1) == "dashboard") class="active" @endif><a href="{{ url('admin/dashboard') }}"><i class="fa fa-th-large"></i>  <span class="nav-label">@lang('site.dashboard')</span></a></li>
			
             
              
                <li @if((Request::segment(2) == "types" or Request::segment(2) == "customfields" or Request::segment(2) == "categories" or Request::segment(2) == "listings" or Request::segment(2) == "requested-ads") and Request::segment(1) == "admin") class="active" @endif>
                    <a href="#"><i class="fas fa-poll"></i> <span class="nav-label">@lang('Listings')</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li @if(Request::segment(1) == "admin" and Request::segment(2) == "categories") class="active" @endif><a href="{{ url('admin/categories') }}">@lang('site.categories')</a></li>
                        <li @if(Request::segment(1) == "admin" and Request::segment(2) == "listings") class="active" @endif><a href="{{ url('admin/listings') }}">@lang('Posted Ads')</a></li>
                        <!-- <li @if(Request::segment(1) == "admin" and Request::segment(2) == "types") class="active" @endif><a href="{{ url('admin/types') }}">@lang('Ads Type')</a></li> -->
                        <li @if(Request::segment(1) == "admin" and Request::segment(2) == "customfields") class="active" @endif><a href="{{ url('admin/customfields') }}">@lang('Custom Fields')</a></li>
                        <!-- <li @if(Request::segment(1) == "admin" and Request::segment(2) == "requested-ads") class="active" @endif><a href="{{ url('admin/requested-ads') }}">@lang('Requested Ads')</a></li> -->
                        
                    </ul>
                </li>		

         
                <li @if((Request::segment(2) == "users" )) class="active" @endif>
                    <a href="{{url('admin/users')}}"><i class="fa fa-users"></i> <span class="nav-label"> @lang('Users') </span></a>
                </li>


          


                <li  @if((Request::segment(2) == "staff" or Request::segment(2) == "roles") and Request::segment(1) == "admin") class="active" @endif>
                    <a href="#"><i class="fas fa-people-arrows"></i> <span class="nav-label">Staff & Roles</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li @if(Request::segment(1) == "admin" and Request::segment(2) == "staff") class="active" @endif><a href="{{ url('admin/staff') }}">Staff</a></li>
                        <li @if(Request::segment(1) == "admin" and Request::segment(2) == "roles") class="active" @endif><a href="{{ url('admin/roles') }}">Roles</a></li>  
                    </ul>
                </li>

               
             
               
                <li @if(Request::segment(1) == "admin" and (Request::segment(2) == "settings" and (Request::segment(3) != "profile" AND Request::segment(3) != "countries" AND Request::segment(3) != "home-budget-filters" AND Request::segment(3) != "timezones" AND Request::segment(3) != "cities") AND Request::segment(3) != "currencies" AND Request::segment(3) != "home-videos") )) class="active" @endif>
                   <a href="#"><i class="fa fa-gear"></i> <span class="nav-label"> Settings </span> <span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level collapse">
                       <li @if(Request::segment(2) == "settings" and (Request::segment(3) == "general" )) class="active" @endif><a href="{{ url('admin/settings/general') }}">@lang('Application')</a></li>
                       <li @if(Request::segment(2) == "settings" and (Request::segment(3) == "branding" )) class="active" @endif><a href="{{ url('admin/settings/branding') }}">@lang('Branding')</a></li>
                       <li @if(Request::segment(2) == "settings" and (Request::segment(3) == "payments" )) class="active" @endif><a href="{{ url('admin/settings/payments') }}">@lang('Payments')</a></li>
                       <li @if(Request::segment(2) == "settings" and (Request::segment(3) == "pages" )) class="active" @endif><a href="{{ url('admin/settings/pages') }}">@lang('Pages Meta')</a></li>
                       <li @if(Request::segment(2) == "settings" and (Request::segment(3) == "seo" )) class="active" @endif><a href="{{ url('admin/settings/seo') }}">@lang('SEO')</a></li>
                       <li @if(Request::segment(2) == "settings" and (Request::segment(3) == "advertisements" )) class="active" @endif><a href="{{ url('admin/settings/advertisements') }}">@lang('Advertise')</a></li>
                       <li @if(Request::segment(2) == "settings" and (Request::segment(3) == "pages-views" )) class="active" @endif><a href="{{ url('admin/settings/pages-views') }}">@lang('Pages Views')</a></li>
                       
                   </ul>
               </li>

               <li  @if((Request::segment(3) == "countries" or Request::segment(3) == "timezones") or Request::segment(3) == "currencies" OR Request::segment(3) == "cities") ) class="active" @endif>
                   <a href="#"><i class="fas fa-city"></i> <span class="nav-label">GEO Settings</span> <span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level collapse">
                       <li @if(Request::segment(1) == "admin" and (Request::segment(3) == "countries" OR Request::segment(3) == "cities") ) class="active" @endif><a href="{{ route('countries') }}">Countries</a></li>
                       <li @if(Request::segment(1) == "admin" and Request::segment(3) == "currencies") class="active" @endif><a href="{{ route('currencies') }}">Currencies</a></li>
                       <li @if(Request::segment(1) == "admin" and Request::segment(3) == "timezones") class="active" @endif><a href="{{ route('timezones') }}">Timezones</a></li>
                        
                   </ul>
               </li>


               <li  @if((Request::segment(3) == "home-videos" OR  Request::segment(3) == "home-budget-filters") ) class="active" @endif>
                   <a href="#"><i class="fas fa-city"></i> <span class="nav-label">Other Settings</span> <span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level collapse">
                       <li @if(Request::segment(1) == "admin" and (Request::segment(3) == "home-videos" ) ) class="active" @endif><a href="{{ route('home-videos') }}">Home Videos</a></li>
                       <li @if(Request::segment(1) == "admin" and (Request::segment(3) == "home-budget-filters" ) ) class="active" @endif><a href="{{ route('home-budget-filters') }}">Home Budget Filter</a></li>
                        
                   </ul>
               </li>

               


              

               <li @if((Request::segment(2) == "pages" )) class="active" @endif>
                    <a href="{{url('admin/pages')}}"><i class="fa fa-users"></i> <span class="nav-label"> @lang('Pages') </span></a>
                </li>

               <li  @if((Request::segment(2) == "packages" or Request::segment(2) == "featured-packages") and Request::segment(1) == "admin") class="active" @endif>
                    <a href="#"><i class="fa fa-envelope"></i> <span class="nav-label">Packages</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li @if(Request::segment(1) == "admin" and Request::segment(2) == "packages") class="active" @endif><a href="{{ url('admin/packages') }}">Monthly Packages</a></li>
                        <li @if(Request::segment(1) == "admin" and Request::segment(2) == "featured-packages") class="active" @endif><a href="{{ url('admin/featured-packages') }}">Featured Post</a></li>
                       
                    </ul>
                </li>


         

                <li  @if((Request::segment(2) == "tools" or Request::segment(2) == "backup" or Request::segment(2) == "update") ) class="active" @endif>
                    <a href="#"><i class="fas fa-people-arrows"></i> <span class="nav-label">Tools</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li @if(Request::segment(1) == "admin" and Request::segment(2) == "backups") class="active" @endif><a href="{{ url('admin/tools/backups') }}">Backups</a></li>
                        <li @if(Request::segment(1) == "admin" and Request::segment(2) == "update") class="active" @endif><a href="{{ url('admin/update') }}">Update Script</a></li>
                         
                    </ul>
                </li>


                <li  @if((Request::segment(2) == "map-templates" or Request::segment(2) == "templates") and Request::segment(1) == "admin") class="active" @endif>
                    <a href="#"><i class="fa fa-envelope"></i> <span class="nav-label">Notification Emails</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li @if(Request::segment(1) == "admin" and Request::segment(2) == "templates") class="active" @endif><a href="{{ url('admin/templates') }}">Templates</a></li>
                        <li @if(Request::segment(1) == "admin" and Request::segment(2) == "map-templates") class="active" @endif><a href="{{ url('admin/map-templates') }}">Mapping</a></li>
                       
                    </ul>
                </li>


            
        
				<li @if((Request::segment(3) == "profile" )) class="active" @endif>
                    <a href="{{url('admin/settings/profile')}}"><i class="fa fa-user"></i> <span class="nav-label"> @lang('site.profile') </span></a>
                </li>
				<li @if((Request::segment(2) == "update_menu" )) class="active" @endif>
                    <a href="{{url('admin/update_menu')}}"><i class="fa fa-user"></i> <span class="nav-label"> Main Menu </span></a>
                </li>
            
                <li>
                    <a href="{{ url('clear_cache') }}" target="_blank"><i class="fa fa-eye"></i> <span class="nav-label"> Clear Cache</span></a>
                </li>
                <li>
                    <a class="logoutForm" href="javascript:void(0);"><i class="fas fa-sign-out-alt"></i>  <span class="logoutForm nav-label"> @lang('site.logout') </span></a>
                </li>
                
            </ul>

        </div>
    </nav>



    <form id="logoutForm" method="POST" action="{{url('logout')}}"> 
        @csrf
    </form>

    <script> 
    $("body").on("click", ".logoutForm", function() { 
        $("#logoutForm").submit()
    });
    </script> 
