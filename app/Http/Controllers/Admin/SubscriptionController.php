<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubscriptionsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionController extends Controller {

    public function getList(SubscriptionsDataTable $datatable) {
        return $datatable->render('admin.subscriptions.subscription-listing');
    }

    public function getSubscriptionView() {
        return view('admin.subscriptions.add-subscription');
    }

    public function saveSubscription(Request $request) {
        $data = self::prepareData($request);
        $save = Subscription::saveData($data);
        if ($save) {
            return redirect()->route('subscription.list')->with('Saved Successfully!');
        } else {
            return redirect()->back()->with('Error occurred! please try again');
        }
    }

    public function updateSubscription(Request $request) {
        $data = self::prepareData($request);
        $data['id'] = $request->id;
        $save = Subscription::updateData($data);
        if ($save) {
            return redirect()->route('subscription.list')->with('Saved Successfully!');
        } else {
            return redirect()->back()->with('Error occurred! please try again');
        }
    }

    public function editSubscription($id) {
        $data = Subscription::getSubscription($id);
        return view('admin.subscriptions.edit-subscription', compact('data'));
    }

    public static function prepareData($request) {
        $inputs['plans'] = $request['plans'];
        $inputs['plan_name'] = $request['plan_name'];
        $inputs['discount_percentage'] = $request['discount_percentage'];
        $inputs['is_access_cource'] = $request['is_access_cource'];
        $inputs['duration'] = $request['duration'];
        $inputs['feedback_video_count'] = $request['feedback_video_count'];
        $inputs['webinar_access'] = ($request['webinar_access'] == 1) ? '1' : '0';
        $inputs['yoodli_access'] = ($request['yoodli_access'] == 1) ? '1' : '0';
        $inputs['price'] = $request['price'];
        $inputs['status'] = $request['status'];
        $inputs['booking_credit'] = $request['booking_credit'] ?? 2;
        $inputs['stripe_product_id'] = $request['stripe_product_id'];

        return $inputs;
    }

}
