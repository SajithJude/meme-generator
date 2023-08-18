<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Stripe;
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
use Session;
use Exception;
use DB;
use App\Models\AvailableBookingCount;
use App\Models\BoughtCoaching;
use Stripe\Charge;

class BookingController extends Controller {
    private $_api_context;

    public function __construct() {

        $paypal_configuration = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_configuration['client_id'], $paypal_configuration['secret']));
        $this->_api_context->setConfig($paypal_configuration['settings']);
    }
    public function bookSlot(Request $request) {
        if ($request->has('canceled') && $request->input('canceled') == 1) {
            Session::flash('error', 'We are sorry, the payment process was canceled. Please try again later.');
        }
        $data['coach_price'] = \App\Models\GeneralSetting::where('key','booking_credits_price')->pluck('value')->first();
        $data['user_id'] = Auth::user()->id;
        return view('book-slot', compact('data'));
    }
    public function bookPaymentSlot(Request $request){
        $user_id = \Auth::user()->id;
        $email = \Auth::user()->email;
        $price = \App\Models\GeneralSetting::where('key','booking_credits_price')->pluck('value')->first();
        $quantity = $request->get('quantity');

        //$subscription_id = $request->get('selected-plan');
        //$data['user_id'] = $user_id;
        //$data['subscription_id'] =$subscription_id;
        //$subscription = \App\Models\Subscription::getSubscription($data['subscription_id']);
        //$data['price'] = !empty($subscription['price']) ? $subscription['price'] : null;

        $stripe = new \Stripe\StripeClient(config('paths.secret_key'));
        //$plan = ($subscription['plans'] == "halfyearly" ? "Billed half yearly":"Billed yearly");
        $product_id = 'prod_NiLCkBAAzBb3TF';//$subscription['stripe_product_id'];
        $product = $stripe->products->retrieve($product_id);

        $prices = $stripe->prices->all([
            'product' => $product_id,
        ]);
        
        // $price_id = null;
        // if (count($prices->data) > 0) {
        //     $price_id = $prices->data[0]->id;
        // } 
        // //$recurring_interval = 'year';
        // if($price_id){
        //     $stripe_price = $stripe->prices->retrieve($price_id);
        //     $recurring_interval = $stripe_price->recurring->interval; 
        // }
        $checkout_session = $stripe->checkout->sessions->create([
            'customer_email' => $email,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => $product->name,
                        'description' => $product->description, // Use the product description
                        'images' => [
                            isset($product->images[0]) ? $product->images[0] : 'https://academy.susieashfield.com/favicon.ico'
                        ],
                    ],
                    'unit_amount' => $price * 100,
                    'tax_behavior' => 'exclusive',
                ],
                'quantity' => $quantity,
            ]],
            'mode' => 'payment',
            'metadata' => [
                'user_id' => $user_id,
                'price' => $price * 100,
                'quantity' => $quantity,
            ],
            'allow_promotion_codes' => true,
            'billing_address_collection' => 'required',
            'success_url' => url('/meeting-payment-success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/book-slot?canceled=1'),
            'automatic_tax' => [
                'enabled' => true,
            ],
        ]);
        
        return redirect()->away($checkout_session->url);
    }
    public function showPaymentSuccess()
    {
        return view('payment-success-stripe');
    }
    public function handleCheckoutSuccess(Request $request)
    {   
        \Stripe\Stripe::setApiKey(config('paths.secret_key'));    
        // Retrieve the session from the Stripe API using the session ID
        $session = \Stripe\Checkout\Session::retrieve($request->input('session_id'));
        $metadata = $session->metadata;
        // Extract your membership plan, user_id, and subscription_id from the metadata
        $user_id = auth()->user()->id;
        $price = $session->amount_total / 100;
        $quantity = $metadata['quantity'];

        $savepurchase = new BoughtCoaching();
        $savepurchase->user_id = $user_id;
        $savepurchase->price = $price;
        $savepurchase->bill = $price * $quantity;
        $savepurchase->quantity = $quantity;
        $savepurchase->payment_status = 1;
        $savepurchase->save();

        $subscription = AvailableBookingCount::where('user_id',$user_id)->first();
        if($subscription != NULL){
            $book_count = $subscription->booking_count  + $quantity;
        }
        else {
            $subscription = new AvailableBookingCount();
            $book_count = $quantity;
        }    
        // Save the session and subscription data to the database
        $subscription->user_id = auth()->user()->id;
        $subscription->booking_count = $book_count;
        $subscription->save();

        $session = \Stripe\Checkout\Session::retrieve($request->input('session_id'));
        $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);
        // Retrieve the PaymentMethod object
        $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentIntent->payment_method);

       
        // now save payment details
        $paymentData = new \App\Models\CoachPayment();
        $paymentData->price = $price;
        $paymentData->user_id = auth()->user()->id;
        $paymentData->card_number = $paymentMethod->card->last4; 
        $paymentData->card_type = $paymentMethod->card->brand;
        $paymentData->card_name = $paymentMethod->billing_details->name;
        $paymentData->exp_month = '00';
        $paymentData->exp_year = '0000';

        // Retrieve the latest invoice ID from the subscription
        $invoice_id = $subscription->latest_invoice;
        // List charges related to the PaymentIntent
        $charges = Charge::all([
            'payment_intent' => $paymentIntent->id,
        ]);

        // Get the receipt URL from the first charge
        $paymentData->receipt_url = $charges->data[0]->receipt_url;
        $paymentData->payment_method_id =  $paymentMethod->id;

        $paymentData->intent_id = $paymentIntent->id;
        $paymentData->gateway_response = serialize($session); // Serialize the entire session as the gateway response
        $paymentData->save();


        // Redirect the user to a success page
        Session::flash('success', 'Payment successful!');
        return redirect()->route('meeting')->with('Payment Done Successfully!, Please Proceed further with booking');
    }

    public function bookPaymentSlotbk(Request $request) {
        
        try{


        if (isset($request->user_id) && isset($request->quantity) && $request->quantity > 0) {
            // check if customer already subscribed to any subscription
            $data['request_data'] = $request->toArray();
            $data['request_data']['user_id'] = Crypt::decrypt($request->user_id);
            $data['coach_price'] =  \App\Models\GeneralSetting::where('key','booking_credits_price')->pluck('value')->first();
            $data['quantity'] = $request->quantity;
            $currentDate = date('Y-m-d H:i:s');
            
            $paymentMthod = self::createPaymentMethod($data);
            \Log::info('payment method');
            \Log::info($paymentMthod);
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
            //dd($capturePayment);
            if ($capturePayment['success'] != true) {
                return redirect()->route('membershipPlans')->with('Error occurred while capturing payment');
            }
            $data['gateway_response'] = $capturePayment['capture_data'];
            $preparedata= self::prepareData($data);
            
            $savepurchase = \App\Models\BoughtCoaching::create(['user_id'=>$data['request_data']['user_id'],'price'=>$data['coach_price'],'bill'=>$data['coach_price']*$data['quantity'],'quantity'=>$data['quantity'],'payment_status'=>$capturePayment['success']]);
            if (!$savepurchase) {
                return redirect()->back()->with('Error occurred! please try again');
            }
            $paymentData = self::preparePaymentData($data);

            //dd('$payment saving data',$paymentData);

            $savePayment = \App\Models\CoachPayment::saveData($paymentData);
            
            $availableslot = \App\Models\AvailableBookingCount::where('user_id',$data['request_data']['user_id'])->first();
            if($availableslot != NULL){
                $book_count = $availableslot->booking_count+$data['quantity'];
            }
            else {
                $book_count = $data['quantity'];
            }
            //add booking count
            $saveCount = \App\Models\AvailableBookingCount::updateOrCreate(['user_id' => $data['request_data']['user_id']],[ 'booking_count' => $book_count]);
            if (!$savePayment) {
                return redirect()->back()->with('Error occurred! please try again');
            }
            Session::flash('success', 'Payment successful!');
            return redirect()->route('meeting')->with('Payment Done Successfully!, Please Proceed further with booking');
        } else {
            return redirect()->back()->with('Error occurred! please try again');
        }
    }catch(Exception $e){
        return redirect()->back()->with($e->getMessage());

    }

    }
    public static function prepareData($subscriptionData) {
        $data = [];
        return $data;
    }
    public static function createPaymentMethod($data = []) {

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

    public static function preparePaymentData($data) {
        $paymentData['price'] = $data['coach_price'];
        $paymentData['bill'] = $data['coach_price']*$data['quantity'];
        $paymentData['quantity'] = $data['quantity'];
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
        public static function createPaymentIntentMethod($data = []) {
        $key = Stripe\Stripe::setApiKey(config('paths.secret_key'));
        $discount = 0;
        $stripe = new \Stripe\StripeClient(config('paths.secret_key'));
        $intent = Stripe\PaymentIntent::create([
                    "amount" => $data['coach_price'] * $data['quantity'] *100,
                    "currency" => "usd",
                    'payment_method' => $data['payment_method_data']->id,
                    'payment_method_types' => ['card'],
//                    "source" => $request->stripeToken,
//                    "description" => "Test payment from itsolutionstuff.com."
        ]);
        if ($intent) {
            return ['success' => true, 'data' => $intent];
        } else {
            return ['success' => false];
        }

//        Session::flash('success', 'Payment successful!');
//        return redirect()->route('membershipPlans')->with('Subscribed Successfully!');
    }

    public static function capturePaymentIntentMethod($data = []) {

//        $key = Stripe\Stripe::setApiKey(config('paths.secret_key'));
        $stripe = new \Stripe\StripeClient(config('paths.secret_key'));
        $capture = $stripe->paymentIntents->confirm(
                $data['intent_data']->id,
                [
                    'payment_method_types' => ['card'],
                ]
        );
//        Stripe\PaymentIntent::capture(
//                $data['data']->id,
//                [
//                    "amount" => 100 * 100,
//                    "currency" => "usd",
//                    'payment_method_types' => ['card'],
//                    "source" => $request->stripeToken,
//                    "description" => "Test payment from itsolutionstuff.com."
//        ]);
        if ($capture) {
            return ['success' => true, 'capture_data' => $capture];
        } else {
            return ['success' => false];
        }

//        Session::flash('success', 'Payment successful!');
//        return redirect()->route('membershipPlans')->with('Subscribed Successfully!');
    }

    public function createBooking(Request $request) {
        $inputs = $request->toArray();
        $prepareBooking = [];
//        $uri = $inputs['invitee_url'];
        $urlArray = (explode("/", $inputs['invitee_url']));
        $firstKey = array_search('scheduled_events', $urlArray);
        $secondKey = array_search('invitees', $urlArray);
        $data = [
            'event_uuid' => $urlArray[$firstKey + 1],
            'invitee_uuid' => $urlArray[$secondKey + 1],
            'booking_uri' => $inputs['invitee_url'],
//            'user_id' => 4,
            'user_id' => Auth::user()->id,
        ];

//        $eventUuid = $urlArray[$firstKey + 1];
//        $inviteeUuid = $urlArray[$secondKey + 1];
        // get calendaly event
        if (!empty($data['event_uuid'])) {
            $getCalendalyData = self::getCalendalyData($data);
            $prepareBooking = self::prepareCheckCalendalyData($getCalendalyData, $data);
        }
        if (!empty($prepareBooking)) {
            //save Booking
            $save = \App\Models\EventBooking::saveBooking($prepareBooking);
            $updateCount = \App\Models\AvailableBookingCount::decrementCount($prepareBooking['user_id']);
            if (empty($save)) {
                return ['success' => false, 'message' => 'Error occurred while saving booking data'];
            }
        }

        return ['success' => true];
    }

    public static function getCalendalyData($data = []) {
        $ch = curl_init();
        $url = 'https://api.calendly.com/scheduled_events/' . $data['event_uuid'];
        $token = config('paths.calendaly_token');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Authorization: Bearer ' . $token;
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Cookie: __cf_bm=_bc1mQ4n_2RjPvK6586zGI9gWrylYgFbvHnFtOvdH0Q-1674992760-0-AeTEMYkwO6TeCKOe0v0K8gKvjaqTXL29Yv92X4y/Ic1fayMs8usFCt1sC1cU9vquMQYcotJZ9pifXSb8h7CMg1A=';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            return ['success' => false, 'data' => curl_error($ch)];
        }
        curl_close($ch);
        return json_decode($result);
    }

    public static function prepareCheckCalendalyData($data = [], $requestData = []) {
        $booking = [];
        if (!empty($data->resource)) {
//            $booking['start_time'] = isset($data->resource->start_time) ? $data->resource->start_time : null;
//            $booking['end_time'] = isset($data->resource->end_time) ? $data->resource->end_time : null;
            $booking['start_time'] = isset($data->resource->start_time) ? date('Y-m-d H:i:s', strtotime($data->resource->start_time)) : null;
            $booking['end_time'] = isset($data->resource->end_time) ? date('Y-m-d H:i:s', strtotime($data->resource->end_time)) : null;
            $booking['name'] = isset($data->resource->name) ? $data->resource->name : null;
            $booking['status'] = isset($data->resource->status) ? $data->resource->status : null;
        }
        if (!empty($requestData)) {
            $booking['booking_uri'] = isset($requestData['booking_uri']) ? $requestData['booking_uri'] : null;
            $booking['event_uuid'] = isset($requestData['event_uuid']) ? $requestData['event_uuid'] : null;
            $booking['invitee_uuid'] = isset($requestData['invitee_uuid']) ? $requestData['invitee_uuid'] : null;
            $booking['user_id'] = isset($requestData['user_id']) ? $requestData['user_id'] : null;
        }
        return $booking;
    }
    public function postPaymentWithpaypal(Request $request) {
        //die('N/A');
        DB::BeginTransaction();
        $data['request_data'] = $request->toArray();

        $data['request_data']['user_id'] = Crypt::decrypt($request->user_id);
        $data['coach_price'] = \App\Models\GeneralSetting::where('key','booking_credits_price')->pluck('value')->first();
            $data['quantity'] = $request->quantity;
            $currentDate = date('Y-m-d H:i:s');
        
        $currentDate = date('Y-m-d H:i:s');
        
        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new \PayPal\Api\Item();
      
        $data['bill'] = $data['coach_price']*$data['quantity'];
        $item_1->setName("Coaching")
                ->setCurrency('USD')
                ->setQuantity($data['quantity'])
                ->setPrice($data['coach_price']);

        $item_list = new \PayPal\Api\ItemList();
        $item_list->setItems(array($item_1));

        $amount = new \PayPal\Api\Amount();
        $amount->setCurrency('USD')
                ->setTotal($data['bill']);

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Payment for ' . "Coaching" . ' Slots');

        $redirect_urls = new \PayPal\Api\RedirectUrls();
        $redirect_urls->setReturnUrl(\Illuminate\Support\Facades\URL::route('bookstatus'))
                ->setCancelUrl(\Illuminate\Support\Facades\URL::route('bookstatus'));


        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));
        try {
            //dd($payment);
            $createdPayment = $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            //dd($ex);
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return Redirect::route('meeting');
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenience');
                return Redirect::route('meeting');
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
            // $prepareSubscriptionData = self::preparePaypalSubscriptionData($data);
            // $createSubscription = UserSubscribedPlan::saveData($prepareSubscriptionData);
            $savepurchase = \App\Models\BoughtCoaching::create(['user_id'=>$data['request_data']['user_id'],'price'=>$data['coach_price'],'bill'=>$data['coach_price']*$data['quantity'],'quantity'=>$data['quantity'],'payment_status'=>'success']);
            if (!$savepurchase) {
                return redirect()->back()->with('Error occurred! please try again');
            }
            $paymentData = self::preparePayPalPaymentData($data);

            //dd('$payment saving data',$paymentData);

            $savePayment = \App\Models\CoachPayment::saveData($paymentData);
           
            $availableslot = \App\Models\AvailableBookingCount::where('user_id',$data['request_data']['user_id'])->first();
            if($availableslot != NULL){
                $book_count = $availableslot->booking_count+$data['quantity'];
            }
            else
                $book_count = $data['quantity'];

            //add booking count
            $saveCount = \App\Models\AvailableBookingCount::createOrUpdate(['user_id' => $data['request_data']['user_id'], 'booking_count' => $book_count]);

            //-------------------------------------------------------------------------------
            if (!$saveCount) {
                \Session::put('error', 'Slot in not booked yet');
                DB::rollback();
                return Redirect::route('meeting');
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

//            return Redirect::route('status');
            return Redirect::away($redirect_url);
        }
        DB::rollback();
        \Session::put('error', 'Unknown error occurred');
        return Redirect::route('home');
    }

    public function getPaymentStatus(Request $request) {
        DB::BeginTransaction();

        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');
        $payment_id = $request->get('paymentId');

        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            \Session::put('error', 'Payment failed!!!');
            return \Redirect::route('bookSlot');
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

    public static function preparePaypalSubscriptionData($subscriptionData) {
        $data['subscription_id'] = $subscriptionData['subscription']['id'];
        $data['price'] = $subscriptionData['subscription']['price'];
        $data['user_id'] = $subscriptionData['request_data']['user_id'];
        $data['subscription_start_date'] = date('Y-m-d H:i:s');
        if (strtolower($subscriptionData['subscription']['plans']) == 'yearly' || strtolower($subscriptionData['subscription']['plans']) == 'anually') {
            $data['subscription_end_date'] = date('Y-m-d H:i:s', strtotime($data['subscription_start_date'] . ' + 1 years'));
        } elseif (strtolower($subscriptionData['subscription']['plans']) == 'monthly') {
            $data['subscription_end_date'] = date('Y-m-d H:i:s', strtotime($data['subscription_start_date'] . ' + 1 months'));
        } elseif (strtolower($subscriptionData['subscription']['plans']) == 'weekly') {
            $data['subscription_end_date'] = date('Y-m-d H:i:s', strtotime($data['subscription_start_date'] . ' + 1 weeks'));
        }
        $data['paid_with'] = 'paypal';
        $data['is_active'] = 0;
        return $data;
    }

    public static function preparePaypalPaymentData($data) {
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
