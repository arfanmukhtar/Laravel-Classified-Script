<?php 
      $app_setting = getApplicationSettings();
      $currency_symbol = !empty($app_setting["currency_symbol"]) ? $app_setting["currency_symbol"] : "$";
      $getUserFavorite = array();
      if(!empty($user_id))
        $getUserFavorite = getUserFavorite($user_id);

?>
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
                                                        <?php 
                                                            $heartVal = "";
                                                            if(in_array($post->id , $getUserFavorite)) $heartVal = "active";
                                                        ?>
                                                        <a class="btn btn-primary  btn-sm make-favorite {{$heartVal}}" data-id="{{$post->id}}"> <i class="fa fa-heart"></i></a>
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

@if($total_count > 0)
    <script> 
        $(function() {
            $("#total_count").html(<?php echo $total_count; ?>); 
        });
        
    </script>
@endif