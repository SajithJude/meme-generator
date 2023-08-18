<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Stripe;
use Illuminate\Support\Facades\Redirect;
use App\Models\UserSubscribedPlan;
use Illuminate\Support\Facades\Session;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use DB;

class SubscriptionController extends Controller
{

    private $_api_context;

    public function __construct()
    {

        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }

    public function membershipPlans(Request $request, $id = null)
    {
        if ($request->has('canceled') && $request->input('canceled') == 1) {
            Session::flash('error', 'We are sorry, the payment process was canceled. Please try again later.');
        }
        $data['plans'] = \App\Models\Subscription::getSubscriptions();
        $data['hide_free_signup'] = session()->get('hide_free_signup');
        $userSubscriptionPlan = UserSubscribedPlan::where('user_id', auth()->user()->id)->where('is_active', 1)->first();
        if (isset($userSubscriptionPlan->id)) {
            return redirect()->route('home');
        }
        return view('membership-plan', compact('data'));
    }

    //stripe own page payment
    public function paymentDetails(Request $request)
    {
        $user_id = \Auth::user()->id;
        $email = \Auth::user()->email;
        $subscription_id = $request->get('selected-plan');
        $data['user_id'] = $user_id;
        $data['subscription_id'] = $subscription_id;
        $subscription = \App\Models\Subscription::getSubscription($data['subscription_id']);
        $data['price'] = !empty($subscription['price']) ? $subscription['price'] : null;

        $stripe = new \Stripe\StripeClient(config('paths.secret_key'));
        $product_description = 'The Impact Program from the Speak2Impact Academy by Susie Ashfield provides access to courses, practice with AI Tools, monthly group calls, and many other features.';
        $plan = ($subscription['plans'] == "halfyearly" ? "Billed half yearly" : "Billed yearly");
        $product_id = $subscription['stripe_product_id'];
        $product = $stripe->products->retrieve($product_id);

        $prices = $stripe->prices->all([
            'product' => $product_id,
        ]);

        $price_id = null;
        if (count($prices->data) > 0) {
            $price_id = $prices->data[0]->id;
        }
        $recurring_interval = 'year';
        if ($price_id) {
            $stripe_price = $stripe->prices->retrieve($price_id);
            $recurring_interval = $stripe_price->recurring->interval;
        }
        $checkout_session = $stripe->checkout->sessions->create([
            'customer_email' => $email,
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => $product->name,
                            'description' => $product->description,
                            // Use the product description
                            'images' => [
                                isset($product->images[0]) ? $product->images[0] : 'https://academy.susieashfield.com/favicon.ico'
                            ],
                        ],
                        'unit_amount' => $data['price'] * 100,
                        'tax_behavior' => 'exclusive',
                        'recurring' => ['interval' => $recurring_interval],
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'subscription',
            'metadata' => [
                'membership_plan' => $subscription['plans'],
                'user_id' => $user_id,
                'subscription_id' => $subscription_id,
                'price' => $data['price'] * 100,
                'session_avaialable' => $subscription['booking_credit']
            ],
            'allow_promotion_codes' => true,
            'billing_address_collection' => 'required',
            'success_url' => url('/payment-success?session_id={CHECKOUT_SESSION_ID}&payment_method={PAYMENT_METHOD_ID}'),
            'cancel_url' => url('/membership-plans?canceled=1'),
            'automatic_tax' => [
                'enabled' => true,
            ],
        ]);

