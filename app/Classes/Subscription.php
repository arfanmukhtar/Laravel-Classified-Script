<?php

namespace App\Classes;

use Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Subscription
{
    /**
     * create stripe subscription
     */
    public function createCustomerSubcription($user, $pid, $price_id)
    {
        try {
            $package = DB::table('addon_subscriptions_package_prices')->where('package_id', $pid)->first();
            $renewal_date = gmdate('Y-m-d H:i:s', strtotime('+1 month'));
            if ($package->stripe_yearly_id == $price_id) {
                $renewal_date = gmdate('Y-m-d H:i:s', strtotime('+1 year'));
            }
            DB::table('users')->where('id', $user->id)->update(['renewal_date' => $renewal_date]);
        } catch (\Exception $e) {
        }
        try {
            $default_credits = DB::table('packages')->where('id', $pid)->value('default_credits');
            $transactional_credits = DB::table('packages')->where('id', $pid)->value('transactional_credits');
            DB::table('user_email_limits')->where('user_id', Auth::user()->id)->update(['credits' => $default_credits, 'trans_credits' => $transactional_credits]);
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

        $user_id = $user->id;

        //////

        try {
            $pkgPrice = DB::table('addon_subscriptions_package_prices')->where('stripe_id', $price_id)->orWhere('stripe_yearly_id', $price_id)->first();
            $billingCycle = 'Monthly';
            $billingCycleU = 'Monthly';
            $billingPrice = $pkgPrice->price.'/mo';
            if ($pkgPrice->stripe_yearly_id == $price_id) {
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

            $hdata = [
                'type' => -1,
                'user_id' => $user->id,
                'module_id' => 4,
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

            $daysLeft = abs($daysLeft);

            $newCredits = $default_credits; // $default_credits/30 * $daysLeft;

            $user_credits = DB::table('user_email_limits')->where('user_id', Auth::user()->id)->value('credits');
            DB::table('user_email_limits')->where('user_id', Auth::user()->id)->update(['credits' => $default_credits, 'trans_credits' => $transactional_credits]);
            // if( ($user_credits + $newCredits) > $newCredits ) {
            //     $newCredits = $default_credits;
            //     DB::table("user_email_limits")->where("user_id" , Auth::user()->id)->update([
            //         "credits" => $newCredits
            //     ]);
            // } else {
            //     DB::table("user_email_limits")->where("user_id" , Auth::user()->id)->increment("credits" , $newCredits);
            // }

            try {
                $pkgPrice = DB::table('addon_subscriptions_package_prices')->where('stripe_id', $price_id)->orWhere('stripe_yearly_id', $price_id)->first();
                $billingCycle = 'Monthly';
                $billingCycleU = 'Monthly';
                $billingPrice = $pkgPrice->price.'/mo';
                if ($pkgPrice->stripe_yearly_id == $price_id) {
                    $billingCycle = 'Annually';
                    $billingCycleU = 'Yearly';
                    $billingPrice = $pkgPrice->yearly_price.'/year';
                }
                DB::table('users')->where('id', $user->id)->update(['billing_cycle' => $billingCycleU]);
                $params = [
                    'name' => $user->name,
                    'plan_name' => $package->package_name,
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
                Log::info('upgrade '.$e->getMessage());
            }

        } catch (\Exception $e) {
        }

        try {
            $roleId = DB::table('packages')->where('id', $pid)->value('role_id');
            // \App\User::where("id" , Auth::user()->id)->update(["package_id" => $pid , "role_id" => $roleId]);
            saveRolePermissionToSession($roleId);
        } catch (\Exception $e) {
        }
    }

    public function downgradeCustomerSubscription($user, $pid, $price_id)
    {
        try {

            $package = DB::table('packages')->where('id', $pid)->first();
            $pkgPrice = DB::table('addon_subscriptions_package_prices')->where('stripe_id', $price_id)->orWhere('stripe_yearly_id', $price_id)->first();
            $billingCycle = 'Monthly';
            $billingPrice = $pkgPrice->price.'/mo';
            if ($pkgPrice->stripe_yearly_id == $price_id) {
                $billingCycle = 'Annually';
                $billingPrice = $pkgPrice->yearly_price.'/year';
            }
            $params = [
                'name' => $user->name,
                'plan_name' => $package->package_name,
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
            Log::info('dwongrade '.$e->getMessage());
        }

    }

    public function createNotification($data)
    {

        \Illuminate\Support\Facades\DB::table('addon_subscription_notification_tasks')->insertGetId($data);
    }
}
