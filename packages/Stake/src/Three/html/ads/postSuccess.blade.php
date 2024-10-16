@extends('frontend.appother')

@section('content')
<?php 
      $app_setting = getApplicationSettings();
      $currency_symbol = !empty($app_setting["currency_symbol"]) ? $app_setting["currency_symbol"] : "$";
      $bank_account = !empty($app_setting["bank_account"]) ? $app_setting["bank_account"] : "";
?>
<style>
label.label-control {
    font-weight: 600;
}
.form-check-input[type=radio] {
    border-radius: 50%;
    width: 18px;
    height: 18px;
    margin-right: 5px;
    vertical-align: middle;
    display: inline-block;
    margin-top: 0;
}
.btn-paypal {
    background-color: #ffc43a !important;
    min-width: 330px;
    border-radius: 40px;
    font-size: 30px;
    font-weight: 900;
    color: #233a80 !important;
    font-family: 'Roboto';
    line-height: 1;
    outline: 0 !important;
    box-shadow: 0 0 0 transparent !important;
    margin: 20px 0;
}
.btn-paypal img.pp-icon {
    width: 28px;
    height: 28px;
    margin-right: 5px;
}
.btn-paypal span {
    color: #179bd7;
}
.btn-paypal:hover, .btn-paypal:hover span {
    color:#000 !important;
}
.btn-paypal:hover {
    background-color: #f0b833 !important;
    outline: 0 !important;
    box-shadow: 0 0 0 transparent !important;
}
.row.cc-block {
    padding: 20px 0 0;
}
a#skipPage {
    float: right;
    padding-top: 11px;
    font-size: 14px;
    font-weight: 500;
    font-family: Roboto;
}
table.checkboxtable td, table.checkboxtable th {
    border-top: solid 1px #ddd !important;
    border-bottom: 1px solid #ddd !important;
}
tr#PayCard td {
    border-bottom: 0 !important;
}
.checkboxtable {
    margin-bottom: 0;
}
tr#ByPaypal td {
    border-bottom: 0 !important;
}
.btn-card {
    width: 100%;
    font-size: 26px;
    font-weight: 600;
    font-family: 'Roboto';
    line-height: 1.21;
    outline: 0 !important;
    max-width: 330px;
    margin-left: 10px;
    margin-bottom: 20px;
}
label.control-label {
    font-weight: 600;
}
#card-element {
    font-family: "Lato", sans-serif;
    display: block;
    width: 100%;
    height: 42px;
    padding: 0.75rem 0.75rem 0.5rem 0.75rem;
    font-size: 14px;
    line-height: 1.25;
    color: #464a4c;
    background-color: #fff !important;
    background-image: none;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.25);
    border-radius: 2px;
    border-color: #bec4d0;
    border: 1px solid #bec4d0;
    color: #333;
}
#card-element:hover {
    border-color: #518ecb !important;
    box-shadow: -1px 1px 5px 0 rgba(8,197,82,0.2);
}
#card-element:focus, #card-element.StripeElement--focus {
    color: #464a4c;
    background-color: #fff;
    border-color: #233d7b;
    outline: none;
    box-shadow: 0 0 5px 2px #eff4ff;
}
</style>
    <div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12 page-content">
                    <div class="inner-box category-content">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="alert alert-success pgray  alert-lg" role="alert">
                                    <h2 class="no-margin no-padding">&#10004; Congratulations! Your ad will be live
                                        soon.</h2>

                                        @if(!empty($post))<p><strong>Title: </strong> <a href="{{url('detail/' . $post->slug)}}"> {{$post->title}} </a></p>@endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.page-content -->

                </div>
                <!-- /.row -->
            </div>

            @if(!empty($packages))
            <div class="row">
                <div class="col-sm-12">
                   
                        <div class="card bg-light card-body mb-3">
                            <h3><i class=" icon-certificate icon-color-1"></i> Make your Ad Premium</h3>

                            <p>Premium ads help sellers promote their product or service by getting</p>
                            <table class="table table bordered checkboxtable">
                                @foreach($packages as $package)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input selectPkg" name="packagep"  data-price="{{$package->price}}" type="radio"  checked value="{{$package->id}}">
                                                <strong>{{$package->package_name}}</strong> 
                                            </label>
                                        </div>

                                    </td>
                                    <td><p>{{$currency_symbol}}{{$package->price}}</p></td>
                                </tr>
                                @endforeach
                                <tr >
                                    <td width="60%">
                                        <div class="form-group row mb-0">
                                            <div class="col-sm-3">
                                                <label class="label-control text-link mt-2 pt-1">
                                                <input class="form-check-input selectPayment" name="card" type="radio"  checked value="bank"> Bank Transfer
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="label-control text-link mt-2 pt-1">
                                                <input class="form-check-input selectPayment" name="card" type="radio"  value="card"> Credit/Debit Card
                                                </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="label-control text-link mt-2 pt-1">
                                                <input class="form-check-input selectPayment" name="card" type="radio"   value="paypal"> Pay with Paypal
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td><h3 class="m-0 p-0 pt-1">Payable Amount : {{$currency_symbol}}<span id="Pp">0.00<span></h3></td>
                                </tr>
                                <tr id="BankTransfer">
                                    <td>
                                        <div class="form-group row mb-0">
                                            <div class="col-md-12">
                                                {!! $bank_account !!}
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr id="ByPaypal" style="display:none">
                                    <td>
                                        <div class="form-group row mb-0">
                                            <div class="col-md-12">
                                                <button class="btn btn-info btn-paypal" type="button">
                                                    <img src="/assets/img/pp.png" alt="Pay With Paypal" class="pp-icon" /> 
                                                    Pay<span>Pal</span>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr id="PayCard" style="display:none">
                                    <td>
                                        <div class="row cc-block">
                                            <!-- <div class="col-md-6 mb-4">
                                                <label class="label-control">Card Holder Name</label>
                                                <input class="form-control" id="cc_name" name="cc_name" placeholder="Name on card" />
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <label class="label-control"></label>
                                                <div class="row">
                                                    <div id="card-element"></div>
                                                </div>
                                            </div>
                                            -->
                                            <!-- <div class="col-md-6 mb-4">
                                                <button type="submit" class="btn btn-primary pay">
                                                    Pay Now
                                                </button>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                @if(!empty($post))<a href="{{url('detail/' . $post->slug)}}" id="skipPage" class="">Skip</a>
                                                @endif
                                            </div> -->

                                            <a id="cardOption" class="btn btn-primary pay btn-card"> Pay Now</a>

                                            <div class="col-md-12">
                                                <div id="card-errors" role="alert"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                
                            </table>
                            <input type="hidden" name="package_id" class="package_id">
                            <input type="hidden" name="payment_method" class="payment-method">
                  
                </div>
            </div>
            @endif

            <!-- /.container -->
        </div>
    </div>

    @if(!empty($packages))
