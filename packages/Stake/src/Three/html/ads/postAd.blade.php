@extends('frontend.appother')

@section('content')
<?php 
      $app_setting = getApplicationSettings();
      $currency_symbol = !empty($app_setting["currency_symbol"]) ? $app_setting["currency_symbol"] : "$";
?>
<link href="/assets/css/select2.min.css" rel="stylesheet" />
<style>
.form-horizontal .col-form-label {
    line-height: 26px;
}    
.form-check-input[type=radio] {
    margin-top: 6px;
    width: 16px;
    height: 16px;
}
.well {
    padding: 10px;
}
.well h1 {
    margin: 0 !important;
    font-family: "Lato",Sans-Serif;
    font-weight: 600;
    font-size: 28px;
    padding: 0 !important;
}
.well p.fs16 {
    font-size: 16px;
    line-height: 1.6;
    color: #070707;
}
.sell-header-list {
    margin: 20px 0;
}
.sell-header-list img {
    margin-top: 0;
    margin-right: 5px;
    margin-bottom: 0;
    margin-left: 15px;
    height: 60px;
}
.cat-block {
    cursor: pointer;
    font-family: "Lato", sans-serif;
    display: block;
    width: 100%;
    height: 42px;
    padding: 0.5rem 0.75rem;
    font-size: 14px;
    line-height: 23px;
    color: #464a4c;
    background-color: #fff !important;
    background-image: none;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.25);
    border-radius: 2px;
    -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    -moz-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    -o-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
}
.cat-block:hover {
    border-color: #518ecb !important;
    box-shadow: -1px 1px 5px 0 rgba(8,197,82,0.2);
}
.cat-block:focus {
    color: #212529;
    background-color: #fff;
    border-color: #86b7fe;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}
button#model-done {
    padding: 7px 40px;
    border-radius: 6px;
}
#modal-categories .modal-body .form-group {
    padding: 25px 10px 15px;
    border-right: 1px solid #e0e0e0;
    height: 400px;
    font-size: 14px;
}
#modal-categories .modal-body .form-group ul.get-listing {
    max-height: 360px;
    overflow-x: hidden;
}
#modal-categories .modal-body {
    padding: 0;
    max-height: 510px;
    overflow: hidden;
    background-color: #f0f0f0;
    border-radius: 0;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
}

#modal-categories .modal-body .cat-selection {
    padding-left: 0 !important;
    padding-right: 0 !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    display: block;
}

#modal-categories .modal-body .header-car-info {
    padding-top: 0;
    padding-right: 20px;
    padding-bottom: 0;
    padding-left: 50px;
    border-radius: 0px;
    border-top-left-radius: 6px;
    border-top-right-radius: 6px;
    line-height: 60px;
    border-bottom: 1px solid #e0e0e0;
    font-size: 16px;
    font-weight: bold;
    color: #434343;
    text-transform: uppercase;
    position: relative;
}

#modal-categories .modal-body .active .header-car-info {
    color: #518ecb;
}

#modal-categories .modal-body .header-car-info.arrow-right:before {
    border-bottom: 30px solid transparent;
    border-left: 30px solid #e0e0e0;
    border-top: 30px solid transparent;
    content: "";
    display: inline-block;
    right: -30px;
    position: absolute;
    top: 0px;
    -moz-transform: scale(0.9999);
    z-index: 1;
}
#modal-categories .modal-body .header-car-info.arrow-right:after {
    border-bottom: 30px solid transparent;
    border-left: 30px solid #f0f0f0;
    border-top: 30px solid transparent;
    content: "";
    display: inline-block;
    right: -28px;
    position: absolute;
    top: 0px;
    -moz-transform: scale(0.9999);
    z-index: 2;
}
#modal-categories .modal-body .row .col-md-4:first-child .header-car-info {
    padding-left: 20px;
}

#modal-categories .modal-body .form-group ul.get-listing li h4 {
    color: #434343 !important;
    margin: 30px 0 0px;
    padding-left: 9px;
    font-weight: 500;
    padding-bottom: 8px;
}

#modal-categories .modal-body .form-group ul.get-listing li.heading:first-child h4 {
    margin-top:0;
}

