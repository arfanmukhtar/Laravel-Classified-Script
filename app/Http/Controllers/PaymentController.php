<?php

namespace App\Http\Controllers;

use App\Classes\PaypalSubscription;
use Auth;
use Config;
use DB;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        if (Config::get('subscriptions.mode') == 'sandbox') {
            $this->paypalUrl = 'https://api.sandbox.paypal.com/v1/';
            $this->paypalUrlV2 = 'https://api.sandbox.paypal.com/v2/';
        } else {
            $this->paypalUrl = 'https://api.sandbox.paypal.com/v1/';
            $this->paypalUrlV2 = 'https://api.sandbox.paypal.com/v2/';
        }

    }

    public function addCustomerPaymentMethod(Request $request)
    {
        $user = Auth::user();
        $payment_method = $request->input('payment_method');
        $payment_method = $user->addPaymentMethod($payment_method);
        // if($payment_method) {

        // }
        echo json_encode(['status' => true, 'msg' => 'Payment Method assigned to customer successfully']);
    }

    public function chargePayment(Request $request)
    {
        $user = Auth::user();
        $paymentMethod = $request->input('payment_method');
        $package_id = $request->input('package_id');
        $package_price = \App\Models\PackageFeature::where('id', $package_id)->value('price');
        try {
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->charge($package_price * 100, $paymentMethod);

            try {
                $data["amount"]= $package_price;
                $mail= sendEmail($user, 3 ,'', $data); // Sending Email
            } catch(\Exception $e) {}

            return json_encode(['status' => true, 'msg' => 'Payment Success']);
        } catch (\Exception $e) {
            return json_encode(['status' => true, 'msg' => $e->getMessage()]);
        }
    }

    public function paypalPaymentOrder(Request $request)
    {
        $paypalSubscription = new PaypalSubscription();
        $token = $paypalSubscription->generatePaypalToken();

        $paypal_url = $this->paypalUrlV2;
        $funds = 10;
        $data['intent'] = 'CAPTURE';
        $funds = round($funds, 2);
        $payee = [
            'email_address' => Auth::user()->email,
        ];
        $payment_instruction = [
            'disbursement_mode' => 'INSTANT',
        ];
        $data['purchase_units'][] = [
            'amount' => ['currency_code' => 'USD',  'value' => "$funds"],
            // "payee" => $payee,
            'payment_instruction' => $payment_instruction,
        ];

        $experience_context = [
            'return_url' => route('paypal-callback'),
            'cancel_url' => url('/'),
        ];

        $paypal = [
            'experience_context' => $experience_context,
            'name' => ['given_name' => Auth::user()->name, 'surname' => Auth::user()->name],
        ];

        $data['payment_source'] = [
            'paypal' => $paypal,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $paypal_url.'checkout/orders');
        $authorization = 'Authorization: Bearer '.$token; // Prepare the authorisation token
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', $authorization]); // Inject the token into the header
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Set the posted fields
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
        $json_return = curl_exec($ch);

        $resultData = json_decode($json_return, true);

        $links = $resultData['links'];

        $returnUrl = '';
        foreach ($links as $link) {
            if ($link['rel'] == 'payer-action') {
                $returnUrl = $link['href'];
            }
        }

        return redirect($returnUrl);
        // echo "<pre>"; print_r( $resultData); exit;

    }

    public function intentPaymentMethod()
    {
        $user = Auth::user();
        try {
            if (empty(Auth::user()->stripe_id)) {
                $options = [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ];
                $stripeCustomer = $user->createAsStripeCustomer($options);
            }

        } catch (\Exception $e) {
        }

        $intent = $user->createSetupIntent();

        return $intent->client_secret;
    }

    public function paypalCallback(Request $request)
    {
        $paypalSubscription = new PaypalSubscription();
        $token = $paypalSubscription->generatePaypalToken();
        $paypal_url = $this->paypalUrlV2;

        $subId = $request->input('token');
        $PayerID = $request->input('PayerID');

        /// capture order
        $data = [];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $paypal_url."checkout/orders/$subId/capture");
        $authorization = 'Authorization: Bearer '.$token; // Prepare the authorisation token
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', $authorization]); // Inject the token into the header
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, "{}"); // Set the posted fields
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
        $json_return = curl_exec($ch);

        $resultData = json_decode($json_return, true);

        if (empty($resultData['purchase_units'][0]['payments']['captures'][0]['id'])) {
            echo '<pre>';
            print_r($resultData['details'][0]['description']);
            exit;
        }

        $invoiceId = $resultData['purchase_units'][0]['payments']['captures'][0]['id'];
        $amount = $resultData['purchase_units'][0]['payments']['captures'][0]['amount']['value'];

        $paymentData = [
            'user_id' => Auth::user()->id,
            'currency' => 'usd',
            'status' => 'paid',
            'customer_name' => Auth::user()->name,
            'customer_email' => Auth::user()->email,
            'product_id' => 'paypal',
            'subscription' => $invoiceId,
            'quantity' => 1,
            'price_id' => $invoiceId,
            'description' => 'Charge for funds',
            'amount' => $amount,
            'total_amount' => $amount,
            'paid_at' => gmdate('Y-m-d H:i:s'),
            'customer_id' => Auth::user()->paypal_id,
        ];


        try {
            
            $data["customer_name"] = Auth::user()->name;
            $data["customer_id"] = Auth::user()->id;
            $user = Auth::user();
            // $data["post"] = $request->title;
            $mail= sendEmail($user, 3 ,'', $data); // Sending Email
        } catch(\Exception $e) {}

        DB::table('payment_invoices')->insert($paymentData);

        return redirect('payment/success');

    }

    public function paymentSuccess()
    {

        $title = 'Post Success';

        return view('ads.paymeny_success', compact('title'));
    }
}
