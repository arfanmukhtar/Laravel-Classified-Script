@extends('frontend.appother')

@section('content')
<?php 
      $app_setting = getApplicationSettings();
      $currency_symbol = !empty($app_setting["currency_symbol"]) ? $app_setting["currency_symbol"] : "$";
?>
<div class="main-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12 page-content">
                    <div class="inner-box category-content">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="alert alert-success pgray  alert-lg" role="alert">
                                    <h2 class="no-margin no-padding">&#10004;{{trans('ads.paymeny_success.congratulations')}} </h2>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.page-content -->

                </div>
                <!-- /.row -->
            </div>

            <!-- /.container -->
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
                $("#PayCard").show();
            } else { 
                $("#ByPaypal").show();
                $("#PayCard").hide();
            }
        });
    
        $("body").on("click", ".selectPkg", function() { 
            var price = $(this).attr("data-price");
            var id = $(this).val();
            $("#Pp").html(price);
            $(".package_id").val(id)
        });
    </script>


@if(!empty($intent->client_secret))
<script src="https://js.stripe.com/v3/"></script>
<script>
    let stripe = Stripe('pk_test_EN9mCtJUh2pp2dse6woPPGDm');
    let elements = stripe.elements()
    let style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    }
    let card = elements.create('card', {style: style})
    card.mount('#card-element')
    let paymentMethod = null
    $('#paymentForm').submit(function(e) {
        e.preventDefault(); // Prevent form submission
        $('button.pay').attr('disabled', true)
        if (paymentMethod) {
            return true
        }
        stripe.confirmCardSetup(
            "{{ $intent->client_secret }}",
            {
                payment_method: {
                    card: card,
                    billing_details: {name: $('#cc_name').val()}
                }
            }
        ).then(function (result) { console.log(result);
            if (result.error) {
                $('#card-errors').text(result.error.message)
                $('button.pay').removeAttr('disabled')
            } else {
                paymentMethod = result.setupIntent.payment_method
                $('.payment-method').val(paymentMethod)

             
                var form_data = {
                    payment_method : paymentMethod,
                    package_id: $(".package_id").val()
                };
                $.ajax({
                    url: "<?php echo route('charge-payment'); ?>",
                    type: "POST",
                    headers: {  'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' ), 'Access-Control-Allow-Origin': '*' },
                   
                    data: form_data,
                    success: function(data) {
                        var obj = JSON.parse(data);
                        if(obj["status"] == true) { 
                            alert(obj["msg"]);
                        } else { 
                            alert(obj["msg"]);
                        }
                    }
                });
            }
        })
        return false
    })
</script>
@endif

@endsection 
