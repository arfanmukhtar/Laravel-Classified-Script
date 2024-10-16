@extends('frontend.appother')

@section('content')
<?php 
      $app_setting = getApplicationSettings();
      $currency_symbol = !empty($app_setting["currency_symbol"]) ? $app_setting["currency_symbol"] : "$";
?>
<link rel="stylesheet" href="{{ url('/assets/css/details.css') }}" type="text/css" /> 

<div class="main-container">  

        <div class="container">

            <div class="row ad-block">
                <div class="col-md-12">
                    <div id="cat-ads">
                    <?php 
                        $detail_top_1 = getSetting("detail_top_1");
                        $detail_top_1_link = getSetting("detail_top_1_link");
                        if(empty($detail_top_1)) { 
                            $image1 = getSetting("detail_top_ad");
                            $imagePath = url("storage/images/advertisements/$image1"); ?>
                            @if(!empty($image1))
                                <a href="{{$detail_top_1_link}}" target="_blank">
                                    <img src="{{ $imagePath }}" alt="List page Ad" style="width:100%; height:auto;" />
                                </a>
                            @endif
                    
                    <?php } else {  ?>
                            {{$detail_top_1}}
                        <?php } ?>

                   
                       
                    </div>
                </div>
            </div>
                    
            <div class="row">
                <div class="col-md-12">

                    <nav aria-label="breadcrumb" role="navigation" class="pull-left">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home fa"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ url('search') }}">{{ trans('details.all_ads') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
                        </ol>
                    </nav>

                    <div class="pull-right backtolist">
                        <a onclick="history.back()" href="javascript:void(0);">
                            <i class="fa fa-angle-double-left"></i> {{ trans('details.back_to_results') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                
                <div class="col-md-8 page-content col-thin-right">
                    <div class="inner inner-box ads-details-wrapper">
                        
                        <h2> {{ $post->title }}
                            <!-- <small class="label label-default adlistingtype">{{ trans('details.company_ad') }}</small> -->
                        </h2>
                        <span class="info-row">
                            <span class="date"><i class="icon-clock"></i> {{ time_elapsed_string($post->created_at) }}</span>
                            <span class="item-location"><i class="fa fa-map-marker-alt"></i> {{ $post->city->name }}</span>
                        </span>

                        <div class="item-slider">
                            <h1 class="pricetag">  {{$currency_symbol}}{{ humanPrice($post->price) }}</h1>
                            <ul class="bxslider">
                                @foreach($images as $img)
                                 <?php 
                                    $imagename =  $img->filename;
                                    $postPhoto =  asset("storage/$imagename");   
                                ?>
                                    <li><img src="{{ $postPhoto }}" alt="img" /></li>
                                @endforeach
                            </ul>
                            <div id="bx-pager">
                                @foreach($images as $img)
                                 <?php 
                                    $imagename =  $img->filename;
                                    $imagename = str_replace($post->id . "/" , $post->id . "/resize/" , $imagename);
                                    $postPhoto =  asset("storage/$imagename");   
                                ?>
                                <a class="thumb-item-link" data-slide-index="0" href="javascript:void(0);">
                                    <img src="{{  $postPhoto }}" alt="img" />
                                </a>
                                @endforeach

                               
                            
                            </div>
                        </div>
                        <!--item-slider-->

                        <!-- <table width="100%" class="table table-bordered text-center table-blocks">
                            <tbody>
                                <tr>
                                    <td width="25%">
                                        <span class="engine-icon year"></span>
                                        <p><a href="search?l=&q=2015" title="Year 2015 Cars for sale in Pakistan">2015</a>
                                        </p>
                                    </td>
                                    <td width="25%">
                                        <span class="engine-icon millage"></span>
                                        <p>130,000 km</p>
                                    </td>
                                    <td width="25%">
                                        <span class="engine-icon type"></span>
                                        <p><a href="search?l=&q=Hybrid" title="Hybrid Cars for Sale in Pakistan">Hybrid</a></p>
                                    </td>
                                    <td width="25%">
                                        <span class="engine-icon transmission"></span>
                                        <p><a href="search?l=&q=Automatic" title="Automatic Cars for Sale in Pakistan">Automatic</a></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table> -->

                        <ul class="list-unstyled ul-featured clearfix" id="scroll_car_detail">
                            <li class="ad-data">{{ trans('details.condition') }}</li>
                            <li>{{ucfirst($post->condition)}}</li>
                            <li class="ad-data">{{ trans('details.category') }}</li>
                            <li>{{ucfirst($post->category->name)}}</li>
                            <li class="ad-data">{{ trans('details.city') }}</li>
                            <li>{{ucfirst($post->city->name)}}</li>

                            @if(!empty($post->show_custom_data))
                            <?php $fields = json_decode($post->custom_data , true); ?>
                            @foreach($fields as $key=>$field) 
                            <li class="ad-data">{{$key}}</li>
                            <li>{{$field}}</li>
                            @endforeach
                            @endif

                            <li class="ad-data">{{ trans('details.last_updated') }}</li>
                            <li>{{time_elapsed_string($post->updated_at)}}</li>

                            <li class="ad-data">{{ trans('details.posted_by') }}</li>
                            <li>{{$post->contact_name}}</li>
                        </ul>

                        <!-- <h2 class="ad-detail-heading mt30">Car Features</h2>

                        <ul class="list-unstyled car-feature-list nomargin">
                            <li><i class="icon abs"></i> ABS</li>
                            <li><i class="icon am_fm_radio"></i> AM/FM Radio</li>
                            <li><i class="icon air_bags"></i> Air Bags</li>
                            <li><i class="icon air_conditioning"></i> Air Conditioning</li>
                            <li><i class="icon cd_player"></i> CD Player</li>
                            <li><i class="icon dvd_player"></i> DVD Player</li>
                            <li><i class="icon immobilizer_key"></i> Immobilizer Key</li>
                            <li><i class="icon keyless_entry"></i> Keyless Entry</li>
                            <li><i class="icon power_locks"></i> Power Locks</li>
                            <li><i class="icon power_mirrors"></i> Power Mirrors</li>
                            <li><i class="icon power_steering"></i> Power Steering</li>
                            <li><i class="icon power_windows"></i> Power Windows</li>
                        </ul> -->

                        

                        <div class="Ads-Details ads-details-wrapper">
                            <h2 class="ad-detail-heading mt30">{{ trans('details.seller_comments') }}</h2>

                            <div class="row">
                                <div class="ads-details-info description col-md-12">
                                    {!! $post->description !!}
                                </div>
                                <!-- <div class="col-md-4">
                                    <aside class="panel panel-body panel-details">
                                        <ul>
                                            <li>
                                                <p class="no-margin"><strong>{{ trans('details.price') }}:</strong>
                                                    {{ number_format($post->price) }}
                                                </p>
                                            </li>
                                            <li>
                                                <p class="no-margin"><strong>{{ trans('details.tags') }}:</strong>{{ $post->tags }}</p>
                                            </li>
                                            <li>
                                                <p class="no-margin"><strong>{{ trans('details.location') }}:</strong>
                                                    {{ $post->city }}
                                                </p>
                                            </li>
                                            <li>
                                                <p class="no-margin"><strong>{{ trans('details.condition') }}:</strong>
                                                    {{ trans('details.new') }}
                                                </p>
                                            </li>
                                        </ul>
                                    </aside>
                                    <div class="ads-action">
                                        <ul class="list-border">
                                            <li>
                                                <a href="{{ ('user/' . $post->user_id) }}">
                                                    <i class="fa fa-user"></i> {{ trans('details.more_ads_by_user') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="saveAd">
                                                    <i class="fa fa-heart"></i> {{ trans('details.save_ad') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="shareAd">
                                                    <i class="fa fa-share-alt"></i> {{ trans('details.share_ad') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a data-bs-target="#reportAdvertiser" data-bs-toggle="modal">
                                                    <i class="fa icon-info-circled-alt"></i> {{ trans('details.report_abuse') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>-->
                            </div>
                            <div class="content-footer text-left">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(url('detail/' . $post->slug)); ?>&t=<?php echo urlencode($post->title); ?>" target="_blank"><i class="btn btn-sm btn-primary fab fa-facebook-f"></i></a>
                           <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(url('detail/' . $post->slug)); ?>&text=<?php echo urlencode($post->title); ?>" target="_blank"><i class="btn btn-sm btn-primary fab fa-twitter"></i></a>
                            </div> 
                        </div>
                    </div>
                </div>
                
                <!--/.page-content-->

                <div class="col-md-4  page-sidebar-right">
                <aside>

                    <div class="card card-user-info sidebar-card">
                        <div class="card-content">
                            <div class="unit-orice text-success">{{$currency_symbol}}{{ humanPrice($post->price,2) }}</div>
                            <hr />
                            <div class="card-body text-left">
                                <a class="btn btn-success btn-block btn-price-details number-hide">
                                    <i class="icon-phone-1"></i> 
                                    <span class="c-hide chideR">
                                        <span class="c-nember">{{ substr($post->phone,0,4) }}XXXXXXX</span>
                                        <small id="showPhone" data-phone="{{$post->phone}}">{{ trans('details.phone_number') }}</small>
                                    </span>
                                </a>
                                @if(Auth::user()) 
                                <a class="btn btn-primary btn-block btn-smessage" data-bs-toggle="modal" data-bs-target="#contactAdvertiser">
                                    <i class="icon-mail-2"></i> {{ trans('Send Message') }}
                                </a>
                                @else 
                                <a href="{{url('login')}}" class="btn btn-primary btn-block btn-smessage" >
                                    <i class="icon-mail-2"></i> {{ trans('Send Message') }}
                                </a>
                                @endif
                                
                                {{--<div class="grid-col">
                                    <div class="col from">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ trans('details.location') }}</span>
                                    </div>
                                    <div class="col to">
                                        <span>{{ $post->city }}</span>
                                    </div>
                                </div>
                                <div class="grid-col">
                                    <div class="col from">
                                        <i class="fas fa-user"></i>
                                        <span>{{ trans('details.joined') }}</span>
                                    </div>
                                    <div class="col to">
                                        <span>12 Mar 2015</span>
                                    </div>
                                </div>
                                <div class="grid-col">
                                    <div class="col from">
                                        <i class="fas fa-clock"></i>
                                        <span>{{ trans('details.last_online') }}</span>
                                    </div>
                                    <div class="col to">
                                        <span>{{ trans('details.ago_3_hours') }}</span>
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                    </div>

                    <div class="card card-user-info sidebar-card">
                        <div class="card-content">
                            <div class="card-body text-left">
                                <div class="block-cell user">
                                <?php 
                                    $user_slug = Str::slug( $post->user->id . " " . $post->user->name); 
                                    $user_id = $post->user_id;
                                    $userImage = storage_path("/users/$user_id/$user_id.jpg");
                                    if(!file_exists($userImage)) { 
                                        $userImage = "/storage/no-photo-available.png";
                                    } else { 
                                        $userImage = "/storage/users/$user_id/$user_id.jpg";
                                    }
                                ?>

                                    <div class="cell-media"><img src="{{$userImage}}" alt=""></div>
                                    <div class="cell-content">
                                        <h5 class="title">{{ trans('details.posted_by') }}</h5>
                                        <span class="name"><a href="{{url('user/' . $user_slug)}}">{{ $post->contact_name }}</a></span>
                                        <a href="javascript:void(0);" class="rating followuser" data-id="{{ $post->user_id }}">
                                            {{ trans('details.follow_user') }}
                                        </a>
                                        <br>
                                        <a href="{{url('user/' . $post->user_id . '-' . str_replace(' ' , '-' , strtolower($post->contact_name)))}}">{{ trans('details.more_ads') }} {{ $post->contact_name }} </a>
                                    </div>
                                </div>
                                <ul class="user-verification text-center">
                                    <li class="user-phone">
                                        <i class="fa fa-mobile"></i>
                                        <span class="verified fa fa-check bg-success"></span>
                                    </li>
                                    <li class="user-email">
                                        <i class="fa fa-envelope"></i>
                                        <span class="verified fa fa-check bg-success"></span>
                                    </li>
                                    <li class="user-fb">
                                        <i class="fa fa-user"></i>
                                        <span class="verified fa fa-check bg-success"></span>
                                    </li>
                                </ul>
                                @if(empty($user->facebook_id))
                                <div class="post-side-panel text-center">
                                    <div class="connect-friend">{{ trans('details.friends_seller') }}</div>
                                    <a href="javascript:;" class="connect-social">{{ trans('details.connect_with') }} <strong>{{ trans('details.facebook') }}</strong></a>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>

                   <div class="card sidebar-card">
                        <?php 
                            $detail_top_1 = getSetting("detail_top_2");
                            $detail_top_2_link = getSetting("detail_top_2_link");
                            if(empty($detail_top_1)) { 
                                $image1 = getSetting("detail_right_ad");
                                $imagePath = url("storage/images/advertisements/$image1"); ?>
                                @if(!empty($image1))
                                    <a href="{{$detail_top_2_link}}" target="_blank">
                                        <img src="{{ $imagePath }}" alt="List page Ad" style="width:100%; height:auto;" />
                                    </a>
                                @endif
                        
                        <?php } else {  ?>
                            {{$detail_top_1}}
                        <?php } ?>
                    </div>
                   <!-- <div class="card sidebar-card">
                        <div class="card-header">{{ trans('details.safety_tips') }}</div>
                        <div class="card-content">
                            <div class="card-body text-left">
                                <ul class="list-check">
                                    <li>{{ trans('details.meet_seller_at_public_place') }}</li>
                                    <li>{{ trans('details.check_item_before_buy') }}</li>
                                    <li>{{ trans('details.pay_after_collecting_item') }}</li>
                                </ul>
                                <p>
                                    <a class="float-right" href="#">{{ trans('details.know_more') }}
                                        <i class="fa fa-angle-double-right"></i>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>  -->
                    <!--/.categories-list-->
                    </aside>
                </div>
                <!--/.page-side-bar-->
            </div>
        </div>

        <div class="container">
            <div class="ads-details-wrapper mb-3 mt-3">
                <h2>{{ trans('details.related_ads') }}</h2>
            </div>
            <div class="row">
                @foreach($relatedAds as $relatedAd)
                <div class="col-md-3 col-sm-6">
                    <div class="card mb-3">
                    @php $postPhoto = ""; @endphp
                    @if(!empty($relatedAd->mainPhoto->filename))
                    <?php 
                        $imagename =  $relatedAd->mainPhoto->filename;
                        $imagename = str_replace($relatedAd->id . "/"  , $relatedAd->id . "/resize/" , $imagename);
                        $postPhoto =  asset("storage/$imagename");   
                    ?>
                    @endif
                        <div class="img-box">
                         <a href="{{url('detail/' . $relatedAd->slug)}}">
                            <img src="<?php echo $postPhoto; ?>" class="img-responsive" alt="{{$relatedAd->title}}" />
                         </a>
                        </div>
                        <div class="card-content">
                            <h3 class="nomargin truncate nopadding">
                                <a href="/detail/{{$relatedAd->slug}}" rel="nofollow">{{$relatedAd->title}}</a>
                            </h3>
                            <div class="generic-green">
                            {{$currency_symbol}}{{ humanPrice($relatedAd->price,2) }}
                            </div>
                            <div class="generic-gray">{{$relatedAd->city->name}}</div>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </div>
    <!-- /.main-container -->
    
   
<script>
    $("body").on("click" , ".saveAd" , function() { 
        $(".loadings").hide();
        var post_id = <?php echo $post->id; ?>;
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
               
            },
            complete: function(msg) { 
                $(".loadings").hide();
            }
        });
    });
    $("body").on("click" , ".followuser" , function() { 
        $(".loadings").show();
        var user_id = $(this).attr("data-id");
        var form_data = {
            user_id
        };
        $.ajax( {
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
			},
			url: '<?php echo route("follow-user"); ?>',
			data: form_data,
			success: function ( msg ) {

            },
            complete: function(msg) { 
                $(".loadings").hide();
            }
        });
    });

    $("body").on("click" , "#showPhone" , function() { 
        var phone = $(this).attr("data-phone");
        <?php if(Auth::user()) { ?>
        $(".chideR").removeClass("c-hide");
        $(".c-nember").text(phone);
        <?php } else { ?>
            window.location.href = "<?php  echo url('login'); ?>";
        <?php } ?>

    });
    $("body").on("click" , "#send-message" , function() { 
        var subject = $("#subject").val();
        var message = $("#message").val();
        var post_id = <?php  echo $post->id; ?>;
        var user_id = <?php echo  !empty($post->user_id) ?  $post->user_id : 0; ?>;
        var form_data = {
            user_id,post_id,subject,message
        };
        $.ajax( {
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
			},
			url: '<?php echo route("send-message"); ?>',
			data: form_data,
			success: function ( msg ) {

            }
        });
    });

</script>

<div class="modal fade" id="contactAdvertiser" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class=" icon-mail-2"></i>{{ trans('details.contact_advertiser') }} </h4>

				<button type="button" class="close modal-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span><span
						class="sr-only">{{ trans('details.close') }}</span></button>
			</div>
			<div class="modal-body">
				<form role="form">
					<div class="form-group">
						<label for="subject" class="control-label">{{ trans('details.subject') }}</label>
						<input class="form-control required" name="name" id="subject" type="text" value="{{$post->title}}">
					</div>
					
					
					<div class="form-group">
						<label for="message-text"  class="control-label">{{ trans('details.message') }} <span class="text-count">(300) </span>:</label>
						<textarea class="form-control"  rows="10" name="sender_message" id="message" placeholder="Your message here.."
								  data-placement="top" data-trigger="manual">{{ trans('details.interested_item') }} "{{$post->title}}".{{ trans('details.let_me_know') }} 
{{ trans('details.thanks') }}</textarea>
					</div>
					<div class="form-group">
						<p class="help-block pull-left text-danger hide" id="form-error">&nbsp; {{ trans('details.not_valid') }} </p>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ trans('details.cancel') }}</button>
				<button type="button" class="btn btn-success pull-right" id="send-message">{{ trans('details.send_message') }}</button>
			</div>
		</div>
	</div>
</div>




@endsection
