@extends('layouts.main') @section('content') <style>
  .icon-shape {
    display: inline-flex;
    justify-content: center;
    text-align: center;
    vertical-align: middle;
    align-content: center;
    flex-wrap: nowrap;
    align-items: center;
    flex-direction: column;
  }

  .icon-sm {
    width: 20px;
    height: 20px;
  }

  .registerBtn {
    background: #1C1C1C;
    display: block;
    width: 100%;
    border-radius: 6px;
    color: #FFFFC8;
    font-size: 18px;
    line-height: 27px;
    font-family: 'Inter', sans-serif;
    padding: 14px 20px;
  }

  .form-check-input:checked {
    background-color: #000000 !important;
    border-color: #000000 !important;
  }
.hide{
   display:none;
  }
</style>
<div class="container">
  <div class="row">
    <!-- <div class="col-md-12"> @if (Session::has('error')) <div class="alert alert-error text-center">
        <p>{{ Session::get('error') }}</p>
      </div> @elseif(Session::has('success')) <div class="alert alert-success text-center">
        <p>{{ Session::get('success') }}</p>
      </div>
      @endif
    </div> -->
  </div> 
</div>
 <form  action="{{ route('paybookSlot') }}" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ config('paths.publish_key') }}" id="msform1" enctype="multipart/form-data">
<div class="row align-items-center justify-content-center">

            @csrf
               <input type="hidden" name='user_id' value="{{Crypt::encrypt($data['user_id'])}}"><input type="hidden" id='price' name='price' value="{{$data['coach_price']}}">
  <div class="col-lg-6  mt-5 mb-login">
    <h1 class="text-center">Slots Booking</h1>
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
     <div class="row">
      <div class="col-lg-8 mb-4">
        <p style="font-family: 'Inter';font-style: normal;font-weight: 400;font-size: 16px;line-height: 150%;">Select number of slots</p>
      </div>
      <div class="col-lg-4">
        <div class="d-flex justify-content-between">
          <div class="input-group w-auto justify-content-end align-items-center">
            <input type="button" value="-" class="button-minus border rounded-circle  icon-shape icon-sm mx-1 " data-field="quantity">
            <input type="number" step="1" max="10" value="1" name="quantity" class="quantity-field border-0 text-center w-25">
            <input type="button" value="+" class="button-plus border rounded-circle icon-shape icon-sm " data-field="quantity">
          </div>
        </div>
      </div>
     </div>
     <div class="row" style="padding-bottom: 8px;margin-top: 20px;margin-bottom: 32px;border-bottom: 1px solid;margin-right: 3px;margin-left: 0px;">
       <div class="col-12"></div>
     </div>
     <div class="row">
      <div class="col-lg-4">
        <h5>Total</h5>
      </div>
      <div class="col-lg-8 text-right">
        <h5>£<span id="total">{{$data['coach_price']}}</span></h5>
        <p style="font-family: 'Inter';font-style: normal;font-weight: 400;font-size: 14px;line-height: 150%;text-align: right;color: #686868;">
         You have opted for <span id='quantity'>1</span> additional slots (£<span id='cost'>{{$data['coach_price']}}</span> per slot)
        </p>
      </div>
     </div>

     <div class="row error hide">
      <div class="alert alert-error text-center alert-danger">
        <p></p>
      </div>
     </div>
     <button type="submit" class="login-m registerBtn">Book Slots</button>
    </form>
    </br>
    {{-- <form method="post" action="{{route('bookwithpaypal')}}" enctype="multipart/form-data" id="msform"> @csrf <input type="hidden" name='user_id' value="{{Crypt::encrypt($data['user_id'])}}">
      <input type="hidden" name='coach_price' value="{{$data['coach_price']}}">
      <button style="background: #FFFFFF;border: 1px solid #1C1C1C;box-shadow: 0px 2px 20px rgba(0, 0, 0, 0.07);border-radius: 6px;display: block;width: 100%;border-radius: 6px;color: #1C1C1C;font-size: 18px;line-height: 27px;font-family: 'Inter', sans-serif;padding: 14px 20px;" type="submit" class="login-m registerBtn">
        <i class="fa fa-paypal" aria-hidden="true"></i>&nbsp; Pay with Paypal </button>
    </form> --}}
    <br>
  </div>
