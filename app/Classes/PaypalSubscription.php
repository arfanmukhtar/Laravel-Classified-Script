<?php

namespace App\Classes;

use Artisan;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaypalSubscription
{
    /**
     * create stripe subscription
     */
    public function generatePaypalToken()
    {
        $token = session('paypal_token');
        if (! $token) {
            if (getSetting('paypal_mode') == 'sandbox') {
                $paypal_url = 'https://api.sandbox.paypal.com/v1/';
                $client = getSetting('paypal_sandbox_key');
                $secret = getSetting('paypal_sandbox_secret');
            } else {
                $paypal_url = 'https://api.sandbox.paypal.com/v1/';
                $client = getSetting('paypal_key');
                $secret = getSetting('paypal_secret');
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $paypal_url.'oauth2/token');
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $client.':'.$secret);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
            $result = curl_exec($ch);

            $array = json_decode($result, true);
            $token = $array['access_token'];
            if ($token) {
                session(['paypal_token' => $token]);
            }
        }

        return $token;
    }

    public function createNewPaypalSubscription($data)
    {
        $paypal_plan_id = $data['paypal_plan_id'];
        if (getSetting('paypal_mode') == 'sandbox') {
            $paypal_url = Config::get('subscriptions.sandbox.paypal_url').'v1/';
        } else {
            $paypal_url = Config::get('subscriptions.live.paypal_url').'v1/';
        }
        $paypal_plan_id = $request->input('paypal_plan_id');
        $package_id = $request->input('pid');
        $paypalSubscription = new PaypalSubscription();
        $token = $paypalSubscription->generatePaypalToken();
        $data = [];
        $data['plan_id'] = $paypal_plan_id;
        $data['start_time'] = date("Y-m-d\TH:i:s.000\Z", strtotime('+1 hour'));
        $data['quantity'] = 1;
    }

    public function createCustomerSubscription($user, $pid, $price_id)
    {

        try {
            $package = DB::table('addon_subscriptions_package_prices')->where('package_id', $pid)->first();

            $renewal_date = gmdate('Y-m-d H:i:s', strtotime('+1 month'));
            if ($package->paypal_yearly_id == $price_id) {
                $renewal_date = gmdate('Y-m-d H:i:s', strtotime('+1 year'));
            }
            DB::table('users')->where('id', $user->id)->update(['renewal_date' => $renewal_date]);
        } catch (\Exception $e) {
        }

        try {
            $roleId = DB::table('packages')->where('id', $pid)->value('role_id');
            \App\User::where('id', $user->id)->update(['package_id' => $pid, 'role_id' => $roleId]);
            saveRolePermissionToSession($roleId);
        } catch (\Exception $e) {
        }

        $user_id = $user->id;
        $user_email_limit = DB::table('user_email_limits')->where('user_id', $user_id)->exists();
        try {
            $adminPanelAddon = DB::table('addons')->where('name', 'AdminPanel')->orWhere('type', 'AdminPanel')->first();
            if (! empty($adminPanelAddon) and $adminPanelAddon->status == 'active') {
                if (! $user_email_limit) {
                    Artisan::call("account:configure $user_id $pid");
                }
            }
        } catch (\Exception $e) {
        }

            try {
                $pkgPrice = DB::table('addon_subscriptions_package_prices')->where('paypal_id', $price_id)->orWhere('paypal_yearly_id', $price_id)->first();
                $billingCycle = 'Monthly';
                $billingCycleU = 'Monthly';
                $billingPrice = $pkgPrice->price.'/mo';
                if ($pkgPrice->paypal_yearly_id == $price_id) {
                    $billingCycle = 'Annually';
                    $billingCycleU = 'Yearly';
                    $billingPrice = $pkgPrice->yearly_price.'/year';
                }
                DB::table('users')->where('id', $user->id)->update(['billing_cycle' => $billingCycleU]);
                $package_name = DB::table('packages')->where('id', $pid)->value('package_name');
                $params = [
                    'name' => $user->name,
                    'plan_name' => $package_name,
                    'total_cost' => $billingPrice,
                    'billing_cycle' => $billingCycle,
                ];

                $module_id = 4;
                if ($pid < $user->package_id) {
                    $module_id = 2;
                }
                if ($pid > $user->package_id) {
                    $module_id = 3;
                }
                $hdata = [
                    'type' => -1,
                    'user_id' => $user->id,
                    'module_id' => $module_id,
                    'data' => json_encode($params),
                    'created_at' => gmdate('Y-m-d H:i:s'),
                    'updated_at' => gmdate('Y-m-d H:i:s'),
                ];
                $this->createNotification($hdata);
            } catch (\Exception $e) {
                Log::info('created '.$e->getMessage());
            }

    }

    public function upgradeCustomerSubcription($user, $pid, $price_id)
    {

        try {
            $credits = DB::table('packages')->where('id', $pid)->value('default_credits');
            $transactional_credits = DB::table('packages')->where('id', $pid)->value('transactional_credits');
            $renewal_date = $user->renewal_date;
            $now = time(); // or your date as well
            $renewal_date = strtotime($renewal_date);
            $datediff = $renewal_date - $now;
            $daysLeft = round($datediff / (60 * 60 * 24));
            $package = DB::table('packages')->where('id', $pid)->first();
            $default_credits = $package->default_credits;
            DB::table('user_email_limits')->where('user_id', Auth::user()->id)->update([
                'credits' => $default_credits,
                'trans_credits' => $transactional_credits,
            ]);

            // $daysLeft = abs($daysLeft);

            // $newCredits = $default_credits/30 * $daysLeft;

            // $user_credits = DB::table("user_email_limits")->where("user_id" , Auth::user()->id)->value("credits");
            // if( ($user_credits + $newCredits) > $newCredits ) {
            //     $newCredits = $default_credits;
            //     DB::table("user_email_limits")->where("user_id" , Auth::user()->id)->update([
            //         "credits" => $newCredits
            //     ]);
            // } else {
            //     DB::table("user_email_limits")->where("user_id" , Auth::user()->id)->increment("credits" , $newCredits);
            // }

            try {
                $package = DB::table('addon_subscriptions_package_prices')->where('package_id', $pid)->first();

                $renewal_date = gmdate('Y-m-d H:i:s', strtotime('+1 month'));
                if ($package->paypal_yearly_id == $price_id) {
                    $renewal_date = gmdate('Y-m-d H:i:s', strtotime('+1 year'));
                }
                DB::table('users')->where('id', $user->id)->update(['renewal_date' => $renewal_date]);
            } catch (\Exception $e) {
            }

            try {
                $pkgPrice = DB::table('addon_subscriptions_package_prices')->where('paypal_id', $price_id)->orWhere('paypal_yearly_id', $price_id)->first();
                $billingCycle = 'Monthly';
                $billingPrice = $pkgPrice->price.'/mo';
                if ($pkgPrice->paypal_yearly_id == $price_id) {
                    $billingCycle = 'Annually';
                    $billingPrice = $pkgPrice->yearly_price.'/year';
                }
                $package_name = DB::table('packages')->where('id', $pid)->value('package_name');
                $params = [
                    'name' => $user->name,
                    'plan_name' => $package_name,
                    'total_cost' => $billingPrice,
                    'billing_cycle' => $billingCycle,
                ];

                $hdata = [
                    'type' => -1,
                    'user_id' => $user->id,
                    'module_id' => 3,
                    'data' => json_encode($params),
                    'created_at' => gmdate('Y-m-d H:i:s'),
                    'updated_at' => gmdate('Y-m-d H:i:s'),
                ];
                $this->createNotification($hdata);
            } catch (\Exception $e) {
                Log::info('created '.$e->getMessage());
            }

        } catch (\Exception $e) {
        }

        try {
            $roleId = DB::table('packages')->where('id', $pid)->value('role_id');
            saveRolePermissionToSession($roleId);
        } catch (\Exception $e) {
        }

    }

    public function downgradeCustomerSubscription($user, $pid, $price_id)
    {
        try {
            $pkgPrice = DB::table('addon_subscriptions_package_prices')->where('paypal_id', $price_id)->orWhere('paypal_yearly_id', $price_id)->first();
            $billingCycle = 'Monthly';
            $billingPrice = $pkgPrice->price.'/mo';
            if ($pkgPrice->paypal_yearly_id == $price_id) {
                $billingCycle = 'Annually';
                $billingPrice = $pkgPrice->yearly_price.'/year';
            }
            $package_name = DB::table('packages')->where('id', $pid)->value('package_name');
            $params = [
                'name' => $user->name,
                'plan_name' => $package_name,
                'total_cost' => $billingPrice,
                'billing_cycle' => $billingCycle,
            ];

            $hdata = [
                'type' => -1,
                'user_id' => $user->id,
                'module_id' => 2,
                'data' => json_encode($params),
                'created_at' => gmdate('Y-m-d H:i:s'),
                'updated_at' => gmdate('Y-m-d H:i:s'),
            ];
            $this->createNotification($hdata);
        } catch (\Exception $e) {
            Log::info('created '.$e->getMessage());
        }

    }

    public function cancelSubscription($subId)
    {
        try {
            $token = $this->generatePaypalToken();
            if (getSetting('paypal_mode') == 'sandbox') {
                $paypal_url = Config::get('subscriptions.sandbox.paypal_url').'v1/';
            } else {
                $paypal_url = Config::get('subscriptions.live.paypal_url').'v1/';
            }
            $data = [];
            $data['reason'] = 'Moved to new subscription';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $paypal_url."billing/subscriptions/$subId/cancel");
            $authorization = 'Authorization: Bearer '.$token; // Prepare the authorisation token
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', $authorization]); // Inject the token into the header
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Set the posted fields
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
            $json_return = curl_exec($ch);
            $resultData = json_decode($json_return, true);
            DB::table('addon_subscription_paypal_subscription')->where('subscription_id', $subId)->update(['status' => 3]);

            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }

    }

    public function createNotification($data)
    {
        \Illuminate\Support\Facades\DB::table('addon_subscription_notification_tasks')->insertGetId($data);
    }
}