#modal-categories .modal-body .form-group ul.get-listing li a 
{
    padding: 6px 8px;
    margin-right: 5px;
    cursor: pointer;
    border: 1px solid transparent;
    display: block;
    color: #434343;
    line-height:28px;
}
#modal-categories .modal-body .form-group ul.get-listing li a:hover,
#modal-categories .modal-body .form-group ul.get-listing li.current a {
    color: #518ecb;
    background-color: #EAF0FF;
    border: 1px solid #d1deff;
}

.car-make-logo {
    display: inline-block;
    width: 40px;
    height: 40px;
    background: url(/assets/img/brands.png) no-repeat 0 -480px;
    vertical-align: -9px;
    margin-top: -6px;
    margin-right: 0;
    margin-bottom: -6px;
    margin-left: -6px;
}
.car-make-logo.toyota {
    background-position: 0 -40px;
}
.car-make-logo.suzuki {
    background-position: 0 -80px;
}
.car-make-logo.honda {
    background-position: 0 0;
}
.car-make-logo.daihatsu {
    background-position: 0 -120px;
}
.car-make-logo.adam {
    background-position: 0 -920px;
}
.car-make-logo.alfa-romeo {
    background-position: 0 -3160px;
}
.car-make-logo.audi {
    background-position: 0 -160px;
}
.car-make-logo.austin {
    background-position: 0 -3120px;
}
.car-make-logo.bentley {
    background-position: 0 -3080px;
}
.car-make-logo.bmw {
    background-position: 0 -240px;
}
.car-make-logo.buick {
    background-position: 0 -3040px;
}
.car-make-logo.cadillac {
    background-position: 0 -3000px;
}
.car-make-logo.changan {
    background-position: 0 -400px;
}
.car-make-logo.chery {
    background-position: 0 -2960px;
}
.car-make-logo.chevrolet {
    background-position: 0 -680px;
}
.car-make-logo.chrysler {
    background-position: 0 -2920px;
}
.car-make-logo.citroen {
    background-position: 0 -2880px;
}
.car-make-logo.classic-cars {
    background-position: 0 -2840px;
}
.car-make-logo.daewoo {
    background-position: 0 -600px;
}
.car-make-logo.daimler {
    background-position: 0 -2800px;
}
.car-make-logo.datsun {
    background-position: 0 -960px;
}
.car-make-logo.dfsk {
    background-position: 0 -360px;
}
.car-make-logo.dodge {
    background-position: 0 -2760px;
}
.car-make-logo.faw, .car-make-logo.roma {
    background-position: 0 -440px;
}
#modal-categories .modal-body .active {
    background-color: #fff;
}
#modal-categories .modal-body .active .header-car-info.arrow-right::after {
    border-left-color: #fff;
}
#modal-categories .modal-body .cat-selection:first-child .header-car-info {
    padding-left: 20px !important;
}

#modal-categories .modal-body .form-group ul.get-listing li a .fa-angle-right {
    color: #518ecb;
    float: right;
    font-size: 18px;
    display: inline-block;
    line-height: 29px;
}
.fs12 {
    font-size: 12px;
}
.version a .fs12 {
    line-height: 1;
}
.cat-block.inner-success {
    background-color: #dff0d8 !important;
    border-color: #3eb549 !important;
    color: #3eb549;
}
</style>

<!-- <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script> -->
<script type="text/javascript">

// $(function(){
//     var $ckfield = CKEDITOR.replace( 'description' );

