@extends('layouts.landing')
@section('content')

<!-- MultiStep Form -->
<div class="card px-0 pt-4 pb-0 mt-3 mb-3">
    <div class="row">
        <div class="col-md-12 mx-0"> @if (Session::has('error'))
            <div class="alert alert-error text-center">
                <p>{{ Session::get('error') }}</p>
            </div> @elseif(Session::has('success'))
            <div class="alert alert-success text-center">
                <p>{{ Session::get('success') }}</p>
            </div> @endif
            <form role="form" action="{{ route('savePaymentDetail') }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ config('paths.publish_key') }}" id="msform" enctype="multipart/form-data">
             @csrf
                <input type="hidden" name='user_id' value="{{Crypt::encrypt($data['user_id'])}}">
                <input type="hidden" name='subscription_id' value="{{Crypt::encrypt($data['subscription_id'])}}">
                <!-- progressbar -->
                <ul id="progressbar" style="display: flex; justify-content: center;">
                    <li onclick="history.go(-1);" class="active" id="account"><strong style="float: left; margin-left: -8%;">Select
                                    membership</strong></li>
                    <li class='active' id="confirm"><strong style="float: right;  margin-right: -8%;">Payment details</strong></li>
                </ul>
                <!-- fieldsets -->
                <fieldset>
                    <div class="form-card col-lg-12 col-md-6 col-sm-12">
                        <div class="membership-payment">
                            <h1>Payment details</h1>
                            <form id="payment-form" method="post" enctype="multipart/form-data" action="#"> 
                                @csrf
                                <div id="card-element">
                                    <div class="membership-field card">
                                        <label for="exampleInputEmail1" class="form-label">Card number</label>
                                        <input type="text" class="form-control f-img card-number" placeholder="Enter card number" name='card_number' required> <img src="{{asset('/images/credit_card.svg')}}" alt="">
                                        <div class="master-card">
                                            <a href="#"><img src="{{asset('/images/visa.svg')}}" alt=""></a>
                                            <a href="#"><img src="{{asset('/images/m-card.svg')}}" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="membership-field">
                                                <label for="name" class="form-label">Name on Card</label>
                                                <input name='card_name' type="text" placeholder="Name on Card" class="form-control" required> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="membership-field cvc">
                                                <label for="exampleInputEmail1" class="form-label">CVV</label>
                                                <input type="text" name='cvc' class="form-control card-cvc" placeholder="Enter CVV"> 
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="membership-field expiration">
                                                <label for="expiryMonth" class="form-label">Expiry Month</label>
                                                <input name='expiry_month' type="text" class="form-control card-expiry-month" placeholder="MM" required> 
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="membership-field expiration">
                                            <label for="expiryYear" class="form-label">Expiry Year</label>
                                            <input name='expiry_year' type="text" class="form-control card-expiry-year" placeholder="YYYY" required> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="devider-line"></div>
                                    <div class="row" style="margin-bottom: 5%;">
                                        <div class="membership-field m-half"> <span for="exampleInputEmail1" style="font-weight: bold; color: black; font-size: 18px;" class="form-label">Total</span> </div>
                                        <div class="membership-field m-half"> 
                                            <span for="exampleInputEmail1" style="float: right; font-weight: bold; color: #1C1C1C; font-size: 18px;" class="form-label">£@if(isset($subscription['price'])) 
                                                        @php 
                                                        //$discount = $subscription['price']/100*$subscription['discount_percentage'];
                                                        @endphp
                                                        {{-- {{$subscription['price']-$discount}} --}}
                                                        {{$subscription['price']}}
                                                            @endif 
                                                            per 
                                                        @if(isset($subscription['plans'])) 
                                                        {{ $subscription['plans'] == 'halfyearly' ? 'half yearly' : $subscription['plans']}} 
                                                        @endif
                                            </span> 
                                        </div>
                                    </div>
                                     <button type="submit" class="m-payment" style="background-color: #1C1C1C; color: #fff;"> Start membership</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--                            <input type="button" name="previous" onclick="history.go(-1);" class="previous action-button-previous" value="Previous" />-->
                </fieldset>
            </form>
            <fieldset>
            
                <div class="form-card col-lg-12 col-md-6 col-sm-12">
                    <div class="membership-payment-1">
                        <div id="card-element">
                            <form method="post" action="{{route('postPaymentWithpaypal')}}" enctype="multipart/form-data" id="msform"> @csrf
                                <input type="hidden" name='user_id' value="{{Crypt::encrypt($data['user_id'])}}">
                                <input type="hidden" name='subscription_id' value="{{Crypt::encrypt($data['subscription_id'])}}">
                                <button type="submit" class="m-payment"><img src="{{asset('/images/pp.svg')}}" alt=""> Pay with Paypal</button>
                            </form>
                        </div>
                    </div>
                </div>
           
        </fieldset>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    $(".next").click(function() {
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({
                    'opacity': opacity
                });
            },
            duration: 600
        });
    });
    $(".previous").click(function() {
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        //show the previous fieldset
        previous_fs.show();
        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({
                    'opacity': opacity
                });
            },
            duration: 600
        });
    });
    $('.radio-group .radio').click(function() {
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });
    $(".submit").click(function() {
        return false;
    })
});
</script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
$(function() {
    /*------------------------------------------
     --------------------------------------------
     Stripe Payment Code
     --------------------------------------------
     --------------------------------------------*/
    var $form = $(".require-validation");
    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
            inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
            $inputs = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid = true;
        $errorMessage.addClass('hide');
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
            var $input = $(el);
            if($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                e.preventDefault();
            }
        });
        if(!$form.data('cc-on-file')) {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }
    });
    /*------------------------------------------
     --------------------------------------------
     Stripe Response Handler
     --------------------------------------------
     --------------------------------------------*/
    function stripeResponseHandler(status, response) {
        if(response.error) {
            $('.error').removeClass('hide').find('.alert').text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
});
</script>
@endsection('content')