        return redirect()->away($checkout_session->url);
    }

    public function showPaymentSuccess()
    {
        return view('payment-success');
    }
    public function handleCheckoutSuccess(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('paths.secret_key'));
        // Retrieve the session from the Stripe API using the session ID
        $session = \Stripe\Checkout\Session::retrieve($request->input('session_id'));
        $metadata = $session->metadata;
        // Extract your membership plan, user_id, and subscription_id from the metadata
        $membership_plan = $metadata['membership_plan'];
        $user_id = auth()->user()->id;
        $subscription_id = $metadata['subscription_id'];
        $price = $session->amount_total / 100;
        $booking_credit = $metadata['session_avaialable'];
        // Save the session and subscription data to the database
        $subscription = new UserSubscribedPlan();
        $subscription->user_id = $user_id;
        $subscription->subscription_id = $subscription_id;
        $subscription->price = $price;
        $subscription->paid_with = 'credit_card';
        $subDate = date('Y-m-d H:i:s');
        $subscription->subscription_start_date = $subDate;
        if (strtolower($membership_plan) == 'yearly') {
            $subscription->subscription_end_date = date('Y-m-d H:i:s', strtotime($subDate . ' + 1 years'));
        } elseif (strtolower($membership_plan) == 'halfyearly') {
            $subscription->subscription_end_date = date('Y-m-d H:i:s', strtotime($subDate . ' + 6 months'));
        }
        $subscription->save();
        auth()->user()->saveToMailchimp();
        // booking credit
        \App\Models\AvailableBookingCount::createOrUpdate(['user_id' => $user_id, 'booking_count' => $booking_credit]);
        // Remove this line: $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_method);
        // Retrieve the PaymentMethod object
        $session = \Stripe\Checkout\Session::retrieve($request->input('session_id'));
        $subscription = \Stripe\Subscription::retrieve($session->subscription);
        $paymentMethodId = $subscription->default_payment_method;
        $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);
        // now save payment details
        $paymentData = new \App\Models\Payment();
        $paymentData->subscription_id = $subscription_id;
        $paymentData->price = $price;
        $paymentData->user_id = auth()->user()->id;
        $paymentData->card_number = $paymentMethod->card->last4;
        $paymentData->card_type = $paymentMethod->card->brand;
        $paymentData->card_name = $paymentMethod->billing_details->name;
        $paymentData->exp_month = '00';
        $paymentData->exp_year = '0000';

        // Retrieve the latest invoice ID from the subscription
        $invoice_id = $subscription->latest_invoice;

        // Retrieve the Invoice object using the invoice ID
        $invoice = \Stripe\Invoice::retrieve($invoice_id);

        // Get the hosted invoice URL
        $paymentData->receipt_url = $invoice->hosted_invoice_url;
        $paymentData->payment_method_id = $paymentMethodId;

        $paymentData->intent_id = $invoice->payment_intent;
        $paymentData->gateway_response = serialize($session); // Serialize the entire session as the gateway response
        $paymentData->save();


        // Redirect the user to a success page
        Session::flash('success', 'Stripe Payment has been successful!');
        return redirect()->route('home')->with('Subscribed Successfully!');
    }

    public function savePaymentDetails(Request $request)
    {
        if (isset($request->user_id) && isset($request->subscription_id)) {
            // check if customer already subscribed to any subscription
            $data['request_data'] = $request->toArray();
            $data['request_data']['user_id'] = Crypt::decrypt($request->user_id);
            $data['request_data']['subscription_id'] = Crypt::decrypt($request->subscription_id);
            $currentDate = date('Y-m-d H:i:s');
            $userSubscripitions = \App\Models\UserSubscribedPlan::where('user_id', '=', $data['request_data']['user_id'])
                ->where('is_active', 1)
                ->where('subscription_end_date', '>', $currentDate)
                ->first();
            if (!empty($userSubscripitions)) {
                Session::flash('error', 'You have already subscribed a subscription plan!!');
                return redirect()->route('index')->with('You have already subscribed a subscription plan!');
            }
            $data['subscription'] = \App\Models\Subscription::getSubscription($data['request_data']['subscription_id']);
            $paymentMthod = self::createPaymentMethod($data);
            if ($paymentMthod['success'] == false) {
                return redirect()->back()->with('Error occurred while adding payment method! please try again');
            }
            $data['payment_method_data'] = $paymentMthod['method_data'];
            $createIntnet = self::createPaymentIntentMethod($data);
            if ($createIntnet['success'] != true) {
                return redirect()->route('membershipPlans')->with('Error occurred while creating payment plan');
            }
            $data['intent_data'] = $createIntnet['data'];
            $capturePayment = self::capturePaymentIntentMethod($data);
            if ($capturePayment['success'] != true) {
                return redirect()->route('membershipPlans')->with('Error occurred while capturing payment');
            }
            $data['gateway_response'] = $capturePayment['capture_data'];
            $prepareSubscription = self::prepareData($data);
            $saveSubscription = \App\Models\UserSubscribedPlan::saveData($prepareSubscription);
            if (!$saveSubscription) {
                return redirect()->back()->with('Error occurred! please try again');
            }
            $paymentData = self::preparePaymentData($data);
            $savePayment = \App\Models\Payment::saveData($paymentData);
            //add booking count
            $saveCount = \App\Models\AvailableBookingCount::createOrUpdate(['user_id' => $data['request_data']['user_id'], 'booking_count' => 2]);
            if (!$savePayment) {
                return redirect()->back()->with('Error occurred! please try again');
            }
            Session::flash('success', 'Payment successful!');
            return redirect()->route('home')->with('Subscribed Successfully!');
        } else {
            return redirect()->back()->with('Error occurred! please try again');
        }
    }

    public static function prepareData($subscriptionData)
    {
        $data['subscription_id'] = $subscriptionData['subscription']['id'];
        $data['price'] = $subscriptionData['subscription']['price'];
        $data['user_id'] = $subscriptionData['request_data']['user_id'];
        $data['paid_with'] = 'credit_card';
        $data['subscription_start_date'] = date('Y-m-d H:i:s');
        if (strtolower($subscriptionData['subscription']['plans']) == 'yearly' || strtolower($subscriptionData['subscription']['plans']) == 'anually') {
            $data['subscription_end_date'] = date('Y-m-d H:i:s', strtotime($data['subscription_start_date'] . ' + 1 years'));
        } elseif (strtolower($subscriptionData['subscription']['plans']) == 'monthly') {
            $data['subscription_end_date'] = date('Y-m-d H:i:s', strtotime($data['subscription_start_date'] . ' + 1 months'));
        } elseif (strtolower($subscriptionData['subscription']['plans']) == 'halfyearly') {
            $data['subscription_end_date'] = date('Y-m-d H:i:s', strtotime($data['subscription_start_date'] . ' + 6 months'));
        }
        return $data;
    }

    public static function createPaymentIntentMethod($data = [])
    {
        $key = Stripe\Stripe::setApiKey(config('paths.secret_key'));
        $discount = $data['subscription']['discount_percentage'] / 100 * $data['subscription']['price'];
        $data['subscription']['price'] = $data['subscription']['price'] - $discount;
        $intent = Stripe\PaymentIntent::create([
            "amount" => $data['subscription']['price'] * 100,
            "currency" => "usd",
            'payment_method' => $data['payment_method_data']->id,
            'payment_method_types' => ['card'],
        ]);
        if ($intent) {
            return ['success' => true, 'data' => $intent];
        } else {
            return ['success' => false];
        }
    }

    public static function capturePaymentIntentMethod($data = [])
    {
        $stripe = new \Stripe\StripeClient(config('paths.secret_key'));
        $capture = $stripe->paymentIntents->confirm(
            $data['intent_data']->id,
            [
                'payment_method_types' => ['card'],
            ]
        );

        if ($capture) {
            return ['success' => true, 'capture_data' => $capture];
        } else {
            return ['success' => false];
        }
    }

    public static function createPaymentMethod($data = [])
    {

        $stripe = new \Stripe\StripeClient(config('paths.secret_key'));

        $method = $stripe->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'number' => $data['request_data']['card_number'],
                'exp_month' => $data['request_data']['expiry_month'],
                'exp_year' => $data['request_data']['expiry_year'],
                'cvc' => $data['request_data']['cvc'],
            ],
        ]);
        if ($method) {
            return ['success' => true, 'method_data' => $method];
        } else {
            return ['success' => false];
        }
    }

    public static function preparePaymentData($data)
    {
        $paymentData['subscription_id'] = $data['subscription']['id'];
        $paymentData['price'] = $data['subscription']['price'];
        $paymentData['user_id'] = $data['request_data']['user_id'];
        $paymentData['exp_month'] = $data['request_data']['expiry_month'];
        $paymentData['exp_year'] = $data['request_data']['expiry_year'];
        $paymentData['card_name'] = $data['request_data']['card_name'];
        $paymentData['card_number'] = substr($data['request_data']['card_number'], 12, 16);
        $paymentData['card_type'] = !empty($data['payment_method_data']->card->brand) ? $data['payment_method_data']->card->brand : null;
        $paymentData['receipt_url'] = !isset($data['intent_data']->receipt_url) ? $data['intent_data']->receipt_url : null;
        $paymentData['payment_method_id'] = $data['payment_method_data']->id;
        $paymentData['intent_id'] = $data['intent_data']->id;
        $paymentData['gateway_response'] = !empty($data['gateway_response']) ? serialize($data['gateway_response']) : null;

        return $paymentData;
    }

    public function paywithpaypal()
    {
        return view('paywithpaypal');
    }

    public function postPaymentWithpaypal(Request $request)
    {
        DB::BeginTransaction();
        $data['request_data'] = $request->toArray();

        $data['request_data']['user_id'] = Crypt::decrypt($request->user_id);
        $data['request_data']['subscription_id'] = Crypt::decrypt($request->subscription_id);

        $currentDate = date('Y-m-d H:i:s');
        $userSubscripitions = \App\Models\UserSubscribedPlan::where('user_id', '=', $data['request_data']['user_id'])
            ->where('is_active', 1)
            ->where('subscription_end_date', '>', $currentDate)
            ->first();
        if (!empty($userSubscripitions)) {
            Session::flash('error', 'You have already subscribed a subscription plan!!');
            return redirect()->route('index')->with('You have already subscribed a subscription plan!');
        }
        $data['subscription'] = \App\Models\Subscription::getSubscription($data['request_data']['subscription_id']);
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new \PayPal\Api\Item();
        $discount = $data['subscription']['discount_percentage'] / 100 * $data['subscription']['price'];
        $data['subscription']['price'] = $data['subscription']['price'] - $discount;
        $item_1->setName($data['subscription']['plans'])
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($data['subscription']['price']);

        $item_list = new \PayPal\Api\ItemList();
        $item_list->setItems(array($item_1));

        $amount = new \PayPal\Api\Amount();
        $amount->setCurrency('USD')
            ->setTotal($data['subscription']['price']);

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Payment for ' . $data['subscription']['plans'] . ' subscription plan');

        $redirect_urls = new \PayPal\Api\RedirectUrls();
        $redirect_urls->setReturnUrl(\Illuminate\Support\Facades\URL::route('status'))
            ->setCancelUrl(\Illuminate\Support\Facades\URL::route('status'));

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        try {
            $createdPayment = $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return Redirect::route('paywithpaypal');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenience');
                return Redirect::route('membershipPlans');
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        if (!empty($createdPayment->getId())) {
            $paymentID = ($createdPayment->getId());
        }

        if (isset($redirect_url) && isset($paymentID)) {
            $prepareSubscriptionData = self::preparePaypalSubscriptionData($data);
            $createSubscription = UserSubscribedPlan::saveData($prepareSubscriptionData);
            if (!$createSubscription) {
                \Session::put('error', 'Plan could not be subscribed! please try again later');
                DB::rollback();
                return Redirect::route('home');
            }
            $data['payment_id'] = $paymentID;
            $data['gateway_response'] = $createdPayment;
            $preparePaymentData = self::preparePaypalPaymentData($data);
            $savePayment = \App\Models\Payment::saveData($preparePaymentData);
            if (!$savePayment) {
                \Session::put('error', 'Plan could not be subscribed! please try again later');
                DB::rollback();
                return Redirect::route('home');
            }
            DB::commit();

            return Redirect::away($redirect_url);
        }
        DB::rollback();
        return Redirect::route('home');
    }

    public function getPaymentStatus(Request $request)
    {
        DB::BeginTransaction();

        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');
        $payment_id = $request->get('paymentId');

        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            \Session::put('error', 'Payment failed!!!');
            return Redirect::route('membershipPlans');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {
            // update subscription data
            $getPayment = \App\Models\Payment::where('payment_method_id', '=', $payment_id)->first();
            if (empty($getPayment)) {
                \Session::put('error', 'Payment failed !!');
                return Redirect::route('home');
            }
            $updatePayment = \App\Models\Payment::where('id', $getPayment->id)->update(['is_active' => 1]);
            $updateSubscription = UserSubscribedPlan::where('subscription_id', $getPayment->subscription_id)->update(['is_active' => 1]);
            $saveCount = \App\Models\AvailableBookingCount::createOrUpdate(['user_id' => $getPayment->user_id, 'booking_count' => 2]);
            if (!$updatePayment || !$updateSubscription) {
                DB::rollback();
                \Session::put('error', 'Payment failed !!');
                return Redirect::route('home');
            }
            DB::commit();
            \Session::put('success', 'Payment success !!');
            return Redirect::route('home');
        }
        DB::rollback();
        \Session::put('error', 'Payment failed !!');
        return Redirect::route('membershipPlans');
    }

    public static function preparePaypalSubscriptionData($subscriptionData)
    {
        $data['subscription_id'] = $subscriptionData['subscription']['id'];
        $data['price'] = $subscriptionData['subscription']['price'];
        $data['user_id'] = $subscriptionData['request_data']['user_id'];
        $data['subscription_start_date'] = date('Y-m-d H:i:s');
        if (strtolower($subscriptionData['subscription']['plans']) == 'yearly' || strtolower($subscriptionData['subscription']['plans']) == 'anually') {
            $data['subscription_end_date'] = date('Y-m-d 23:59:59', strtotime($data['subscription_start_date'] . ' + 1 years'));
        } elseif (strtolower($subscriptionData['subscription']['plans']) == 'monthly') {
            $data['subscription_end_date'] = date('Y-m-d 23:59:59', strtotime($data['subscription_start_date'] . ' + 1 months'));
        } elseif (strtolower($subscriptionData['subscription']['plans']) == 'halfyearly') {
            $data['subscription_end_date'] = date('Y-m-d 23:59:59', strtotime($data['subscription_start_date'] . ' + 6 months'));
        }
        $data['paid_with'] = 'paypal';
        $data['is_active'] = 0;
        return $data;
    }

    public static function preparePaypalPaymentData($data)
    {
        $paymentData['subscription_id'] = $data['subscription']['id'];
        $paymentData['price'] = $data['subscription']['price'];
        $paymentData['user_id'] = $data['request_data']['user_id'];
        $paymentData['exp_month'] = '00';
        $paymentData['exp_year'] = '0000';
        $paymentData['card_name'] = 'Paypal';
        $paymentData['card_number'] = '0000';
        $paymentData['card_type'] = 'Paypal';
        $paymentData['receipt_url'] = null;
        $paymentData['payment_method_id'] = $data['payment_id'];
        $paymentData['intent_id'] = 'Paypal';
        $paymentData['gateway_response'] = !empty($data['gateway_response']) ? serialize($data['gateway_response']) : null;
        $paymentData['is_active'] = 0;

        return $paymentData;
    }

}