</div>
</div>
{{-- <script type="text/javascript" src="https://js.stripe.com/v2/"></script> --}}
<script type="text/javascript">
  $(function() {
        /*------------------------------------------
         --------------------------------------------
         Stripe Payment Code
         --------------------------------------------
         --------------------------------------------*/
        // var $form = $(".require-validation");
        // $('form.require-validation').bind('submit', function(e) {
        //   var $form = $(".require-validation"),
        //     inputSelector = ['input[type=email]', 'input[type=password]', 'input[type=text]', 'input[type=file]', 'textarea'].join(', '),
        //     $inputs = $form.find('.required').find(inputSelector),
        //     $errorMessage = $form.find('div.error'),
        //     valid = true;
        //   $errorMessage.addClass('hide');
        //   $('.has-error').removeClass('has-error');
        //   $inputs.each(function(i, el) {
        //     var $input = $(el);
        //     if ($input.val() === '') {
        //       $input.parent().addClass('has-error');
        //       $errorMessage.removeClass('hide');
        //       e.preventDefault();
        //     }
        //   });
        //   if (!$form.data('cc-on-file')) {
        //     e.preventDefault();
        //     Stripe.setPublishableKey($form.data('stripe-publishable-key'));
        //     Stripe.createToken({
        //       number: $('.card-number').val(),
        //       cvc: $('.card-cvc').val(),
        //       exp_month: $('.card-expiry-month').val(),
        //       exp_year: $('.card-expiry-year').val()
        //     }, stripeResponseHandler);
        //   }
        // });
        /*------------------------------------------
         --------------------------------------------
         Stripe Response Handler
         --------------------------------------------
         --------------------------------------------*/
        // function stripeResponseHandler(status, response) {
        //   if (response.error) {
        //     $('.error').removeClass('hide').find('.alert').text(response.error.message);
        //   } else {
        //     /* token contains id, last4, and card type */
        //     var token = response['id'];
        //     $form.find('input[type=text]').empty();
        //     var tokenField = $('<input>').attr({
        //      type: 'hidden',
        //      name: 'stripeToken',
        //      value: token
        //    });
        //     $form.append(tokenField);
        //       $form.get(0).submit();
        //     }
        //   }
        });
</script>
<script type="text/javascript">
  //show hide
  $("#btn_add_card").click(function() {
    //alert("The paragraph was clicked.");
    $("#form-section").toggle();
  });
  $('form').on('submit',function(){
       $('div.loaderImage').show();
  })
  function increaseValue() {
    var value = parseInt(document.getElementById('quantity').value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    $('input#quantity').val(value);
    //document.getElementById('quantity').value = value;
    $('span#cost').text(parseInt($('input#price').val()) * value);
    //alert(parseInt($('span#cost').text()));
  }

  function decreaseValue() {
    var value = parseInt(document.getElementById('quantity').value, 10);
    value = isNaN(value) ? 1 : value;
    if (value > 1) value--;
    //document.getElementById('quantity').value = value;
    $('input#quantity').val(value);
    $('span#cost').text(parseInt($('input#price').val()) * value);
  }
</script>
<script>
  function incrementValue(e) {
    e.preventDefault();
    var fieldName = $(e.target).data('field');
    var parent = $(e.target).closest('div');
    var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
    if (!isNaN(currentVal)) {
      parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
    } else {
      parent.find('input[name=' + fieldName + ']').val(0);
    }
    var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
    $('span#total').text(parseInt($('input#price').val()) * currentVal);
    $('span#quantity').text(currentVal);
  }

  function decrementValue(e) {
    e.preventDefault();
    var fieldName = $(e.target).data('field');
    var parent = $(e.target).closest('div');
    var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
    if (!isNaN(currentVal) && currentVal > 1) {
      parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
    } else {
      parent.find('input[name=' + fieldName + ']').val(1);
    }
    var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);
    $('span#total').text(parseInt($('input#price').val()) * currentVal);
    $('span#quantity').text(currentVal);
  }
  $('.input-group').on('click', '.button-plus', function(e) {
    incrementValue(e);
  });
  $('.input-group').on('click', '.button-minus', function(e) {
    decrementValue(e);
  });
</script> 
@endsection('content')