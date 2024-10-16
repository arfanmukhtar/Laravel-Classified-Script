<?php

namespace App\Classes;

use Addons\Subscriptions\Classes\PaypalSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait StripeSubscription
{
    /**
     * create stripe subscription
     */
    public function makeSubscription($user, $request)
    {
        $pid = $request->input('pid');
        $price_id = $request->input('package_id');
        $payment_method = $request->input('payment_method');
        $plan_name = DB::table('addon_subscriptions_package_prices')->where('stripe_id', $price_id)->orWhere('stripe_yearly_id', $price_id)->value('stripe_plan_name');

        try {
            $subscription = $user->newSubscription($plan_name, $price_id)->create($payment_method);
        } catch (\Exception $e) {
        }

    }

    /**
     * create downgrade subscription
     */
    public function downgradeSubscription($user, $request)
    {
        $price_id = $request->input('package_id');
        $plan_name = DB::table('addon_subscriptions_package_prices')->where('stripe_id', $price_id)->orWhere('stripe_yearly_id', $price_id)->value('stripe_plan_name');

        $user->subscription($plan_name)->noProrate()->swap($price_id);
    }

    /**
     * create upgrade subscription
     */
    public function upgradeSubscription($user, $request, $billing_type = 'now')
    {
        $options = [
            'proration_behavior' => 'always_invoice',
        ];
        $price_id = $request->input('package_id');
        $plan_name = DB::table('addon_subscriptions_package_prices')->where('stripe_id', $price_id)->orWhere('stripe_yearly_id', $price_id)->value('stripe_plan_name');
        if ($billing_type == 'now') {
            if ($user->package_id == 1) {
                $user->subscription($plan_name)->swapAndInvoice($price_id, $options);
            } else {
                $user->subscription('Smartmails')->cancel();
                $this->makeSubscription($user, $request);
            }

            //
        } else {
            $user->subscription($plan_name)->noProrate()->swap($price_id);
        }

    }

    /**
     * create cancel subscription
     */
    public function moveToFreeSubscription($user)
    {
        if (Auth::user()->payment_type == 'paypal') {
            try {
                $subscription = new PaypalSubscription();
                $subscription->cancelSubscription(Auth::user()->paypal_id);
                $this->addOrUpdateuser($user->id);
                $roleId = DB::table('packages')->where('id', 1)->value('role_id');
                \App\User::where('id', Auth::user()->id)->update(['package_id' => 1, 'paypal_id' => '', 'billing_cycle' => 'Monthly', 'role_id' => $roleId]);
            } catch (\Exception $e) {

            }
        } else {
            $freePlan = DB::table('addon_subscriptions_package_prices')->where('package_id', 1)->first();
            $plan_name = $freePlan->stripe_plan_name;
            $price_id = $freePlan->stripe_id;
            $user->subscription($plan_name)->noProrate()->swap($price_id);
            $roleId = DB::table('packages')->where('id', 1)->value('role_id');
            \App\User::where('id', Auth::user()->id)->update(['package_id' => 1, 'paypal_id' => '', 'billing_cycle' => 'Monthly',  'role_id' => $roleId]);
        }

    }

    /**
     * plan tenure changed
     */
    public function updateSubscriptionPeriod($user, $request)
    {
        $options = [
            'proration_behavior' => 'always_invoice',
        ];
        $price_id = $request->input('package_id');
        $monthPlan = DB::table('addon_subscriptions_package_prices')->where('stripe_id', $price_id)->exists();
        $yearPlan = DB::table('addon_subscriptions_package_prices')->where('stripe_yearly_id', $price_id)->exists();
        $plan_name = DB::table('addon_subscriptions_package_prices')->where('stripe_id', $price_id)->orWhere('stripe_yearly_id', $price_id)->value('stripe_plan_name');
        if ($monthPlan) {
            $user->subscription($plan_name)->noProrate()->swap($price_id);
        }
        if ($yearPlan) {
            $user->subscription($plan_name)->swapAndInvoice($price_id, $options);
        }

        $params = [
            'name' => $user->name,
        ];

        $hdata = [
            'type' => -1,
            'user_id' => $user->id,
            'module_id' => 8,
            'data' => json_encode($params),
            'created_at' => gmdate('Y-m-d H:i:s'),
            'updated_at' => gmdate('Y-m-d H:i:s'),
        ];
        \Illuminate\Support\Facades\DB::table('addon_subscription_notification_tasks')->insertGetId($hdata);
        DB::table('users')->where('id', $user->id)->update(['billing_cycle' => 'Yearly']);

    }

    public function addOrUpdateuser($user_id)
    {
        $assignment = [
            'user_id' => $user_id,
            'action' => 'changeUserMtaRate',
            'data' => json_encode(['user_id' => $user_id, 'mta_speed' => 0]),
            'status' => 0,
        ];
        DB::table('ip_assignment')->insert($assignment);

    }
}
