@extends('frontend.appother')

@section('content')
   
<?php 
      $app_setting = getApplicationSettings();
      $currency_symbol = !empty($app_setting["currency_symbol"]) ? $app_setting["currency_symbol"] : "$";
?>

        <?php 
            $image1 = getSetting("search_top_ad");
            $imagePath = "storage/images/advertisements/$image1";
        ?>
        @if(file_exists($imagePath) and !empty($image1))
        <div class="col-xl-12 home add-block">
            <div class="container">
                <div id="">
                    <br>
                    <img src="{{$imagePath}}" alt="Google Add" />
                </div>
            </div>
        </div>
        @endif
   
    <!-- /.search-row -->
    <div class="main-container category-page">

        <div class="container">
            <div class="row ad-block">
                <div class="col-md-12">
                    <div id="cat-ads">
                        <!-- <img src="{{ url('/assets/img/ads.png') }}" alt="List page Ad" style="width:100%; height:auto;" /> -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-heading">{{$title}}</h2>
                    <nav aria-label="breadcrumb" role="navigation" class="pull-left">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ trans('search.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('search') }}">{{ trans('search.used_items') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
                        </ol>
                    </nav>

                    <div class="pull-right backtolist">
                        <div class="search-pagi-info"> <b id="total_count">{{$total_count}}</b> {{ trans('search.results') }}</div>
                    </div>

                </div>
            </div>
            <div class="row">
                <!-- this (.mobile-filter-sidebar) part will be position fixed in mobile version -->
                <div class="col-md-3 page-sidebar mobile-filter-sidebar">
                    <aside>
                        <div class="sidebar-modern-inner accordian">
                            <div class="accordion-group search-filter-heading">
                                <div class="accordion-heading">
                                <a class="accordion-toggle">{{ trans('search.show_results') }}</a>
                                </div>
                            </div>
                            <div class="accordion" id="accordion1">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="searchOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapseOne" aria-expanded="true" aria-controls="searchCollapseOne">
                                        {{ trans('search.search_filters') }}
                                        </button>
                                    </h2>
                                    <div id="searchCollapseOne" class="accordion-collapse collapse show" aria-labelledby="searchOne" data-bs-parent="#accordion1">
                                        <div class="accordion-body">
                                            <div class="accordion-inner clearfix">
                                                <ul class="list-unstyled" id="list-unstyled">
                                                    
                                                </ul>
                                                <a class="clear-filters" href="/search" rel="nofollow">{{ trans('search.clear_all') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="accordion" id="accordion2">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="searchTwo">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapseTwo" aria-expanded="true" aria-controls="searchCollapseTwo">
                                        {{ trans('search.search_keyword') }} 
                                        </button>
                                    </h2>
                                    <div id="searchCollapseTwo" class="accordion-collapse collapse show" aria-labelledby="searchTwo" data-bs-parent="#accordion2">
                                        <div class="accordion-body">
                                            <div class="accordion-inner clearfix">
                                                <form id="search_key_form" action="#" method="GET">
                                                    <input class="pr35 form-control" id="search_input" name="q" @if(!empty($q)) value="{{$q}}" @endif placeholder="e.g. Property, Car, Job" type="text" />
                                                    <input class="btn btn-primary refine-go" type="submit" id="searchInput" value="Go" />
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(!empty($custom_fields))
                            <div class="accordion" id="accordion10">
                                <div class="accordion-item">
                                <h2 class="accordion-header" id="searchTen">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapseTen" aria-expanded="true" aria-controls="searchCollapseTwo">
                                        {{ trans('search.extra_fields') }}
                                        </button>
                                    </h2>
                                    <div id="searchCollapseTen" class="accordion-collapse collapse show" aria-labelledby="searchTen" data-bs-parent="#accordion10">
                                        <div class="accordion-body">
                                            <div class="accordion-inner clearfix">
                                            <form id="search_custom_fields" action="#" method="GET">
                                                
                                                @foreach($custom_fields as $custom_field)
                                                @if($custom_field->type == "dropbox")
                                                <?php 
                                                    $options = json_decode($custom_field->options , true);
                                                ?>
                                                        <label><b>{{$custom_field->name}}</b></label>
                                                   @foreach($options as $option)
                                                    <li> <input data-name="{{$custom_field->name}}" data-id="{{$custom_field->id}}"    type='checkbox' value="{{$option}}" name='{{$custom_field->id}}[]' id="make_{{$custom_field->id}}"><label for="make_{{$custom_field->id}}" class='title text-link'> {{$option}} </label></li> 
                                                    @endforeach
                                               
                                                        
                                                   
                                                    <br>
                                                @endif
                                                @if($custom_field->type == "number")

                                                        <div class="row clearfix">
                                                             <label><b>{{$custom_field->name}}</b></label>
                                                            <div class="form-group col-lg-5 col-md-12 no-padding">
                                                                <input type="text" name="{{$custom_field->id}}[min]" placeholder="From"  class="form-control min{{$custom_field->id}}">
                                                            </div>
                                                            <div class="form-group col-lg-5 col-md-12 no-padding">
                                                                <input type="text" name="{{$custom_field->id}}[max]"  placeholder="To"  class="form-control max{{$custom_field->id}}">
                                                            </div>
                                                            <div class="form-group col-lg-2 col-md-12 no-padding">
                                                                <button class="btn btn-primary btn-sm btn-price-range customFieldSearch" data-id="{{$custom_field->id}}" type="submit">{{ trans('search.go') }}</button>
                                                            </div>
                                                        </div>
                                                        
                                                    <br>
                                                @endif
                                                   
                                                @endforeach
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif


                            <div class="accordion" id="accordion3">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="searchThree">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapseThree" aria-expanded="true" aria-controls="searchCollapseThree">
                                        {{ trans('search.category') }}
                                        </button>
                                    </h2>
                                    <div id="searchCollapseThree" class="accordion-collapse collapse show" aria-labelledby="searchThree" data-bs-parent="#accordion3">
                                        <div class="accordion-body">
                                            <div class="accordion-inner clearfix">
                                                <ul class="list-unstyled">
                                                   
                                                @foreach ($categories as $category)
                                                   @php  $cSelected = '';
                                                    if (in_array($category->id, $category_ids)) {
                                                        $cSelected = 'checked';
                                                    }
                                                    
                                                    @endphp

                                                    @if($childEnd)
                                                    <li> <a href="{{url('search?c=' . $category->slug)}}"> <label for="make_{{$category->id}}" class='title text-link'> {{$category->name}} </label><span class='count'><small>{{$category->counter}} </small></span></a></li>
                                                    @else 
                                                   <li> <input data-name="{{$category->name}}" data-id="{{$category->id}}" class='categoryList'  {{$cSelected}} type='checkbox' value="{{$category->slug}}" name='c' id="make_{{$category->id}}"><label for="make_{{$category->id}}" class='title text-link'> {{$category->name}} </label><span class='count'><small>{{$category->counter}} </small></span></li>
                                                    @endif
                                                @endforeach 
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                           
                            <div class="accordion" id="accordion4">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="searchFour">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapseFour" aria-expanded="true" aria-controls="searchCollapseFour">
                                        {{ trans('search.city') }}
                                        </button>
                                    </h2>
                                    <div id="searchCollapseFour" class="accordion-collapse collapse show" aria-labelledby="searchFour" data-bs-parent="#accordion4">
                                        <div class="accordion-body">
                                            <div class="accordion-inner clearfix">
                                                <ul class="browse-list list-unstyled long-list">
                                                {!! \App\Classes\Search::loadCities($city_ids)!!}
                                                   
                                                </ul>
                                                <a id="citylist-more" href="javascript:;">View More (384)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion" id="accordion6" style="display:none">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="searchFour">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapseFour" aria-expanded="true" aria-controls="searchCollapseFour">
                                        {{ trans('search.areas') }}
                                        </button>
                                    </h2>
                                    <div id="searchCollapseFour" class="accordion-collapse collapse show" aria-labelledby="searchFour" data-bs-parent="#accordion6">
                                        <div class="accordion-body">
                                            <div class="accordion-inner clearfix">
                                                <ul class="browse-list list-unstyled long-list-areas">  
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="accordion" id="accordion5">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="searchFive">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapseFive" aria-expanded="true" aria-controls="searchCollapseFive">
                                        {{ trans('search.price_range') }}
                                        </button>
                                    </h2>
                                    <div id="searchCollapseFive" class="accordion-collapse collapse show" aria-labelledby="searchFive" data-bs-parent="#accordion5">
                                        <div class="accordion-body">
                                            <div class="accordion-inner clearfix">
                                                <form role="form" id="search_price_form" action="#" class="form-inline row">
                                                    <div class="form-group col-lg-5 col-md-12 no-padding">
                                                        <input type="text" placeholder="From" @if(!empty($minPrice)) value="{{$minPrice}}" @endif id="minPrice" class="form-control">
                                                    </div>
                                                    <div class="form-group col-lg-5 col-md-12 no-padding">
                                                        <input type="text" placeholder="To" @if(!empty($maxPrice)) value="{{$maxPrice}}" @endif id="maxPrice" class="form-control">
                                                    </div>
                                                    <div class="form-group col-lg-2 col-md-12 no-padding">
                                                        <button class="btn btn-primary btn-sm btn-price-range" type="submit">{{ trans('search.go') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- <div class="block-content categories-list  list-filter ">
                                <ul class="browse-list list-unstyled ">
                                    <li><a href="#"><strong>{{ trans('search.all_ads') }}</strong> <span class="count">{{ $total_count }}</span></a></li>
                                </ul>
                            </div> -->

                            <div style="clear:both"></div>
                        </div>
                    </aside>
                </div>

                <!--/.page-side-bar-->
                <div class="col-md-9 page-content col-thin-left">

                    <div class="category-list">


                        <div class="listing-filter">
                            <div class="pull-left col-xs-6">
                                <div class="breadcrumb-list">
                                    <a href="#" class="current"> <span> {{ trans('search.sort_by') }}</span></a> 
                                    <select class="form-control dropdown-sm" id="sort_by">
                                        <option value="1">{{ trans('search.relevance') }}</option>
                                        <option @if($sort_by == 2) selected @endif value="2">{{ trans('search.price_low_to_high') }}</option>
                                        <option @if($sort_by == 3) selected @endif value="3">{{ trans('search.price_high_to_low') }}</option>
                                        <option @if($sort_by == 4) selected @endif value="4">{{ trans('search.newest_first') }}</option>
                                        <option @if($sort_by == 5) selected @endif value="5">{{ trans('search.oldest_first') }}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="pull-right col-xs-6 text-right listing-view-action"><span
                                    class="list-view active"><i class="  icon-th"></i></span> <span
                                    class="compact-view"><i class=" icon-th-list  "></i></span> <span
                                    class="grid-view "><i class=" icon-th-large "></i></span></div> -->
                            <div style="clear:both"></div>
                        </div>
                        <!--/.listing-filter-->

                        <!-- Mobile Filter bar-->
                        <div class="mobile-filter-bar col-xl-12">
                            <ul class="list-unstyled list-inline no-margin no-padding">
                                <li class="filter-toggle">
                                    <a class="">
                                        <i class="icon-th-list"></i>
                                        {{ trans('search.filters') }}
                                    </a>
                                </li>
                                <li>
                                    <!-- Short by dropdown -->
                                    <div class="dropdown">
                                        <a data-bs-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                                            {{ trans('search.short_by') }}
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="dropdown-item"><a href="#" rel="nofollow">{{ trans('search.relevance') }}</a></li>
                                            <li class="dropdown-item"><a href="#" rel="nofollow">{{ trans('search.date') }}</a></li>
                                            <li class="dropdown-item"><a href="#" rel="nofollow">{{ trans('search.company') }}</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="menu-overly-mask"></div>
                        <!-- Mobile Filter bar End-->

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="category-list-wrapper row no-margin" id="searchResult">
                                    @foreach($posts as $post)
                                    
                                    <div class="item-list">
                                        <div class="row">
                                            <div class="col-md-3 no-padding photobox is-featured">
                                                @if($post->featured == 1) 
                                                    <span class="feature-list">{{ trans('search.featured') }}</span>
                                                @endif
                                                <div class="add-private-tabimage"> 
                                                    <a href="{{url('detail/' . $post->slug)}}">
                                                        @if(!empty($post->mainPhoto->filename))
                                                        <?php 
                                                            $imagename =  $post->mainPhoto->filename;
                                                            $imagename = str_replace($post->id . "/"  , $post->id . "/resize/" , $imagename);
                                                            $postPhoto =  asset("storage/$imagename");   
                                                        ?>

                                                        <img class="thumbnail no-margin" src="{{$postPhoto}}" alt="img">
                                                        @endif
                                                    </a>
                                                    <!-- <div class="attach-photos">
                                                         <i class="fa fa-picture-o" aria-hidden="true"></i> 15
                                                    </div> -->
                                                </div>
                                            </div>
                                            <!--/.photobox-->
                                            <div class="col-md-6 add-desc-box">
                                                <div class="ads-details">
                                                    <h5 class="add-title"><a href="{{url('detail/' . $post->slug)}}">{{$post->title}} </a></h5>
                                                    <!-- <p>{!!Str::limit($post->description , 60)!!}</p> -->
                                                    @php  
                                                    $catName = "";
                                                    $cityName = "";
                                                    
                                                    @endphp
                                                    @if(!empty($post->category->name))
                                                    @php $catName = ucfirst($post->category->name);@endphp
                                                  
                                                    @endif
                                                    @if(!empty($post->city->name))
                                                    @php $cityName = $post->city->name;@endphp
                                                    @endif
                                                    <div class="city-name"> <span class="item-location">{{$catName}} - <i class="fa fa-map-marker-alt"></i> </span>  {{$cityName}}</div>
                                                    <ul class="list-unstyled search-vehicle-info">
                                                        @include("ads.partials.ads_info" , $post)
                                                    </ul>
                                                    <div class="search-bottom clearfix">
                                                        <div class="pull-left dated">{{ trans('search.updated_about') }} {{time_elapsed_string($post->created_at)}} {{ trans('search.by') }} {{$post->contact_name}}</div>
                                                    </div>
                                                  
                                                   
                                                </div>
                                            </div>
                                            <!--/.add-desc-box-->
                                            <div class="col-md-3 text-right  price-box">
                                                <h2 title="{{$currency_symbol}}{{number_format($post->price)}}"  class="item-price ap-dark-grey"> {{$currency_symbol}}{{humanPrice($post->price)}} </h2>
                                                 <a class="btn btn-primary  btn-sm make-favorite" data-id="{{$post->id}}"> <i class="fa fa-heart"></i><span>&nbsp;{{ trans('search.save') }}</span> </a> 
                                                 <p class="successFavorite{{$post->id}} text-success text-hide">{{ trans('search.success') }}</p>
                                               
                                            </div>
                                            <!--/.add-desc-box-->
                                        </div>

                                    </div>
                                    <!--/.item-list-->
                                    @endforeach


                                    
                                </div>
                            </div>
                            
                            
                        </div>

                    </div>

                     <div class="pagination-bar text-center">
                     <button id="loadMoreButton" class="btn btn-md btn-border btn-primary">{{ trans('search.load_more') }}</button>

                    	<!--<nav aria-label="Page navigation " class="d-inline-b">
                    		<ul class="pagination">

                    			<li class="page-item active"><a class="page-link" href="#">1</a></li>
                    			<li class="page-item"><a class="page-link" href="#">2</a></li>
                    			<li class="page-item"><a class="page-link" href="#">3</a></li>
                    			<li class="page-item"><a class="page-link" href="#">4</a></li>
                    			<li class="page-item"><a class="page-link" href="#">...</a></li>
                    			<li class="page-item">
                    				<a class="page-link" href="#">Next</a>
                    			</li>
                    		</ul>
                    	</nav> -->
                    </div> 
                    <!--/.pagination-bar -->

                    <div class="post-promo text-center">
                        <h2>{{ trans('search.get_anything_for_sell') }}</h2>
                        <h5>{{ trans('search.sell_products_online') }}</h5>
                        <a href="{{ url('post-an-ad') }}" class="btn btn-lg btn-border btn-post btn-danger">{{ trans('search.post_free_ad') }}</a>
                    </div>
                    <!--/.post-promo-->
                </div>
                <!--/.page-content-->

            </div>
        </div>
    </div>
    <!-- /.main-container -->
    <?php  $load_more_count = getSetting("load_more_count"); ?>
    <input type="hidden" id="skip" value="{{$load_more_count}}">
    <input type="hidden" id="loadmore" value="">
 



    <div id="cities-list" class="modal fade" role="dialog" >
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Select a location</h4>
                    <button type="button" class="close" data-dismiss="modal" id="cm">&times;</button>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="align-middle">Locations in <strong>United States</strong></div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-11 col-lg-10">
                        <div class="input-group position-relative d-inline-flex align-items-center">
                            <input type="text" id="modalQuery" name="query" class="form-control input-md" placeholder="Search a location" aria-label="Search a location" value="" autocomplete="off">
                            <span class="input-group-text">
                                <i id="modalQueryClearBtn" class="fa fa-search" style="cursor: pointer;"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-2">
                        <button id="modalQuerySearchBtn" class="btn btn-primary btn-block"> Find </button>
                    </div>
                </div>
                <hr class="hr1" />
                <div class="row">
                    <div class="col-12">
                        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1">
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="#" data-url="" class="cities-list">
                                    All cities
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Alabama
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Alaska
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Arizona
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Arkansas
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    California
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Colorado
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Connecticut
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Arkansas
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    California
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Colorado
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Connecticut
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Arkansas
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    California
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Colorado
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Connecticut
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Arkansas
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    California
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Colorado
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Connecticut
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Arkansas
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    California
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Colorado
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Connecticut
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Arkansas
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    California
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Colorado
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Connecticut
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Arkansas
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    California
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Colorado
                                </a>
                            </div>
                            <div class="col mb-1 list-link list-unstyled px-3">
                                <a href="" data-url="" class="cities-list">
                                    Connecticut
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-12">
                        <ul class="pagination justify-content-center" role="navigation">
        
                            <li class="page-item disabled" aria-disabled="true" aria-label="« Previous">
                                <span class="page-link" aria-hidden="true">‹</span>
                            </li>
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">1</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="" data-url="">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="" rel="next" data-url="" aria-label="Next »">›</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

<script>
  
$(function() { 
    
    $("body").on("click" , ".make-favorite" , function() { 
        $(".loadings").show();
        var post_id = $(this).attr("data-id");
        var form_data = {
            post_id
        };
        $.ajax( {
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
			},
			url: '<?php echo url("ads/make_favorite"); ?>',
			data: form_data,
			success: function ( msg ) {
                $(".successFavorite" + post_id).removeClass("text-hide");
            }, 
            complete: function() { 
                $(".loadings").hide();
            }
        });
    });
});


$(document).ready(function() {
    $("#citylist-more").click(function() {
        $("#cities-list").modal("show");
    });
    $("#cm").click(function() {
        $("#cities-list").modal("hide");
    });
  $('#search_key_form').submit(function(event) {
    event.preventDefault();
    $("#skip").val(0);
    searchFunction();
  });
  $('#search_price_form').submit(function(event) {
    event.preventDefault();
    $("#skip").val(0);
    searchFunction();
  });

  $('.customFieldSearch').click(function(event) {
        event.preventDefault();
        $("#skip").val(0);
        searchFunction();

  });
  $('#sort_by').change(function(event) {
    $("#skip").val(0);
    searchFunction();
  });

  $("body").on("change", ".categoryList" , function() { 
        event.preventDefault();
        $("#skip").val(0);
        searchFunction();
  });


  $("body").on("change", ".locationList" , function() { 
        event.preventDefault();
        $("#skip").val(0);
        searchFunction();
        checkSubAreas();
  });

  $("body").on("change", ".subCategoryList" , function() { 
        event.preventDefault();
        $("#skip").val(0);
        searchFunction();
  });


  $("body").on("change", ".areaList" , function() { 
        event.preventDefault();
        $("#skip").val(0);
        searchFunction();
  });
  
});

$("body").on("click" , ".removeList" , function() { 
    var cType = $(this).attr("data-c");
    var value = $(this).attr("data-id");
    
    if(cType == "categoryList")
        $("#make_" + value).click();
    if(cType == "locationList")
        $("#city" + value).click();
    if(cType == "subCategoryList")
        $("#subCat" + value).click();
    if(cType == "areaList")
        $("#area_" + value).click();

    if(cType == "PriceSearch") { 
        $("#minPrice").val("");
        $("#maxPrice").val("");
        searchFunction();
    }
        
});


function searchFunction(type ="new") {
   $(".loadings").show();
    var search = $('#search_input').val();
    var minPrice = $('#minPrice').val();
    var maxPrice = $('#maxPrice').val();
    var sort_by = $('#sort_by').val();
    var categoriesArray = new Array();
    var locationsArray = new Array();
    var subCategoryListArray = new Array();
    var areaListArray = new Array();
    $("#list-unstyled").html("");
    $(".categoryList:checked").each(function () {
        categoriesArray.push(this.value);
        updateFilter($(this).attr('data-name'), "categoryList" , $(this).attr('data-id'));
    });
    $(".locationList:checked").each(function () {
        locationsArray.push(this.value);
        updateFilter($(this).attr('data-name'), "locationList" , $(this).attr('data-id'));
    });
    $(".subCategoryList:checked").each(function () {
        subCategoryListArray.push($(this).attr("data-id"));
        updateFilter($(this).attr('data-name'), "subCategoryList" , $(this).attr('data-id'));
    });
    $(".areaList:checked").each(function () {
        areaListArray.push($(this).attr("data-id"));
        updateFilter($(this).attr('data-name'), "areaList" , $(this).attr('data-id'));
    });
    var categories = "";
    if (categoriesArray.length > 0) {
         categories = categoriesArray.join("/");
    }
    var locations = "";
    if (locationsArray.length > 0) {
        locations = locationsArray.join("/");
    }
    var subcategories = "";
    if (subCategoryListArray.length > 0) {
        subcategories = subCategoryListArray.join("/");
    }
    var subareas = "";
    if (areaListArray.length > 0) {
        subareas = areaListArray.join("/");
    }


    var flag = 0;
    var query = "/search"; 
    if(search != undefined && typeof(search) != 'undefined' &&  search.length > 0) { 
        flag = 1;
        query += "?q=" + encodeURIComponent(search);
    } else { 
        search = "";
    }
   
    if(flag == 1) { 
        if(categories.length > 0) query += "&c=" + encodeURIComponent(categories);
    } else {
        if(categories.length > 0) { 
            flag = 1;
            query += "?c=" + encodeURIComponent(categories);
        } 
    } 
    if(flag == 1) { 
        if(locations.length > 0) query += "&l=" + encodeURIComponent(locations);
    } else { 
        if(locations.length > 0) { 
            flag = 1;
            query += "?l=" + encodeURIComponent(locations);
        } 
    } 
    if(flag == 1) { 
        if(subcategories.length > 0) query += "&sc=" + encodeURIComponent(subcategories);
    } else { 
        if(subcategories.length > 0) { 
            flag = 1;
            query += "?sc=" + encodeURIComponent(subcategories);
        } 
    } 
    if(flag == 1) { 
        if(subareas.length > 0) query += "&la=" + encodeURIComponent(subareas);
    } else { 
        if(subareas.length > 0) { 
            flag = 1;
            query += "?la=" + encodeURIComponent(subareas);
        } 
    } 
    if(flag == 1) { 
        if(minPrice > 0 && maxPrice > 0) {
            query += "&p=" +  minPrice + "_" + maxPrice;
            updateFilter(minPrice + " to " + maxPrice , "PriceSearch" , "priceId");
        } else if(maxPrice > 0) { 
            query += "&p=" +   "0_" + maxPrice;
            updateFilter(maxPrice + " to unlimited" , "PriceSearch" , "priceId");
        } else if(minPrice > 0 ) {
            query += "&p=" +   minPrice +  "_0";
            updateFilter("Less then" + minPrice, "PriceSearch" , "priceId");
        }
    } else {
        if(minPrice > 0 && maxPrice > 0) { 
            flag = 1;
            query += "?p=" +  minPrice + "_" + maxPrice;
            updateFilter(minPrice + " to " + maxPrice , "PriceSearch" , "priceId");
        } else if(maxPrice > 0) { 
            flag = 1;
            query += "?p=" +   "0_" + maxPrice;
            updateFilter(maxPrice + " to unlimited" , "PriceSearch" , "priceId");
        } else if(minPrice > 0) {
            flag = 1;
            query += "?p=" +   minPrice +  "_0";
            updateFilter("Less then" + minPrice, "PriceSearch" , "priceId");
        }
    }
    
    if(flag == 1) {
        var custom_data = $('#search_custom_fields').serialize();
        query += "&custom=" + custom_data;
    } else { 
        var custom_data = $('#search_custom_fields').serialize();
        query += "?custom=" + custom_data;
    }

    if(sort_by > 1) { 
        if(flag == 1 ) { 
            query += "&sort=" + sort_by;
        } else { 
            query += "?sort=" + sort_by;
        }  
    }
    // push search result in url
    history.pushState({}, '', query);
    $.ajax({
      type: 'GET',
      url: "{{url('find')}}",
      data: {
        search: encodeURIComponent(search),
        categories: encodeURIComponent(categories),
        locations: encodeURIComponent(locations),
        subcategories: encodeURIComponent(subcategories),
        subareas: encodeURIComponent(subareas),
        custom_data: custom_data,
        skip: $("#skip").val(),
        minPrice: minPrice,
        maxPrice: maxPrice,
        sort_by: sort_by,
      },
      complete: function() { 
        $(".loadings").hide();
      },
      success: function(html) {
            if(html == "noresult") { 
                if(type == "new") { 
                    $('#searchResult').html("No result found");
                }
                $("#loadMoreButton").hide();
                return false;
            }
            if(type == "new") { 
                $("#loadMoreButton").show();
                $('#searchResult').html(html);
            } else {
                $('#searchResult').append(html);
            }
           
        }
    });
}

  $('#loadMoreButton').click(function() {
        $("#loadmore").val("load");
        var skip = $("#skip").val();
        $("#skip").val(Number(skip) + <?php echo $load_more_count; ?>);
        searchFunction("append");
  });



  function updateFilter(title , type , id) { 
        var html = "<li>";
         html += "&lt; " + title;
         html += '<a href="javascript:;" rel="nofollow">';
         html += '<span class="pull-right removeList" data-c="' +  type + '" data-id="'+ id + '"><i class="fa fa-times-circle"></i></span>';
         html += '</a></li>';
        $("#list-unstyled").append(html);
  }

  $(function() { 
    setTimeout(() => {
        // checkSubCategories(1);
        checkSubAreas(1);
    }, 500);
  })
  
  function checkSubAreas(flag = 0) { 
    var locationsIds = new Array();
   
    if(flag == 0) { 
        $(".locationList:checked").each(function () {
            locationsIds.push($(this).attr("data-id"));
        });
       
    } else {
        locationsIds = "<?php echo json_encode($city_ids); ?>";
    }
    $.ajax({
        type: 'POST',
        url: "{{route('get-sub-areas')}}",
        data: {
            locationsIds: locationsIds
        },
        headers: {
            'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
        },
        success: function(html) {
            if(html != "") { 
                $("#accordion6").show();
                $(".long-list-areas").html(html);
            } else { 
                $("#accordion6").hide();
            }
        }
    });

    
  }



  $("body").on("click", ".item-price" , function() {
        $(this).text($(this).attr("title"));
  });


</script>
@endsection
