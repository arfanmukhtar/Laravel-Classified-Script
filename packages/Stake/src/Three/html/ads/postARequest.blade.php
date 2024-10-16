@extends('frontend.appother')

@section('content')
<link href="/assets/css/select2.min.css" rel="stylesheet" />

  <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-9 page-content">
                    <div class="inner-box category-content">
                        <h2 class="title-2 uppercase"><strong> <i class="icon-docs"></i>{{trans('ads.post_request.post_now') }}
                            </strong></h2>

                        <div class="row">
                            <div class="col-sm-12">

                                <form id="postARequest"  method="POST" class="form-horizontal form-post-ads" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="form-group row">
                                        <label  class="col-sm-3 col-form-label">{{trans('ads.post_request.category') }}</label>
                                        <div class="col-sm-8">
                                            <select name="category_id" id="category_id" class="select2 form-control">
                                                @foreach($categories as $cat)
                                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                                @endforeach
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 col-form-label">{{trans('ads.post_request.add_type')}}</label>
                                        <div class="col-sm-8">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" checked name="addtype" id="inlineRadio1" value="Private">{{ trans('post_request.private')}} 
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="addtype" id="inlineRadio2" value="Business">{{ trans('post_request. business')}} 
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-sm-3 col-form-label">{{trans('ads.post_request.ad_title')}}</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="title" id="Adtitle" placeholder="Ad title">
                                            <small id="" class="form-text text-muted">
                                                A great title needs at least 30 characters
                                            </small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label  class="col-sm-3 col-form-label">{{trans('ads.post_request.describe_ad')}}</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="description" style="height: 100px;" rows="10"></textarea>

                                        </div>
                                    </div>

                                    

                                    <div class="content-subheading"><i class="icon-user fa"></i> <strong>{{trans('ads.post_request.buyer_information')}}
                                       </strong></div>

                                    <!-- Text input-->
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="seller_name">{{trans('ads.post_request.name')}}</label>

                                        <div class="col-sm-8">
                                            <input id="seller_name" name="seller_name"
                                                   placeholder="Buyer Name" class="form-control input-md"
                                                   required="" type="text">
                                        </div>
                                    </div>

                                    <!-- Appended checkbox -->
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="seller_email">{{trans('ads.post_request.seller_email')}} 
                                            </label>

                                        <div class="col-sm-8">
                                            <input id="seller_email" name="seller_email" class="form-control"
                                                   placeholder="Email" required="" type="text">
                                                   <!-- <div class="checkbox">
                                                        <label>
                                                            <small>Your Ad will show after click on confirmation link that you will receive in your email.</small>
                                                        </label>
                                                    </div> -->
                                           
                                        </div>
                                    </div>

                                    <!-- Text input-->
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="seller_number">{{trans('ads.post_request.phone_number')}}
                                            </label>

                                        <div class="col-sm-8">
                                            <input id="seller_number" name="seller_number"
                                                   placeholder="Phone Number" class="form-control input-md"
                                                   required="" type="text">
                                                   <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="hidePhone" value="">
                                                    <small> {{trans('ads.post_request.hide_number_on_this-ad')}}.</small>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Select Basic -->
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="seller-Location">{{trans('ads.post_request.location')}}</label>

                                        <div class="col-sm-8">
                                            <select id="seller-Location" name="city_id"
                                                    class="form-control">
                                                @foreach($cities as $city)
                                                <option value="{{$city->id}}" @if($city->name == "Lahore") selected @endif>{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Select Basic 
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="seller-area">City</label>

                                        <div class="col-sm-8">
                                            <select id="seller-area" name="seller-area" class="form-control">
                                                <option value="1">Option one</option>
                                                <option value="2">Option two</option>
                                            </select>
                                        </div>
                                    </div>
                                -->

                                   <!--  <div class="card bg-light card-body mb-3">
                                        <h3><i class=" icon-certificate icon-color-1"></i> Make your Ad Premium
                                        </h3>

                                        <p>Premium ads help sellers promote their product or service by getting
                                            their ads more visibility with more
                                            buyers and sell what they want faster. <a href="mailto:contact@alsvinparts.com">Cotnact Us</a></p>

                                        <div class="form-group row">
                                            <table class="table table-hover checkboxtable">
                                                <tr>
                                                    <td>

                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="exampleRadios" id="optionsRadios0" value="option1" checked>
                                                                Regular List
                                                            </label>
                                                        </div>

                                                    </td>
                                                    <td><p>$00.00</p></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="exampleRadios" id="optionsRadios1" value="option1" >
                                                                <strong> Urgent Ad</strong>
                                                            </label>
                                                        </div>

                                                    </td>
                                                    <td><p>$10.00</p></td>
                                                </tr>
                                                <tr>
                                                    <td>

                                                        <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="exampleRadios" id="optionsRadios2" value="option2" >
                                                            <strong> Top of the Page Ad</strong>
                                                        </label>
                                        </div>


                                                    </td>
                                                    <td><p>$20.00</p></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio" name="exampleRadios" id="optionsRadios3" value="option3" >
                                                                <strong> Top of the Page Ad + Urgent Ad</strong>
                                                            </label>
                                                        </div>


                                                    </td>
                                                    <td><p>$40.00</p></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-group row">
                                                            <div class="col-sm-8">
                                                                <select class="form-control" name="Method"
                                                                        id="PaymentMethod">
                                                                    <option value="2">Select Payment Method</option>
                                                                    <option value="3">Credit / Debit Card</option>
                                                                    <option value="5">Paypal</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><p><strong>Payable Amount : $40.00</strong></p></td>
                                                </tr>
                                            </table>

                                        </div> 
                                    </div>-->

                                    <!-- terms -->
                                    <div class="card bg-light card-body mb-3">
                                        <div class="col-sm-8">

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="createAccount" class="custom-control-input" id="createAccount">
                                                <label class="custom-control-label" for="customCheck1">{{trans('ads.post_request.create_account')}}</label>
                                            </div>


                                        </div>
                                    </div>

                                    <!-- Button  -->
                                    <div class="form-group row">
                                    <div class="col-sm-8">
                                    <button type="submit" name="submit" class="btn btn-success">{{trans('ads.post_request.post_now')}}</button>
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

                <div class="col-md-3 reg-sidebar">
                    <div class="reg-sidebar-inner text-center">
                        <div class="promo-text-box"><i class=" icon-picture fa fa-4x icon-color-1"></i>

                            <h3><strong>{{trans('ads.post_request.post_a_free_classified')}}</strong></h3>

                            <p>{{trans('ads.post_request.online_classified')}} </p>
                        </div>

                        <div class="card sidebar-card">
                            <div class="card-header uppercase">
                                <small><strong>{{trans('ads.post_request.sell_quickly')}}</strong></small>
                            </div>
                            <div class="card-content">
                                <div class="card-body text-left">
                                    <ul class="list-check">
                                        <li>{{trans('ads.post_request.brief_description')}}</li>
                                        <li>{{trans('ads.post_request.correct_category')}}</li>
                                        <li>{{trans('ads.post_request.nice_photo')}}</li>
                                        <li>{{trans('ads.post_request.resonable_price')}}</li>
                                        <li>{{trans('ads.post_request.publish')}}</li>

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


<!-- include jquery file upload plugin  -->
<script src="assets/js/fileinput.min.js" type="text/javascript"></script>
<script src="/assets/js/select2.min.js"></script>
<script>
    // initialize with defaults
    $("#input-upload-img1").fileinput();
    $("#input-upload-img2").fileinput();
    $("#input-upload-img3").fileinput();
    $("#input-upload-img4").fileinput();
    $("#input-upload-img5").fileinput();

    $(document).ready(function(){
        $(".select2").select2();

        $('#postARequest').submit(function() {

            var form_data = $(this).serialize();

            $.ajax({
                url: "{{ url('post-a-request') }}",
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $(".blockUI").show();
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

                    

                    $("#showError").html(err);

                    if(obj["status"] == true) { 
                        setTimeout(() => {
                            location.reload();
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

        // $("#button1id").click(function(){

        // });
    });
</script>

<style> 
    .kv-fileinput-upload { 
        display:none !important;
    }
</style>
@endsection