<div class="modal fade" id="addCard" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class=" icon-mail-2"></i> Card Payment </h4>

				<button type="button" class="close modal-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span><span
						class="sr-only">Close</span></button>
			</div>
            
			<div class="modal-body">

					<div class="form-group mb-3">
						<label for="subject" class="label-control">Card Holder Name</label>
						<input class="form-control required" name="cc_name" id="card-holder-name" type="text" value="">
					</div>
					
					
					<div class="form-group mb-3">
						<label for="message-text"  class="label-control">Card Information</label>
                        <div id="card-element"></div>
					</div>
					
                    <p style="display:none" class="alert alert-danger mb-0" id="cards_name-error"> </p>
			</div>
			<div class="modal-footer">
            <button id="card-button" class="btn btn-success submit" data-secret="">
                <span class="save">Pay Now</span>
                <span style="display:none;" class="pro">Processing <i class="fa fa-spinner fa-spin"></i></span>
            </button>
			</div>
           
		</div>
	</div>
</div>



<script> 
    $(function() { 
        setTimeout(() => {
            $(".selectPkg").click();
        }, 100);
    });
    $("body").on("click", ".selectPayment", function() {
        if($(this).val() == "card") { 
            $("#ByPaypal").hide();
            $("#BankTransfer").hide();
            $("#PayCard").show();
        } else if($(this).val() == "bank") { 
            $("#ByPaypal").hide();
            $("#BankTransfer").show();
            $("#PayCard").hide();
        } else { 
            $("#ByPaypal").show();
            $("#PayCard").hide();
            $("#BankTransfer").hide();
        }
    });

    $("body").on("click", ".selectPkg", function() { 
        var price = $(this).attr("data-price");
        var id = $(this).val();
        $("#Pp").html(price);
        $(".package_id").val(id)
    });
</script>
<script> 
    $("#cardOption").click(function() {
        $.ajax({
            url: "<?php echo route('intent-payment-method'); ?>",
            type: "GET",
            headers: {  'Access-Control-Allow-Origin': '*' },
            // data: form_data,
            success: function(data) {
                $(".blockUI").hide();
                $("#card-button").attr("data-secret" , data)
                $("#card-success").hide();
                $("#card-error").hide();
                $("#addCard").modal("show");
                $("#CardId").val("new");
            }
        });
        $("#addCard").modal("show");
    });
    $(".btn-paypal").click(function() {
    window.location.href="<?php echo route('paypal-payment'); ?>";
    });
</script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    let stripe = Stripe('pk_test_EN9mCtJUh2pp2dse6woPPGDm');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
 
    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    cardButton.addEventListener('click', async (e) => { 
    const clientSecret = $("#card-button").attr("data-secret");
        $("#card-success").hide();
        $("#card-error").hide();

        if($("#card-holder-name").val().length < 5){
            $("#cards_name-error").show();
            return false;
        } else {
            $("#cards_name-error").hide();
            $("#cards_number-error").hide();
            $(".blockUI").show();
           
            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );
            $(cardButton).addClass("submitting");
            if (error) {
                // Display "error.message" to the user...
                $(".blockUI").show();
                alert(error.message);
                setTimeout(() => {
                    $(".blockUI").hide();
                    $("#card-success").hide();
                    $("#card-error").css("display", "flex");
                    $("#card-error").html("<span class='alert-text text-left'>" + error.message + "</span>");
                    $(cardButton).removeClass("submitting");
                }, 1000);
            } else {
                var form_data = {
                    payment_method : setupIntent.payment_method,
                    package_id : $(".package_id").val()
                };
                $.ajax({
                    url: "<?php echo route('charge-payment'); ?>",
                    type: "POST",
                    headers: {  'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' ), 'Access-Control-Allow-Origin': '*' },
                    data: form_data,
                    success: function(data) {
                        var obj = JSON.parse(data);
                        if(obj["status"] == true) { 
                           window.location.href = "<?php echo url("payment/success"); ?>";
                        } else { 
                            alert(obj["msg"]);
                        }
                        $(cardButton).removeClass("submitting");
                    }
                });
            }

        }
    });

    
</script>

@endif

@endsection 