//     $ckfield.on('change', function() {
//       $ckfield.updateElement();         
//     });
// });
</script>

    <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12 page-content">
                    <div class="inner-box category-content">
                        <div class="well text-center p30 fwl">
                            <h1 class="nomargin fs28 fwb">
                                Sell your Item With Easy &amp; Simple Steps!
                            </h1>
                            <p class="fs16">{{trans('ads.post_ad.less_minute')}}</p>
                            <div class="sell-header-list">
                                <img alt=" Enter Your Car Information" src="/assets/img/car.svg"> Enter Your Item Information
                                <img alt=" Upload Photos" src="/assets/img/photo.svg"> Upload Photos
                                <img alt=" Enter Your Selling Price" src="/assets/img/tag.svg"> Enter Your Selling Price
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 page-content">
                    <div class="inner-box category-content">
                        <h2 class="title-2 uppercase">
                            <strong> <i class="icon-docs"></i>{{trans('ads.post_ad.post_a_free_ad') }}</strong>
                        </h2>
                        <div class="row">
                            <div class="col-sm-12">

                                <form id="postAnAd"  method="POST" class="form-horizontal form-post-ads" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <!-- <div class="form-group row">
                                        <label  class="col-sm-2 col-form-label">Model Year</label>
                                        <div class="col-sm-8">
                                            <select name="city_id" id="city_id" class="form-control">
                                                <option value="">Select Year</option>
                                                <option value="1">2023</option>
                                                <option value="2">2022</option>
                                                <option value="3">2021</option>
                                                <option value="4">2020</option>
                                                <option value="5">2019</option>
                                                <option value="6">2018</option>
                                            </select>
                                        </div>
                                    </div> -->

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="seller-city">{{trans('ads.post_ad.city') }}</label>

                                        <div class="col-sm-8">
                                            <!-- <div id="location-block" class="location-block">Select Location</div> -->
                                            <!-- <input type="hidden" value="" name="city_id" id="city_id" > -->
                                            <select id="seller-city" name="city_id" class="select2 form-control">
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}" @if($city->name == "Lahore") selected @endif>{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="seller-area">{{trans('ads.post_ad.city_area') }}</label>

                                        <div class="col-sm-8">
                                            <select id="seller-area" name="area_id" class="select2 form-control">
                                              
                                            </select>
                                        </div>
                                    </div>

                                    @if($childerns)
                                    <div class="form-group row">
                                        <label  class="col-sm-2 col-form-label">{{trans('ads.post_ad.category') }}</label>
                                        <div class="col-sm-8">
                                            <div id="cat-block" class="cat-block">{{trans('ads.post_ad.select_category') }}</div>
                                            <input type="hidden" value="" name="category_id" id="category_id" >
                                           
                                        </div>
                                    </div>

                                    @else 
                                    <div class="form-group row">
                                        <label  class="col-sm-2 col-form-label">{{trans('ads.post_ad.category') }}</label>
                                        <div class="col-sm-8">
                                           <select name="category_id" id="category_id" class="select2 form-control">
                                                <option value="">{{trans('ads.post_ad.select_category') }}</option>
                                                @foreach($categories as $cat)
                                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                @endforeach
                                            </select> 
                                        </div>
                                    </div>

                                    @endif
                                   
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">{{trans('ads.post_ad.condition') }}</label>
                                        <div class="col-sm-8">
                                            <label class="form-check form-check-inline col-form-label">
                                                <label class="form-check-label mb-0 pb-0">
                                                    <input class="form-check-input" type="radio"  name="condition" id="inlineRadio1" value="1">{{trans('ads.post_ad.new') }}
                                                </label>
                                            </label>
                                            <label class="form-check form-check-inline col-form-label">
                                                <label class="form-check-label mb-0 pb-0">
                                                    <input class="form-check-input" type="radio" checked name="condition" id="inlineRadio2" value="2">{{trans('ads.post_ad.used') }}
                                                </label>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-sm-2 col-form-label">{{trans('ads.post_ad.ad_title') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="title" id="Adtitle" placeholder="Ad title">
                                            <small id="" class="form-text text-muted">
                                                A great title needs at least 30 characters
                                            </small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label  class="col-sm-2 col-form-label">{{trans('ads.post_ad.describe_ad') }}</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="description" name="description" style="height: 120px;" rows="10"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label  class="col-sm-2 col-form-label">{{trans('ads.post_ad.price') }}</label>

                                        <div class="col-sm-8">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">{{$currency_symbol}}</span>
                                                <input type="text" name="sale_price" class="form-control" aria-label="Sale price of item">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>


                                        <div class="col-sm-2">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" name="negotiable" type="checkbox"> {{trans('ads.post_ad.negotiable') }}
                                                </label>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="textarea">{{trans('ads.post_ad.picture') }}</label>
                                        <div class="col-lg-8">
                                            @php 
                                            $post_photo_limit = getSetting("post_photo_limit");
                                            $post_photo_limit  = !empty($post_photo_limit) ? $post_photo_limit  : 5;
                                            @endphp
                                            @for($i = 1; $i <= $post_photo_limit; $i++)
                                            <div class="mb10">
                                                <input id="input-upload-img{{$i}}" name="file{{$i}}" type="file" class="file" data-preview-file-type="text">
                                            </div>
                                            @endfor
                                           
                                            <p  class="form-text text-muted">
                                                Add up to {{$post_photo_limit}} photos. Use a real image of your product, not catalogs
                                            </p>
                                        </div>
                                    </div>

                                    <div id="customFields">

                                    </div>


                                    <div class="content-subheading"><i class="icon-user fa"></i> <strong>{{trans('ads.post_ad.seller_information') }}
                                        </strong></div>

                                    <!-- Text input-->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="seller_name">{{trans('ads.post_ad.name') }}</label>

                                        <div class="col-sm-8">
                                            <input id="seller_name" name="seller_name"
                                                   placeholder="Seller Name" value="{{Auth::user()->name}}" class="form-control input-md"
                                                   required="" type="text">
                                        </div>
                                    </div>

                                    <!-- Appended checkbox -->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="seller_email">{{trans('ads.post_ad.seller_email') }} </label>

                                        <div class="col-sm-8">
                                            <input id="seller_email" name="seller_email" class="form-control"
                                                   placeholder="Email" value="{{Auth::user()->email}}"  required="" type="text">
                                                   <!-- <div class="checkbox">
                                                        <label>
                                                            <small>Your Ad will show after click on confirmation link that you will receive in your email.</small>
                                                        </label>
                                                    </div> -->
                                           
                                        </div>
                                    </div>

                                    <!-- Text input-->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="seller_number">{{trans('ads.post_ad.phone_number') }}</label>

                                        <div class="col-sm-8">
                                            <input id="seller_number" name="seller_number"
                                                   placeholder="Phone Number" value="{{Auth::user()->phone}}" class="form-control input-md"
                                                   required="" type="text">
                                                   <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="hidePhone" value="">
                                                    <small>{{trans('ads.post_ad.hide_number_on_ads') }}</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- terms -->
                                    <!-- <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"></label>
                                        <div class="col-md-8">
                                            <div class="card bg-light card-body">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="createAccount" class="custom-control-input" id="createAccount">
                                                    <label class="custom-control-label" for="customCheck1">Create account with above information</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                            

                                    <!-- Button  -->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"></label>
                                        
                                    <div class="col-sm-8">
                                        <button type="submit" name="submit"id="PostNow" class="btn btn-success">{{trans('ads.post_ad.post_now') }}</button>
                                    </div>
                                        <!-- <button type="button"  id="button1id"
                                                                 class="btn btn-success btn-lg">Submit</button></div> -->
                                    </div>

                                    <div id="showError"> </div>


                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.page-content -->

                <div class="col-md-3 reg-sidebar" style="display:none">
                    <div class="reg-sidebar-inner text-center">
                        <div class="promo-text-box"><i class=" icon-picture fa fa-4x icon-color-1"></i>

                            <h3><strong>{{trans('ads.post_ad.post_free_classified') }}</strong></h3>
                            <p> Post your free online auto classified ads with us. It will help you sale your products and parts.  </p>
                        </div>

                        <div class="card sidebar-card">
                            <div class="card-header uppercase">
                                <small><strong>{{trans('ads.post_ad.sell_quickly') }}</strong></small>
                            </div>
                            <div class="card-content">
                                <div class="card-body text-left">
                                    <ul class="list-check">
                                        <li> Use a brief title and description of the item</li>
                                        <li> Make sure you post in the correct category</li>
                                        <li> Add nice photos to your ad</li>
                                        <li> Put a reasonable price</li>
                                        <li> Check the item before publish</li>

                                    </ul>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <!--/.reg-sidebar-->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.main-container -->


    

