<?php

namespace App\Http\Controllers\Api;

use App\Mail\SubscriptionRenewal;
use App\Models\Admin;
use App\Models\User;
use App\Models\Subscription;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\StripeClient;

class WebhooksController extends Controller
{
    public function invoicePaid(Request $request) {
        try {
            $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
            $product = Subscription::where('stripe_product_id', $request['data']['object']['lines']['data'][0]['plan']['product'])->first();

            if (isset($product)) {
                $customer = $stripe->customers->retrieve($request['data']['object']['customer'], []);
                $user = User::where('email', $customer->email)->first();

                Mail::to($customer->email)->send(new SubscriptionRenewal(['customer' => $customer, 'role' => 'customer']));
                Mail::to(Admin::first()->email)->send(new SubscriptionRenewal(['customer' => $customer, 'role' => 'admin']));

                $userSubscribedPlans = $user->userSubscribedPlans;
                $userSubscribedPlans->subscription_end_date = date('Y-m-d H:i:s', $request['data']['object']['period_end']);
                $userSubscribedPlans->save();
                return response()->json('Email sent successfully');
            }
        } catch (Exception $ex) {
            Log::error("Error while running Stripe invoicePaid webhook\n" . $ex);
        }

        return response()->json('Product does not exist on academy.susieashfield.com! Emails not sent');
    }
}
