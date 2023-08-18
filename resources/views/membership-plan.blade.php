@extends('layouts.landing')
@section('content')
<style>
    @media only screen and (min-width:1200px){
        .plan-body-txt {
            min-height: 347px;
        }
    }

    @media only screen and (min-width:992px){
        .plan-body-txt {
            min-height: 390px;
        }
    }
</style>
<script>
$(document).ready(function () {

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    $(".next").click(function () {

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function (now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({'opacity': opacity});
            },
            duration: 600
        });
    });

    $(".previous").click(function () {

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function (now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
            },
            duration: 600
        });
    });

    $('.radio-group .radio').click(function () {
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });

    $(".submit").click(function () {
        return false;
    });

});
</script>
    <body>
        <!-- MultiStep Form -->
        <div class="col-12 text-center p-0 mt-3 mb-2">
            <div class="">
                <!-- @if (Session::has('success'))
                <div class="alert alert-success text-center">
                    <p>{{ Session::get('success') }}</p>
                </div>
                @endif -->
                <div class="col-md-12 mx-0">
                        <!-- progressbar -->
                        @if(isset($data) && !empty($data))

                        <ul id="progressbar" style="display: flex; justify-content: center;">
                            <li class="active" id="account"><strong class="step-1" style="float: left; margin-left: -8%;">Select
                                    membership</strong></li>
                            <li onclick="paymentPlanFunction()"  id="confirm"><strong class="step-1" style="float: right; margin-right: -8%;">Payment details</strong></li>
                        </ul>
                        <!-- fieldsets -->
                        <fieldset>
                            <form id="membership_plan" method="POST" action="{{route('paymentDetails')}}">
                                @csrf
                                <input type="hidden" id="selected-plan" name="selected-plan">
                            <div class="container">
                                <div class="row">
                                    @if(isset($data['plans']) && !empty($data['plans']))
                                    <?php $i=1;
                                      $divclass = 'membership1';
                                      $saave = 'saave';
                                      $divheading = 'heading';
                                      $style = "border-radius: 6px; min-width: 246px;";
                                      $checkimage = url('images/check.png');
                                      
                                    ?>
                                    @foreach($data['plans'] as $key=>$record)
                                    <?php 
            
                                        if($i>1 && $i%2 == 0){
                                        $divclass = 'membership2';
                                        $saave = 'saave2';
                                        $divheading = 'heading2';
                                        $style = "background-color: #1C1C1C; color: #ffffc8; border: 1px solid #1c1c1c; border-radius: 6px; min-width: 246px;";
                                        $checkimage = url('images/check_black.png');
            
                                      }
                                    ?>
                                    <div class="col-lg-6" style="padding-right: 25px; padding-left: 25px; margin-bottom: 60px;">
                                        <div class="{{$divclass}}">
                                            <div class="mem-btn">
                                                <button class="membership-btn" type="button" style="{{$style}}">{{ isset($record['plan_name']) ? $record['plan_name'] : 'N/A' }}</button>
                                            </div>
                                            <h3 class="price">£{{$record['price']}} per year <span style="font-size: 16px;">+VAT</span></h3>

                                            <p class="{{$saave}}" style="height: 24px;">
                                                @if($key === 1) (Get “The King’s Speech” treatment)@endif</p>

                                            <div class="d-flex align-items-center plan-body-txt">
                                                @if($loop->iteration == 1)
                                                    <div class="text-start">
                                                        <div class="d-flex"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">Access to two new courses every month</p></div>
                                                        <div class="d-flex"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">Access to exercises to practise what you learn</p></div>
                                                        <div class="d-flex"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">5 practise video review[s] by a coach per month</p></div>
                                                        <div class="d-flex"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">Unlimited access to Yoodli, the AI speech coaching technology</p></div>
                                                        <div class="d-flex"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">30% discount on 1:1 coaching sessions</p></div>
                                                        <div class="d-flex"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">A new educational webinar every month</p></div>
                                                        <div class="d-flex"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">1 live monthly group Q&A session with Susie Ashfield</p></div>
                                                        <div class="d-flex"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">1 live monthly group review video session with Susie Ashfield</p></div>
                                                    </div>
                                                @else
                                                    <div class="text-start">
                                                        <div class="d-flex fw-bolder"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">All features of Impact</p></div>
                                                        <div class="d-flex"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">A monthly 30-minute live coaching session with a coach of your choice. Worth over £ 2100</p></div>
                                                        <div class="d-flex"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">Trained actors with years of experience in public speaking will transform you into a communication rockstar</p></div>
                                                        <div class="d-flex"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">A bespoke approach for professionals who want a guided learning experience tailored to their needs</p></div>
                                                    </div>
                                                @endif
                                             {{-- @if($record['is_access_cource'] == 1)
                                            <p class="{{$divheading}} text-start"><span><img src="{{$checkimage}}"></span>Access to all courses</p>
                                            @endif
                                           <p class="{{$divheading}} text-start"><span><img src="{{$checkimage}}"></span>{{$record['duration']}} mins of 1-to-1 with a coach per month</p>
                                            <p class="{{$divheading}} text-start"><span><img src="{{$checkimage}}"></span>{{$record['discount_percentage']}}% discount on further 1-to-1 coaching sessions</p>
                                            <p class="{{$divheading}} text-start"><span><img src="{{$checkimage}}"></span>Coach feedback on {{$record['feedback_video_count']}} videos on Yoodli per month</p>
                                            @if($record['webinar_access'] == '1')
                                            <p class="{{$divheading}} text-start"><span><img src="{{$checkimage}}"></span>Access to webinars and other pre-recorded content</p>
                                            @endif
                                            
                                            @if($record['yoodli_access'] == '1')
                                            <p class="{{$divheading}} text-start"><span><img src="{{$checkimage}}"></span>Access to Yoodli</p>
                                            @endif --}}
                                            </div>
                                            @if(auth()->check())
                                            <?php 
            
                                                $route = route('paymentDetails',['subscription_id'=>(Crypt::encrypt($record['id']))]);
                                                $label = "Start membership";
                                            ?>
                                            @else
                                                   <?php
                                                    $route = route('register');
                                                    $label = "Start membership";
                                                    ?>
                                             @endif 
                                            <button  class="start-membership" value="{{$record['id']}}" style="{{$style}}">{{$label}} </button> 
                                        </div>
                                    </div>
                                    <?php $i++;  ?>
                                     @endforeach
                                     @endif
                                </div>
                            </div> 
                        </form>  
                        </fieldset>
                        @else
                        <h1>No Plan Available</h1>
                        @endif
                    </form>
                   @if(!isset($data['hide_free_signup']))
                    <form id="sign-up-free" method="POST" action="{{route('free-plan')}}">
                        @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12" style="padding-right: 25px; padding-left: 25px;">
                                <div class="align-items-center justify-content-center">
                                    <div class="Sign " style="border: 1px solid;">
                                        <h5 style="color: #1C1C1C; font-size:24px; font-weight:500; margin-bottom: 4%; margin-top: 0%;" class="text-start">Sign up for Free</h5>
                                        <p class="heading2 text-start" style="margin-bottom: 12px;">
                                            <img src="{{ asset('images/check.svg') }}" alt="" style="margin-right: 1%;">
                                            <?= isset($setting->free_sign_up)?$setting->free_sign_up:'Access to webinars and other pre-recorded content'?>
                                            {{-- <span><img src="{{url('images/')}}/free-white.png"></span> --}}
                                        </p>
                                        <p class="heading2 text-start" style="margin-bottom: 24px;">
                                            <img src="{{ asset('images/check.svg') }}" alt="" style="margin-right: 1%;">
                                            <?= isset($setting->free_sign_up)?$setting->free_sign_up:'Access to Yoodli, the AI speech coaching technology'?>
                                            {{-- <span><img src="{{url('images/')}}/free-white.png"></span> --}}
                                        </p>
                                        <button class="start-membershiIp" style="background-color:  #1C1C1C; color: #fff;">Sign up for Free</button>
                                        <input type="hidden" name="free_membership" id="free_membership" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                   @endif 
                </div>
            </div>
        </div>
 @endsection
@section('scripts')
<script src="{{ asset('js/payment.js') }}" type="text/javascript"></script>
@endsection