<div class="modal fade" id="modal-categories" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<!-- <div class="modal-header">
				<h4 class="modal-title"><i class=" icon-mail-2"></i> Select Category </h4>
				<button type="button" class="close modal-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</div> -->
			<div class="modal-body">

                <div class="col-md-4 cat-selection makes pull-left active">
                    <div class="header-car-info arrow-right">{{trans('ads.post_ad.parent') }}</div>
                    <div class="form-group nomargin">
                        <ul class="fs14 get-listing make-listings">

                            <!-- <li class="heading"><h4>Popular</h4></li> -->
                             @php $categories = getParentCategories(); @endphp
                             @foreach($categories as $category)
                            <li class="make" data-id="{{$category->id}}" data-name="{{$category->name}}" id="make_{{$category->id}}">
                                <a href="javascript:;">
                                        <?php 
                                        if(!empty($category->picture))  { 
                                            $imagename =  $category->picture;
                                            $imagename = str_replace($category->id , $category->id . "/resize" , $imagename);
                                            $categoryPhoto =  asset("storage/$imagename");    
                                        ?>
                                        <span><img  src="{{$categoryPhoto}}" width="30px"></span>
                                        <?php } ?>
                                    {{$category->name}} 
                                    @if ($category->children->count())<i class="fa fa-angle-right"></i> @endif
                                </a>
                            </li>
                            @endforeach
                           
                            <!-- <li class="heading"><h4>Others</h4></li> 

                           
                            <li class="make" data-make="93" id="make_93">
                            <a href="javascript:;">
                                <span class="car-make-logo faw"></span>FAW <i class="fa fa-angle-right"></i>
                            </a>
                            </li>-->
                           
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 cat-selection models pull-left">
                    <div class="header-car-info arrow-right"></div>
                    <div class="form-group nomargin">
                        <ul class="model-listings fs14 get-listing hide ">
                           
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 cat-selection versions pull-left">
                    <div class="header-car-info arrow-right"></div>
                    <div class="form-group nomargin version-listings-outer">
                        <ul class="get-listing version-listings hide">
                            <!-- <li class="heading">
                                <h4>2019 - 2023</h4></li>
                            <li class="version" version_id="14" id="version_14" generation_id="640" is_active="true"><a href="javascript:;"><strong>VX</strong><div class="fs12">658cc, Manual, Petrol</div></a></li>
                            <li class="version" version_id="15" id="version_15" generation_id="640" is_active="true"><a href="javascript:;"><strong>VXR</strong><div class="fs12">658cc, Manual, Petrol</div></a></li>
                            <li class="version" version_id="3268" id="version_3268" generation_id="640" is_active="true"><a href="javascript:;"><strong>VXL AGS</strong><div class="fs12">658cc, Automatic, Petrol</div></a></li>
                            <li class="version" version_id="3738" id="version_3738" generation_id="640" is_active="true"><a href="javascript:;"><strong>VXR AGS</strong><div class="fs12">658cc, Automatic, Petrol</div></a></li> -->
                        </ul>
                    </div>
                </div>

			</div>
			<div class="modal-footer justify-content-center">
				<!-- <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button> -->
				<button type="button" class="btn btn-primary disabled"  data-bs-dismiss="modal" id="model-done">{{trans('ads.post_ad.done') }}</button>
			</div>
		</div>
	</div>
