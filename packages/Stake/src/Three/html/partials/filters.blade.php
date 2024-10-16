<?php 
    if(!empty($filters_list)) { 
        $filters_list = json_decode($filters_list);
        $topLocations = 0; 
        $topCategories = 0; 
        $Budget = 0;
        if(in_array("categories" , $filters_list))  $topCategories = 1; 
        if(in_array("locations" , $filters_list))  $topLocations = 1; 
        if(in_array("budget" , $filters_list))  $Budget = 1; 

    }
?>
    <div class="col-xl-12 content-box container">
                <div class="row row-featured">
                    <div style="clear: both"></div>
                    <div class="tab-lite relative w100">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs " role="tablist">
                           @if($topCategories) 
                        <li role="presentation" class="nav-item"><a href="#tab3" aria-controls="tab3" role="tab"
                                    data-bs-toggle="tab" class="nav-link"><i
                                    class="icon-th-list"></i> Top Categories</a>
                            </li> 
                            @endif
                            <li role="presentation" class="active nav-item"><a href="#tab1" aria-controls="tab1"
                                                                               role="tab" data-bs-toggle="tab"
                                                                               class="nav-link"><i
                                    class="icon-location-2"></i>Top Locations</a>
                            </li>
                            @if($Budget) 
                            <li role="presentation" class="nav-item"><a href="#tab2" aria-controls="tab2" role="tab"
                                                                        data-bs-toggle="tab" class="nav-link"><i
                                    class="icon-search"></i> Filter By Budget </a>
                            </li>
                            @endif
                           
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab1">
                                <div class="col-xl-12 tab-inner scroll xsh-300">
                                    <div class="row">
                                    <?php 
                                         $counts = ceil(count($cities)/4) ;
                                        $i = 0; 
                                    ?>
                                    @foreach($cities as $city)
                                    @if($i == 0)
                                        <ul class="cat-list col-md-3 col-6 col-xxs-12">
                                    @endif

                                    <li><a href="location/{{$city->slug}}">{{$city->name}} <small>({{$city->counter}})</small></a></li>

                                    @php 
                                        $i++;
                                    @endphp
                                    @if($i == $counts)
                                        </ul>
                                    @endif

                                    @php 
                                        if($i == $counts) { 
                                            $i = 0;
                                        }
                                    @endphp

                                    @endforeach
                                        
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab2">
                                <div class="col-xl-12 tab-inner scroll xsh-300">
                                    <div class="row">
                                    <?php 
                                         $counts = ceil(count($budgets)/4) ;
                                        $i = 0; 
                                    ?>
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
                                    
                                    @if($i == 0)
                                        <ul class="cat-list col-md-3 col-6 col-xxs-12">
                                    @endif

                                    <li><a href="location/{{$city->slug}}">
                                    {{$categoryName}} {{$currency_symbol}}{{$budget->price }} {{$cityName}}
                                    </a></li>

                                    @php 
                                        $i++;
                                    @endphp
                                    @if($i == $counts)
                                        </ul>
                                    @endif

                                    @php 
                                        if($i == $counts) { 
                                            $i = 0;
                                        }
                                    @endphp

                                    @endforeach

                                       
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab3">
                                <div class="col-xl-12 tab-inner">
                                   
                                <div class="row">
                                        <?php 
                                            $counts = ceil(count($budgets)/3) ;
                                            $i = 0; 
                                        ?>
                                         @foreach($categories as $category)

                                        <?php 
                                        $categoryPhoto  = "";
                                            if(!empty($category->picture))  { 
                                                $imagename =  $category->picture;
                                                $imagename = str_replace($category->id , $category->id . "/resize" , $imagename);
                                                $categoryPhoto =  asset("storage/$imagename");   
                                            } 
                                        ?>

                                        <div class="col-md-4 col-sm-4 ">
                                            <div class="cat-list">
                                                <h3 class="cat-title"><a href="{{url('category/' . $category->slug)}}">
                                                <img src="{{ $categoryPhoto}}" width="50px" class="img-responsive" alt="img">
                                                    {{$category->name}}  <small>({{$category->counter}})</small> </a>

                                                    <span data-target=".cat-id-{{$category->id}}" aria-expanded="true" data-bs-toggle="collapse"
                                                        class="btn-cat-collapsed collapsed">   <span
                                                            class=" icon-down-open-big"></span> </span>
                                                </h3>
                                                @if($category->hasChildren())
                                                <ul class="cat-collapse  cat-id-{{$category->id}}">
                                                    @foreach($category->children() as $child)
                                                    <li><a href="{{url('category/' . $category->slug)}}">{{$child->name}}</a></li>
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </div>
                                           
                                         
                                        </div>
                                     @endforeach
                                        
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>