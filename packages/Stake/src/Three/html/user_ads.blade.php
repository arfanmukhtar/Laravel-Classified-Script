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
                    <h2 class="page-heading">{!!$title_page ?? $title!!}</h2>
                    <nav aria-label="breadcrumb" role="navigation" class="pull-left">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ trans('search.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('search') }}">{{ trans('search.used_items') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{!!$title!!}</li>
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

                            <!-- <div class="accordion" id="accordion3">
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

                                                   <li> <input data-name="{{$category->name}}" data-id="{{$category->id}}" class='categoryList'  {{$cSelected}} type='checkbox' value="{{$category->slug}}" name='c' id="make_{{$category->id}}"><label for="make_{{$category->id}}" class='title text-link'> {{$category->name}} </label><span class='count'><small>{{$category->counter}} </small></span></li>
                                                   
                                                @endforeach 
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

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
                                            <div class="col-md-12 no-padding photobox is-featured">
                                                
                                                <!--/.photobox-->
                                                <div class="add-private-tabimage"> 
                                                    @if($post->featured == 1) 
                                                        <span class="feature-list">{{ trans('search.featured') }}</span>
                                                    @endif
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
                                                <!--/.photobox-->

                                                <!--/.add-desc-box-->
                                                <div class="add-desc-box">
                                                    <div class="price-box">
                                                        <h2 title="{{$currency_symbol}}{{number_format($post->price)}}"  class="item-price ap-dark-grey"> {{$currency_symbol}} {{humanPrice($post->price)}} </h2>
                                                        <a class="btn btn-primary  btn-sm make-favorite active" data-id="{{$post->id}}"> <i class="fa fa-heart"></i></a>
                                                    </div>
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
                                                        @if(!empty($post->area->name))
                                                            @php $cityName .= ucfirst($post->area->name) . ", "; @endphp
                                                        @endif
                                                        @if(!empty($post->city->name))
                                                        @php $cityName .= "<b>" . $post->city->name . "</b>"; @endphp
                                                        @endif
                                                        <div class="city-name"> <span class="item-location">{{$catName}} <i class="fa fa-map-marker-alt"></i> </span>  {!!$cityName!!}</div>
                                                        <div class="search-bottom clearfix">
                                                            <div class="pull-left dated">{{ trans('search.updated_about') }} {{time_elapsed_string($post->created_at)}} {{ trans('search.by') }} {{$post->contact_name}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/.add-desc-box-->
                                            </div>
                                            
                                        </div>

                                    </div>
                                    <!--/.item-list-->
                                    @endforeach
                                    
                                </div>
                            </div>
                            
                            
                        </div>

                    </div>

                     <div class="pagination-bar text-center">
                    
                    	<nav aria-label="Page navigation " class="d-inline-b">
                    		<ul class="pagination"> 
                            {!! $posts->appends(request()->input())->links() !!}
                    		</ul>
                    	</nav> 
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
    <input type="hidden" id="skip" value="0">
    <input type="hidden" id="loadmore" value="">
 



@endsection