</div>

<!-- include jquery file upload plugin  -->
<script src="assets/js/fileinput.min.js" type="text/javascript"></script>
<script src="/assets/js/select2.min.js"></script>
<script>

  $(function() { 
    $("#seller-city").change();
  });
    

    $("body").on("change" , "#seller-city", function() { 
        var form_data = {
            city_id: $(this).val()
        }
        $.ajax({
            url: "{{ route('ad-city-areas') }}",
            type: 'POST',
            data: form_data,
            headers: {
                'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            },
            beforeSend: function () {
                $(".blockUI").show();
            },
            complete: function () {
                $(".blockUI").hide();
            },
            success: function(html) {
                $("#seller-area").html(html);
            }
        });
    });
    $("body").on("change" , "#category_id", function() { 
        var form_data = {
            category_id: $("#category_id").val()
        }
        $.ajax({
            url: "{{ route('get-custom-fields') }}",
            type: 'POST',
            data: form_data,
            headers: {
                'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
            },
            beforeSend: function () {
                $(".blockUI").show();
            },
            complete: function () {
                $(".blockUI").hide();
            },
            success: function(html) {
                $("#customFields").html(html);
            }
        });
    });

    // initialize with defaults
    <?php for($i = 1; $i <= $post_photo_limit; $i++) {?>
        $("#input-upload-img<?php echo $i; ?>").fileinput();
    <?php } ?>

    $(document).ready(function(){
        $(".select2").select2();

        $("#cat-block").click(function() {
            $("#modal-categories").modal("show");
        });
        $("#location-block").click(function() {
            $("#modal-locations").modal("show");
        });

        $("li.make").click(function() {
            var makeList = $(this);
            var id = $(this).attr("data-id");
            var text = $(this).attr("data-name");
            $(".cat-block").text(text);
           
            $("#category_id").val(id);
            $.ajax({
                url: "{{ url('get-child-categories') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: {id:id},
                beforeSend: function () {
                    $(".blockUI").show();
                },
                complete: function () {
                    $("li.make").removeClass("current");
                    $(makeList).addClass("current");
                },
                success: function(html) {
                    $("#loading").hide();          
                    $(".makes").removeClass("active");
                    $(".models").addClass("active");
                    $(".model-listings").removeClass("hide").addClass("show"); 
                    $(".model-listings").html(html); 
                    $("#model-done").removeClass("disabled");
                }
            });
        });

        $("body").on("click", "li.model", function() { 

            var makeList = $(this);
            var id = $(this).attr("data-id");
            var text = $(this).attr("data-name");
            $(".cat-block").text(text);
           
            $("#category_id").val(id);
            $.ajax({
                url: "{{ url('get-child-categories') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: {id:id , type: "child"},
                beforeSend: function () {
                    $(".blockUI").show();
                },
                complete: function () {
                    $("li.make").removeClass("current");
                    $(makeList).addClass("current");
                },
                success: function(html) {
                    $("#loading").hide();    
                    $(".models").removeClass("active");
                    $(".versions").addClass("active");
                    $(".version-listings").removeClass("hide").addClass("show"); 
                    $(".version-listings").html(html); 
                }
            });

            // var makeList = $(this);
            // $("li.model").removeClass("current");
            // $(makeList).addClass("current");
            // $("#loading").show();
            // setTimeout(() => {
            //     $("#loading").hide();    
            //     $(".models").removeClass("active");
            //     $(".versions").addClass("active");
            //     $(".version-listings").removeClass("hide").addClass("show");
            // }, 1000);
        })
    

        $("li.version").click(function() {
            var id = $(this).attr("data-id");
            $("#category_id").val(id);
            var text = $(this).attr("data-name");
            $(".cat-block").text(text);
            
            // var makeList = $(this);
            // $("li.version").removeClass("current");
            // $(makeList).addClass("current");
            // $("#loading").show();
            // setTimeout(() => {
            //     $("#loading").hide();     
            //     $("#model-done").removeClass("disabled");
            // }, 1000);
        });

        $("#model-done").click(function() {
            $("modal-categories").modal("hide");
            $(".cat-block").addClass("inner-success");
            $("#category_id").change();
        });

        $('#postAnAd').submit(function() {
            var form_data = $(this).serialize();

            $.ajax({
                url: "{{ url('post-an-ad') }}",
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(".blockUI").show();
                    $("#PostNow").text("Posting...");
                },
                complete: function () {
                    $(".blockUI").hide();
                },
                success: function(result) {
                    var obj = JSON.parse(result);
                    var err = "";
                    if(obj["status"] == false) { 
                        err += '<div class="alert alert-danger" role="alert">';
                        err += obj["errors"];
                        err += '</div>';
                    }
                    if(obj["status"] == true) { 
                        err += '<div class="alert alert-success" role="alert">';
                        err += obj["errors"];
                        err += '</div>';
                    }

                    
                    $("#PostNow").text("Post Now");
                    $("#showError").html(err);

                    if(obj["status"] == true) { 
                        setTimeout(() => {
                            window.location.href= obj["url"];
                        }, 1000);
                    }
                   
                },
                error: function(result) { 
                     var obj = JSON.parse(result);
                    console.log(result);
                }
            });
            return false;
        });
    });
</script>

<style> 
    .kv-fileinput-upload { 
        display:none !important;
    }
</style>
@endsection
