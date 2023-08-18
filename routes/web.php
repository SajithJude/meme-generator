<?php

use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', [\App\Http\Controllers\SiteController::class, 'index'])
        ->name('index');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::post('free-plan', [App\Http\Controllers\Auth\RegisteredUserController::class, 'freeMemberShipPlan'])->name('free-plan');
});

Route::middleware(['auth','urlrecorder'])->group(function () {
    Route::get('vprofile', function () {
        return view('profile');
    })->name('vprofile');
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
     Route::get('landing', [\App\Http\Controllers\SiteController::class, 'index'])
        ->name('landing');
    Route::get('profile', [\App\Http\Controllers\SiteController::class, 'profile'])
           // ->middleware('password.confirm')
            ->name('profile');

    Route::post('profileImage', [\App\Http\Controllers\SiteController::class, 'profileImage']);
    Route::post('update-password', [\App\Http\Controllers\SiteController::class, 'updatePassword'])->name('update.user.password');

    Route::get('editprofile', [\App\Http\Controllers\SiteController::class, 'editProfile'])->name('editprofile');
    Route::get('editaboutus', [\App\Http\Controllers\SiteController::class, 'editAboutUs'])->name('editaboutus');
    Route::post('editprofile', [App\Http\Controllers\Auth\RegisteredUserController::class, 'update']);


    Route::get('course', [App\Http\Controllers\CourseController::class, 'couseView'])->name('course');
    Route::get('courses', [App\Http\Controllers\CourseController::class, 'viewAllCourses'])->name('view.all.courses');
    Route::get('home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
    Route::get('course-lesson/{id}', [App\Http\Controllers\HomeController::class, 'courseLesson'])->name('course-lesson');
    Route::get('course-lesson-number/{id}/{lesson_id}', [App\Http\Controllers\HomeController::class, 'courseLesson'])
        ->name('course-lesson-number');
    Route::get('save_lesson_notes', [App\Http\Controllers\HomeController::class, 'saveLessonNotes']);
    Route::post('download-lesson-notes', [App\Http\Controllers\HomeController::class, 'downloadLessonNotes'])->name('download-lesson-notes');
    Route::get('save_lesson_timestamp', [App\Http\Controllers\HomeController::class, 'saveLessonTimestamp'])
        ->name('save_lesson_timestamp');
    Route::get('signupfree', [AuthenticatedSessionController::class, 'signUpFree']);
    // {user_id}/{subscription_id}


    Route::get('meeting', [App\Http\Controllers\HomeController::class, 'calendly'])->name('meeting');

    Route::get('membership-plans/{id?}', [App\Http\Controllers\SubscriptionController::class, 'membershipPlans'])->name('membershipPlans');
    Route::post('payment-details', [App\Http\Controllers\SubscriptionController::class, 'paymentDetails'])->name('paymentDetails');
    Route::get('/payment-success', [App\Http\Controllers\SubscriptionController::class, 'showPaymentSuccess'])->name('payment.success');
    Route::post('stripe-checkout-success', [App\Http\Controllers\SubscriptionController::class, 'handleCheckoutSuccess'])->name('stripe.checkout.success');
  //  Route::post('payment-details', [App\Http\Controllers\SubscriptionController::class, 'paymentDetails'])->name('paymentDetails');
    Route::post('payment', [App\Http\Controllers\SubscriptionController::class, 'savePaymentDetails'])->name('savePaymentDetail');
//    Route::get('paywithpaypal', [App\Http\Controllers\SubscriptionController::class, 'paywithpaypal'])->name('paywithpaypal');
    Route::post('paypal', [App\Http\Controllers\SubscriptionController::class, 'postPaymentWithpaypal'])->name('postPaymentWithpaypal');
    Route::get('paypal', [App\Http\Controllers\SubscriptionController::class, 'getPaymentStatus'])->name('status');
    Route::get('book-slot', [App\Http\Controllers\BookingController::class, 'bookSlot'])->name('bookSlot');
    Route::post('bookwithpaypal', [App\Http\Controllers\BookingController::class, 'postPaymentWithpaypal'])->name('bookwithpaypal');
    Route::get('bookwithpaypal', [App\Http\Controllers\BookingController::class, 'getPaymentStatus'])->name('bookstatus');
    Route::get('webinars', [App\Http\Controllers\WebinarController::class, 'getWebinars'])->name('getWebinars');
    Route::post('book-webinar', [App\Http\Controllers\WebinarController::class, 'bookWebinar'])->name('bookWebinar');
    Route::get('/meeting-payment-success', [App\Http\Controllers\BookingController::class, 'showPaymentSuccess'])->name('meeting-payment.success');
    Route::post('meeting-stripe-checkout-success', [App\Http\Controllers\BookingController::class, 'handleCheckoutSuccess'])->name('meeting.stripe.checkout.success');

Route::get('/deleteWebinar/{id}', [\App\Http\Controllers\Admin\WebinarController::class, 'deleteWebinar'])->name('deleteWebinar');
Route::post('/createBooking', [\App\Http\Controllers\BookingController::class, 'createBooking'])->name('createBooking');

Route::get('book-slot', [App\Http\Controllers\BookingController::class, 'bookSlot'])->name('bookSlot');
Route::post('book-slot', [App\Http\Controllers\BookingController::class, 'bookPaymentSlot'])->name('paybookSlot');

Route::get('practice', [App\Http\Controllers\HomeController::class, 'practise'])->name('practice');

Route::get('course-lesson-detail/{id}/{lesson_id}', [App\Http\Controllers\HomeController::class, 'courseLessonDetail'])->name('course-lesson-detail');



});

Route::get('cookiepolicy', [App\Http\Controllers\HomeController::class, 'cookiepolicy'])->name('cookiepolicy');
Route::get('privacypolicy', [App\Http\Controllers\HomeController::class, 'privacypolicy'])->name('privacypolicy');
Route::get('termofservice', [App\Http\Controllers\HomeController::class, 'termofservice'])->name('termofservice');
