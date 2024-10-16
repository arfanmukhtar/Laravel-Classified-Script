@extends('frontend.app')

@section('content')
<?php 
    $app_setting = getApplicationSettings();
    $search_top = !empty($app_setting["home_search"]) ? $app_setting["home_search"] : "";
    $show_home_categories = !empty($app_setting["show_home_categories"]) ? $app_setting["show_home_categories"] : "";
    $show_filters = !empty($app_setting["show_filters"]) ? $app_setting["show_filters"] : "";
    $filters_list = !empty($app_setting["filters_list"]) ? $app_setting["filters_list"] : "";
    $categories_view = !empty($app_setting["categories_view"]) ? $app_setting["categories_view"] : "";
    $show_home_featured = !empty($app_setting["show_home_featured"]) ? $app_setting["show_home_featured"] : "";
    $show_lastest_ads = !empty($app_setting["show_lastest_ads"]) ? $app_setting["show_lastest_ads"] : "";
    $show_home_videos = !empty($app_setting["show_home_videos"]) ? $app_setting["show_home_videos"] : "";
    $currency_symbol = !empty($app_setting["currency_symbol"]) ? $app_setting["currency_symbol"] : "$";
?>
<div class="intro" style="background-image: url(storage/branding/{{$search_top}});">
        <div class="dtable hw100">
            <div class="dtable-cell hw100">
                <div class="container text-center">
                    <h2 class="intro-title animated fadeInDown"> {{ trans('home.classified_items_anywhere') }} </h2>

                    <h3 class="text-white animated fadeInDown">
                    {{ trans('home.find_offer_job') }}
                    </p>
                    <form id="searchform" method="GET" action="search" >
                        <div class="row search-row animated fadeInUp">
                            <div class="col-xl-4 col-sm-4 search-col relative locationicon">
                                <div class="search-col-inner">
                                    <i class="icon-location-2 icon-append"></i>
                                    <div class="search-col-input">
                                        <input type="text" name="l" id="autocomplete-ajax"
                                            class="form-control locinput input-rel searchtag-input has-icon"
                                            placeholder="{{ trans('home.city..') }}" value="">

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-6 search-col relative">
                                <div class="search-col-inner">
                                    <i class="icon-docs icon-append"></i>
                                    <div class="search-col-input">
                                        <input type="text" name="q" id="ads"
                                            class="form-control has-icon"
                                            placeholder="{{ trans('home.looking_for') }}" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-sm-2 search-col">
                                <button id="searchResult" class="btn btn-danger btn-search btn-block"><strong>{{ trans('home.find') }}</strong></button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- /.intro -->

   @php    
   $home_ads_1 = getSetting("home_ads_1");
   $home_ad_1_url = getSetting("home_ad_1_url");
   $home_ad_2_url = getSetting("home_ad_2_url");
   $image1 = getSetting("home_ad_image1");
   $imagePath = "storage/images/advertisements/$image1";
   
   @endphp
   
       
        @if(!empty( $home_ads_1) OR !empty($image1))
        <div class="col-xl-12 home add-block">
            <div class="container">
            @if(!empty($home_ads_1)) 
                {!! $home_ads_1 !!}
            @else 
           
             @if(file_exists( $imagePath))
                <div id="homeadd2" style="text-align:center">
                    <br>
                    <a href="{{$home_ad_1_url}}" target="_blank"><img src="{{$imagePath}}" alt="Home Ad" /></a>
                </div>
             @endif
            @endif

            </div>
        </div>
        @endif


     <div class="main-container">
        @if($show_home_categories != "No")
        <div class="container pt-2">
            @if($categories_view == "Slide")
     
            <ul class="nav nav-tabs mb-3" id="tab-categories" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="make-tab" data-bs-toggle="tab" data-bs-target="#make" type="button" role="tab" aria-controls="make" aria-selected="true">{{ trans('home.by_category') }}</button>
                </li>
                <!-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="model-tab" data-bs-toggle="tab" data-bs-target="#model" type="button" role="tab" aria-controls="model" aria-selected="false">Model</button>
                </li>-->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="budget-tab" data-bs-toggle="tab" data-bs-target="#budget" type="button" role="tab" aria-controls="budget" aria-selected="false">{{ trans('home.budget') }}</button>
                </li>
                <!-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bodytype-tab" data-bs-toggle="tab" data-bs-target="#bodytype" type="button" role="tab" aria-controls="bodytype" aria-selected="false">Body Type</button>
                </li> -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bycity-tab" data-bs-toggle="tab" data-bs-target="#bycity" type="button" role="tab" aria-controls="bycity" aria-selected="false">{{ trans('home.by_city') }}</button>
                </li>
            </ul>
            <div class="tab-content" id="content-categories">
                <div class="tab-pane fade mb-5 show active" id="make" role="tabpanel" aria-labelledby="make-tab">
                    <div class="col-xl-12">
                        <div class="row row-featured row-featured-category owl-carousel" id="news-slider" >
                            @foreach($categories as $category)
                                <div class=" item">
                                    <div class="content-box f-category ">
                                        <a href="{{url('category/' . $category->slug)}}">
                                            <?php 
                                            if(!empty($category->picture))  { 
                                                $imagename =  $category->picture;
                                                $imagename = str_replace($category->id , $category->id . "/resize" , $imagename);
                                                $categoryPhoto =  asset("storage/$imagename");    
                                            ?>
                                            <img src="{{$categoryPhoto}}" class="img-responsive" alt="{!!$category->name!!}" />
                                            <?php } ?>
                                            <h6> {!!$category->name!!} </h6>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade mb-5" id="model" role="tabpanel" aria-labelledby="model-tab">
                    <div class="col-xl-12">
                        <div class="carousel-inner">
                            <ul class="browse-listing row">
                                <li class="col-sm-2">
                                    <a href="/used-cars/corolla" title="Toyota Corolla Cars for sale in Pakistan">
                                    {{ trans('home.corolla') }}
                                    </a>
                                </li>
                                <li class="col-sm-2">
                                    <a href="/used-cars/civic/" title="Honda Civic Cars for sale in Pakistan">
                                    {{ trans('home.civic') }}
                                    </a>
                                </li>
                                <li class="col-sm-2">
                                    <a href="/used-cars/alto/" title="Suzuki Alto Cars for sale in Pakistan">
                                    {{ trans('home.alto') }}
                                    </a>
                                </li>
                                <li class="col-sm-2">
                                    <a href="/used-cars/mehran/" title="Suzuki Mehran Cars for sale in Pakistan">
                                    {{ trans('home.mehran') }}
                                    </a>
                                </li>
                                <li class="col-sm-2">
                                    <a href="/used-cars/city/" title="Cars for sale in City">
                                    {{ trans('home.city') }}
                                    </a>
                                </li>
                                <li class="col-sm-2">
                                    <a href="/used-cars/cultus/" title="Suzuki Cultus Cars for sale in Pakistan">
                                    {{ trans('home.cultus') }}
                                    </a>
                                </li>
                                <li class="col-sm-2">
                                    <a href="/used-cars/wegan-r/" title="Suzuki Wegan R Cars for sale in Pakistan">
                                    {{ trans('home.wegan_r') }}
                                    </a>
                                </li>
                                <li class="col-sm-2">
                                    <a href="/used-cars/vits/" title="Toyota Vitz Cars for sale in Pakistan">
                                    {{ trans('home.vits') }}
                                    </a>
                                </li>
                                <li class="col-sm-2">
                                    <a href="/used-cars/bolan/" title="Suzuki Bolan Cars for sale in Pakistan">
                                    {{ trans('home.bolan') }}
                                    </a>
                                </li>
                                <li class="col-sm-2">
                                    <a href="/used-cars/swift/" title="Suzuki Swift Cars for sale in Pakistan">
                                    {{ trans('home.swift') }}
                                    </a>
                                </li>
                                <li class="col-sm-2">
                                    <a href="/used-cars/yaris/" title="Toyota Yaris Cars for sale in Pakistan">
                                    {{ trans('home.yaris') }}
                                    </a>
                                </li>
                                <li class="col-sm-2">
                                    <a href="/used-cars/hilux/" title="Toyota Hilux Cars for sale in Pakistan">
                                    {{ trans('home.hilux') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade mb-5" id="budget" role="tabpanel" aria-labelledby="budget-tab">
                    <div class="col-xl-12">
                        <div class="carousel-inner scroll">
                            <ul class="browse-listing row">
                                @foreach($budgets as $budget) 
                                @php 
                                    $url = "/search?p=0_" . $budget->price;
                                    $categoryName = "Items under ";
                                    $cityName = "";
                                    if(!empty($budget->category->name)) { 
                                        $url .= "&c=" .  $budget->category->slug;
                                        $categoryName = $budget->category->name . " under";
                                    } 
                                    if(!empty($budget->city->name)) { 
                                        $url .= "&l=" .  $budget->city->slug;
                                        $cityName = "in " . $budget->city->name;
                                    } 
                                    
                                @endphp

                                <li class="col-sm-3">
                                    <a href="{{$url}}" title="Cars under 2 Lakhs in Pakistan">
                                       {{$categoryName}} {{$currency_symbol}}{{humanPrice($budget->price) }} {{$cityName}}
                                    </a>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade mb-5" id="bodytype" role="tabpanel" aria-labelledby="bodytype-tab">
                    <div class="col-xl-12">
                        <div class="row row-featured row-featured-category">
                            <div class="col-xl-2 col-md-3 col-sm-3 col-xs-4">
                                <div class="content-box f-category">
                                <a href="{{url('category/sedan')}}">
                                <img src="{{url('/storage/images/category/sedan.svg')}}" class="img-responsive" alt="Sedan" />
                                    <h6> {{ trans('home.sedan') }} </h6>
                                </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-3 col-sm-3 col-xs-4">
                                <div class="content-box f-category">
                                <a href="{{url('category/hatchback')}}">
                                <img src="{{url('/storage/images/category/hatchback.svg')}}" class="img-responsive" alt="Hatchback" />
                                    <h6> {{ trans('home.hatchback') }} </h6>
                                </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-3 col-sm-3 col-xs-4">
                                <div class="content-box f-category">
                                <a href="{{url('category/convertible')}}">
                                <img src="{{url('/storage/images/category/convertible.svg')}}" class="img-responsive" alt="Convertible" />
                                    <h6> {{ trans('home.convertible') }} </h6>
                                </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-3 col-sm-3 col-xs-4">
                                <div class="content-box f-category">
                                <a href="{{url('category/mini-vehicles')}}">
                                <img src="{{url('/storage/images/category/mini-vehicles.svg')}}" class="img-responsive" alt="Mini Vehicles" />
                                    <h6> {{ trans('home.mini_vehicles') }} </h6>
                                </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-3 col-sm-3 col-xs-4">
                                <div class="content-box f-category">
                                <a href="{{url('category/suv')}}">
                                <img src="{{url('/storage/images/category/suv.svg')}}" class="img-responsive" alt="SUV" />
                                    <h6> {{ trans('home.suv') }} </h6>
                                </a>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-3 col-sm-3 col-xs-4">
                                <div class="content-box f-category">
                                <a href="{{url('category/double-cabin')}}">
                                <img src="{{url('/storage/images/category/double-cabin.svg')}}" class="img-responsive" alt="Double Cabin" />
                                    <h6> {{ trans('home.double_cabin') }} </h6>
                                </a>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="tab-pane fade mb-5" id="bycity" role="tabpanel" aria-labelledby="bycity-tab">
                    <div class="col-xl-12">
                        <div class="carousel-inner scroll">
                            <ul class="browse-listing row">
                                @foreach($cities as $city)
                                <li class="col-sm-2">
                                    <a href="location/{{$city->slug}}" title="Cars for sale in {{$city->name}}">
                                    {{$city->name}} <small>({{$city->counter}})</small>
                                    </a>
                                </li>
                                @endforeach
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div style="clear: both"></div>
            @else 
                @include("posts::partials.home_categories" , compact('categories'))
            @endif
        </div>
        @endif
        @if($show_home_featured != "No")
        <div class="col-xl-12 featured-items-home">
            <h2 class="container home-heading">{{ trans('home.featured_used_cars') }} <b>{{ trans('home.sale') }}</b></h2>
            <div class="container">
                <div class="row row-featured owl-carousel home-items-featured" id="pro-slider" >
                    

                @foreach($featured_posts as $feature)
                    <div class="card">
                        <div class="img-box">
                            <a href="detail/{{$feature->slug}}">
                            @if(!empty($feature->mainPhoto->filename))
                            <?php 
                                 $imagename =  $feature->mainPhoto->filename;
                                 $imagename = str_replace($feature->id . "/" , $feature->id . "/resize/" , $imagename);
                                 $postPhoto =  asset("storage/$imagename");   
                            ?>
                            <img src="{{$postPhoto}}" class="img-responsive" alt="{{$feature->title}}" />
                            @else 
                            <img src="" class="img-responsive" alt="{{$feature->title}}" />
                            @endif
                                
                            </a>
                        </div>
                        <div class="card-content">
                            <h3 class="nomargin truncate nopadding">
                                <a href="detail/{{$feature->slug}}" rel="nofollow">{{$feature->title}}</a>
                            </h3>
                            <div class="generic-green">
                                {{$currency_symbol}}{{humanPrice($feature->price)}}
                            </div>
                            <div class="generic-gray">@if(!empty($feature->city->name)) {{$feature->city->name}} @endif @if(!empty($feature->area->name)), {{$feature->area->name}}@endif</div>
                        </div>
                    </div>
                    @endforeach

                </div>                       
            </div>
                
        </div>
        @endif
        @if($show_filters == "Yes")
        <div class="col-xl-12 featured-items-home home-items">
            @include("posts::partials.filters" , compact('budgets' , 'cities', 'categories' , 'filters_list')) 
        </div>
        @endif
        @if($show_lastest_ads != "No")
        <div class="col-xl-12 featured-items-home ">
            <h2 class="container home-heading">{{ trans('home.new_posted') }} <b>{{ trans('home.cars') }}</b></h2>
            <div class="container">
                <div class="row row-featured owl-carousel home-items-featured" id="pro-slider2" >
                    @foreach($posts as $post)
                    <div class="card">
                        <div class="img-box">
                         <a href="detail/{{$post->slug}}">
                            @if(!empty($post->mainPhoto->filename))
                            <?php 
                                 $imagename =  $post->mainPhoto->filename;
                                 $imagename = str_replace( $post->id . "/" , $post->id . "/resize/" , $imagename);
                                 $postPhoto =  asset("storage/$imagename");   
                            ?>
                                <img src="{{$postPhoto}}" class="img-responsive" alt="{{$post->title}}" />
                                <!-- <img src="{{url('storage/images/Audi1.jpg')}}" class="img-responsive" alt="{{$post->title}}" /> -->
                            @else 
                                <img src="" class="img-responsive" alt="{{$post->title}}" />
                            @endif
                         </a>
                        </div>
                        <div class="card-content">
                            <div class="generic-green home-price">
                                {{$currency_symbol}}{{humanPrice($post->price)}}
                                <!-- <span class="heart active"><i class="fa fa-heart"></i></span> -->
                            </div>
                            <h3 class="nomargin truncate nopadding">
                                <a href="detail/{{$post->slug}}" rel="nofollow">{{$post->title}}</a>
                            </h3>
                            <div class="generic-gray">@if(!empty($post->city->name)) {{$post->city->name}} @endif @if(!empty($post->area->name)), {{$post->area->name}}@endif</div>
                            <div class="generic-gray home-time">{{time_elapsed_string($post->created_at)}} </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>                       
            </div>
        </div>
        @endif
        @if($show_home_videos != "No")
        
        <div class="col-xl-12 featured-items-home home-items">
            <h2 class="container home-heading">{{ trans('home.browse_our') }} <b>{{ trans('home.videos') }}</b></h2>
            <div class="container">
                <div class="row row-featured home-videos" id="" >
                    <div class="col-md-6">
                        <a class="video-box show" href="#">
                        @if(!empty($videos[0])) 
                        <iframe width="100%" height="370" src="{{$videos[0]->link}}" frameborder="0" allowfullscreen></iframe>
                        <!-- <iframe width="100%" height="360" src="{{$videos[0]->link}}" frameborder="0" allowfullscreen></iframe>                   -->
                        @else 
                            <img src="/storage/images/item/video2.jpg" class="video-thumbnail img-responsive" alt="video Block" href="" />
                            <div class="icon-play-video">
                                <i class="fa fa-play"></i>
                            </div>
                        @endif
                            <div class="card-content">
                                <h3 class="nomargin truncate nopadding" itemprop="name">@if(!empty($videos[0])) {{$videos[0]->title}}@endif</h3>
                            </div>
                        </a>                            
                    </div>
                    <div class="col-md-6">
                        <div class="row video-box-small">
                            @foreach($videos as $key => $video)
                            @php if($key == 0) continue; @endphp
                            <div class="col-md-6">
                                <a class="video-box show" href="#">
                                <iframe width="100%" height="160 " src="{{$video->link}}" frameborder="0" allowfullscreen></iframe>
                                    <div class="card-content">
                                        <h3 class="nomargin truncate nopadding" itemprop="name">{{$video->title}}</h3>
                                    </div>
                                </a>                            
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif


       
        @php  
        $home_ads_2 = getSetting("home_ads_2");
        $image1 = getSetting("home_ad_image2");
            $imagePath = "storage/images/advertisements/$image1";
           
        @endphp
       
   

    @if(!empty( $home_ads_2) OR !empty($image1))
        <div class="col-xl-12 home add-block">
            <div class="container">
            @if(!empty($home_ads_2)) 
                {!! $home_ads_2 !!}
            @else 
           
             @if(file_exists( $imagePath))
                <div id="homeadd2" style="text-align:center">
                    <br>
                    <a href="{{$home_ad_2_url}}" target="_blank"><img src="{{$imagePath}}" alt="Footer Ad" /></a>
                </div>
             @endif
            @endif

            </div>
        </div>
        @endif
        




       

    </div>
    <!-- /.main-container -->


<script>
    $("body").on("click", "#searchResult", function() {
        $("#searchform").submit();
        // var city = $("#autocomplete-ajax").val();
        // var search = $("#ads").val();
        // var url = "search"
    });
</script>

<!-- include custom script for site  -->
<script src="{{url('assets/js/main.min.js')}}"></script>

<script src="{{url('assets/plugins/owl-carousel/jquery-1.12.0.min.js')}}"></script>
<script src="{{url('assets/plugins/owl-carousel/owl.carousel.min.js')}}"></script>
<script type="text/javascript">
    $(document).on("ready", function () {
        $("#news-slider").owlCarousel({
            rtl:true,
            //loop:true,
            margin:10,
            //nav:true,
            items : 6,
            itemsDesktop:[1199,6],
            itemsDesktopSmall:[980,3],
            itemsMobile : [640,2],
            //navigation:true,
            navigationText:["",""],
            pagination:true,
            autoPlay:true
        });
        $("#pro-slider").owlCarousel({
            rtl:true,
            //loop:true,
            margin:10,
            //nav:true,
            items : 4,
            itemsDesktop:[1199,6],
            itemsDesktopSmall:[980,3],
            itemsMobile : [640,2],
            //navigation:true,
            navigationText:["",""],
            pagination:true,
            autoPlay:true
        });
        $("#pro-slider2").owlCarousel({
            rtl:true,
            //loop:true,
            margin:10,
            //nav:true,
            items : 4,
            itemsDesktop:[1199,4],
            itemsDesktopSmall:[980,2],
            itemsMobile : [600,2],
            //navigation:true,
            navigationText:["",""],
            pagination:true,
            autoPlay:true
        });
    });
</script>


<script type="text/javascript" src="{{url('assets/plugins/autocomplete/jquery.mockjax.js')}}"></script>
<script type="text/javascript" src="{{url('assets/plugins/autocomplete/jquery.autocomplete.js')}}"></script>
<script> 
    $(function() { 
        'use strict';
        var citiesAarray = <?php echo getCities(); ?>;
            var mapCitiesArray = $.map(citiesAarray, function (value, key) {
            return {value: value, data: key};
        });

        $('#autocomplete-ajax').autocomplete({
            // serviceUrl: '/autosuggest/service/url',
            lookup: mapCitiesArray,
            lookupFilter: function (suggestion, originalQuery, queryLowerCase) {
                var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                return re.test(suggestion.value);
            },
            onSelect: function (suggestion) {
                // $('#selction-ajax').html('You selected: ' + suggestion.value + ', ' + suggestion.data);
            },
            onHint: function (hint) {
                $('#autocomplete-ajax-x').val(hint);

            },
            onInvalidateSelection: function () {
                // $('#selction-ajax').html('You selected: none');
            }
        });



    });
</script>


@endsection
