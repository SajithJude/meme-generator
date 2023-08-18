@extends('layouts.landing')
@section('content')

<style>
    .fun-facts iframe {
        width: 100%;
        height: 500px;
        margin: 0 auto;
        display: block;
        margin-top: 50px;
        border-radius: 12px;
        cursor: pointer;
        background-color: #333333;
    }

    .mb-60px {
        margin-bottom: 60px;
    }
    .hero-heading span{
        font-weight: 500; 
        font-size: 36px; 
        line-height:46px; 
        margin-top: 13px;
    }
    .h-patteren{
        --top-right:10px;
        --bottom-right:50px;
        background: radial-gradient(#ffffc8,#fff);
        z-index:-1;
    }
    .checks img{
        place-self: flex-start;
        margin-top: 5px;
        height:12px;
    }
    .brands-slp , .trusted-by-slp{
  
  position: absolute;
  left: 0;
  right: 0;
  bottom: 35%;
  z-index: 1;
  -webkit-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
          transform: translateY(-50%);
}
.swiper, swiper-container{
z-index: 0 !important;
}
.slp {
position: absolute;
left: 0;
right: 0;
top: 65%;
-webkit-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
      transform: translateY(-50%);
}
.carousal_img {
width: 220px;
height: 60px;
}
.swiper {
width: 90%;
height: 100%;
margin-inline: auto;
}
.swiper-wrapper {
display: -webkit-box;
display: -ms-flexbox;
display: flex;
-webkit-box-align: center;
  -ms-flex-align: center;
      align-items: center;
}
.swiper-slide {
  text-align: center;
  font-size: 18px;
  background: transparent;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
}
.swiper-slide img {
  -webkit-box-flex: 1;
  -ms-flex: 1 0 25%;
  flex: 1 0 25%;
  display: block;
  padding: 0 20px;
  -o-object-fit: contain;
  object-fit: contain;
  margin-inline: auto;
  /* height: 250px; */
}
.swiper-button-next,
.trusted-by-swiper-button-next,
.trusted-by-swiper-button-prev,
.swiper-button-prev {
color: #000 !important;
}
.testimonials-swiper-button-prev:after,
.trusted-by--swiper-button-prev:after,
.swiper-rtl .swiper-button-next:after {
height: 277px !important;
}
.swiper-button-prev:after,
.trusted-by-swiper-button-prev:after,
.swiper-rtl .swiper-button-next:after,
.swiper-rtl .trusted-by-swiper-button-next:after {
font-size: 44px !important;
font-weight: 900;
height: auto;
width: 101px;
}
.swiper-button-next:after,
.trusted-by-swiper-next:after,
.swiper-rtl .swiper-button-prev:after,
.swiper-rtl .trusted-by-swiper-button-prev:after {
font-size: 44px !important;
font-weight: 900;
height: auto;
width: 101px;
}
.testimonials-swiper-button-next:after,
.swiper-rtl .swiper-button-prev:after,
.swiper-rtl .trusted-by-swiper-button-prev:after{
height: 277px;
}
.brands, .trusted-by {
width: 100%;
padding-top: 50px;
padding-bottom: 10px;
position: relative;
}

.swiper-button-next, .swiper-button-prev{
  margin-top: calc(-7px - (var(--swiper-navigation-size)/ 2));
}
.testimonials-container {
  margin-top: 3rem;
}
/* 
#testimonials > h3 {
  text-align: center;
  color: var(--color-primary-yellow);
} */

.testimonials-img > img {
  border-radius: 50%;
  aspect-ratio: 1/1;
  height: 100px;
  width: 100px;
  margin-bottom: 1rem;
  padding: 0;
}

.testimonials-card {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  margin: 1rem 2rem;
  line-height: 36px;
  font-weight: 300;
  width: 50%;
  margin-inline: auto;
  font-size: 1.6rem;

}

.testimonials-card > p {
  font-size: 1.2rem;
  text-align: center;
}

    @media only screen and (min-width:1200px){
        .plan-body-txt {
            min-height: 347px;
        }
    }

    @media only screen and (min-width:992px){
        .fun-facts iframe {
            width: 800px;
        }
        .plan-body-txt {
            min-height: 390px;
        }
    }

    @media only screen and (min-width:769px) and (max-width:991px){
        .h-patteren{
            width: 120% !important;
        }
    }
    
    @media only screen and (max-width:768px){
        .fun-facts iframe {
            width: 100% !important;
        }
        img.h-patteren{
            top: 35% !important;
        }
        .h-patteren{
            width: 100% !important;
        }
        .hero-heading h1{
            font-size: 3.5rem;
        }
        .hero-heading span{
            font-weight: 500; 
            font-size: 1.75rem; 
            line-height:46px; 
            margin-top: 13px;
        }
        .testimonials-card {
    width: 70%;
    line-height: 1.5;
    font-size: 24px;
    margin: auto;
  }
    }
    @media only screen and (max-width:576px){
        img.h-patteren{
        top:20% !important;
    }
    .hero button{
        padding: 16px 38px !important;
    }
    .fun-facts iframe{
        width: 100%;
        height: 350px;
    }
    .testimonials-card > p{
  font-size: 0.8rem;
}
    }
    @media screen and (max-width: 425px){
        .swiper.mySwiper-1{
width: 100% !important;
        }
        .testimonials-card{
  width: 70%;
  font-size: 20px;
  line-height: 1.5;
}
.swiper-button-prev:after, .trusted-by-swiper-button-prev:after, .swiper-rtl .swiper-button-next:after, .swiper-rtl .trusted-by-swiper-button-next:after{
    font-size: 2rem !important;
}
.swiper-button-next:after, .trusted-by-swiper-next:after, .swiper-rtl .swiper-button-prev:after, .swiper-rtl .trusted-by-swiper-button-prev:after{
    font-size: 2rem !important;
}
.testimonials-swiper-button-next{
    right: 0 !important;
}
.testimonials-swiper-button-prev{
    left: 0 !important;
}
    }
    @media (max-width: 1024px) {
  .testimonials-card {
    margin: 1rem 12rem;
    margin-inline: auto;
    line-height: 1.8;
    width: 80%;
  }
}
  
</style>
@php
$promo_video_link = \App\Models\GeneralSetting::where('key','landing_page_video')->pluck('value')->first();

@endphp
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

<div class="hero">
    <div class="container">
        <div class="hero-top">
            <div class="hero-heading">
                <img src="{{ asset('images/heading-bg2.svg') }}"
                    class="h-patteren">
                <h1>From muddled to mesmerising </h1>
                <span>Share your story. Communicate to<br>connect. Frame, practice and deliver<br>talks that blow others away. </span>
            </div>
            <a href="{{route('register')}}" style="text-decoration: none;">
                <button>Join the Academy <img src="{{ asset('images/ar.svg') }}" alt=""></button>
            </a>
        </div>
    </div>
</div>

<div class="happy-client">
    <div class="container">
        <h2 class="mb-7">As featured in</h2>
        <div class="brands">
                <div class="container position-relative">
                    <div class="brands-slp">
                        <div id="brands-next" class="swiper-button-next"></div>
                        <div id="brands-prev" class="swiper-button-prev"></div>
                    </div>
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/featured/Black')}}/city-am.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/featured/Black')}}/Daily Express.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/featured/Black')}}/Daily Mail black.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class=" "  >
                                <img src="{{url('images/featured/Black')}}/ELLE.png" alt="logo images"
                                    class="carousal_img ">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/featured/Black')}}/Forbes.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class=" "  >
                                <img src="{{url('images/featured/Black')}}/Stylist.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>           <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/featured/Black')}}/The Independent.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/featured/Black')}}/The Telegraph.png" alt="logo images"
                                    class="carousal_img ">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/featured/Black')}}/The Times.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/featured')}}/Metro.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/featured')}}/New York Post.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/featured')}}/We Are The City.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          
                        </div>
                        
                      </div>

                </div>
            </div>
    </div>
</div>


<div class="fun-facts">
    <div class="container">
        <!--  <video width="800" height="500" controls poster="{{url('images/')}}/Frame_29.png"> -->
        <iframe width="100%" src="{{ isset($promo_video_link) ? $promo_video_link.'?rel=0&autoplay=0&controls=0&modestbranding=1&origin=https://academy.susieashfield.com/' : 'https://www.youtube.com/embed/sIBcQil9ARA?rel=0&autoplay=0&controls=0&modestbranding=1&origin=https://academy.susieashfield.com/' }}" title="Introduction Video" frameborder="0"  allowfullscreen id="youtube_player"></iframe>
        {{-- <video width="800" height="500" controls>
            <source src="<?= isset($setting->promo_video_link)?$setting->promo_video_link:'movie.mp4'?>"
                type="video/mp4"> --}}
            <!-- <source src="movie.ogg" type="video/ogg"> -->
            {{-- Your browser does not support the video tag.
        </video> --}}
        <div class="fun-stats">
            <h2><span>Learn the art of public speaking</span> with Susie Ashfield</h2>
            <p>Join with a yearly membership and get access to free webinars, personalised coaching and a community of people like you</p>
            <div class="facts">
                <span class="text-center"><b class="counter">2</b>New courses<br>every month</span>
                <span class="text-center"><div><b class="counter">60</b><b>+</b></div>Engaging<br>lessons</span>
                <span class="text-center"><div><b class="counter">30</b><b>+</b></div>Tried and tested<br>exercises</span>
            </div>
            <div class="row checks" style="font-size: 16px; max-width: 808px; width:100%;">
                <div class="d-flex col-md-6 p-0 mb-2"><img src="{{url('images/')}}/check.svg" alt="" class="mr-2">Learn at your own pace</div>
                <div class="d-flex col-md-6 p-0 mb-2"><img src="{{url('images/')}}/check.svg" alt="" class="mr-2">Practice your pitch and get feedback from a pro</div>
                <div class="d-flex col-md-6 p-0 mb-2"><img src="{{url('images/')}}/check.svg" alt="" class="mr-2">Free Webinars to boost your skills further</div>
                <div class="d-flex col-md-6 p-0 mb-2"><img src="{{url('images/')}}/check.svg" alt="" class="mr-2">Get access to the best coaches in the field</div>
            </div>
        </div>
    </div>
</div>

<div class="testimonial">
    <div class="container">

        <h2><span>Sceptical?</span> So were they. </h2>
        <div class="container p-0">
                <div class="swiper mySwiper-1 w-100">
                    <div class="testimonials-swiper-button-next swiper-button-next"></div>
                    <div class="swiper-button-prev testimonials-swiper-button-prev"></div>
                    <div class="swiper-wrapper">
                      <div class="swiper-slide">
                        <div class="testimonials-card">
                            <p>If you are looking to get better at speaking, presenting, getting your message across or working with someone who can take your public speaking to the next level, look no further. Susie's 1:1 coaching, Academy, and workshops are all so brilliant, you won't go wrong in working with Susie if you want to communicate more effectively.</p>
                            <div class="testimonials-img">
                                <img src="{{asset('images/Testimonials')}}/stock_testimonial_1.jpg" alt="logo images">
                            </div>
                            <small>Sam Rathling</small>
                            <p>LinkedIn Expert</p>
                        </div>
                      </div>
                      <div class="swiper-slide">
                        <div class="testimonials-card">
                            <p>What helps Susie stand out from other speaking programs is that Susie helped me harness my authenticity as a presenter and storyteller, which I've learned is more impactful than the details I was so hung up on in the first place. Thank you, Susie! So grateful to have had your expertise- and better for it!</p>
                            <div class="testimonials-img">
                                <img src="{{asset('images/Testimonials')}}/stock_testimonial_2.jpg" alt="logo images">
                            </div>
                            <small>Jill Brewer Trainor</small>
                            <p>Global Marketing Operations at Google</p>
                        </div>
                      </div>
                      <div class="swiper-slide">
                        <div class="testimonials-card">
                            <p>If you are looking to start a journey in public speaking or just crave the confidence to speak up in meetings! Look no further, Susie has the ability to knock those jitters out and actually gets you to enjoy presenting or speaking out. </p>
                            <div class="testimonials-img">
                                <img src="{{asset('images/Testimonials')}}/stock_testimonial_3.jpg" alt="logo images">
                            </div>
                            <small>Vinny Wagjiani</small>
                            <p>Coach</p>
                        </div>
                      </div>
                      <div class="swiper-slide">
                        <div class="testimonials-card">
                            <p>Susie has hugely helped me and some of our team to speak with confidence and clarity, especially to large groups of people in stressful situations. I can't recommend her highly enough.</p>
                            <div class="testimonials-img">
                                <img src="{{asset('images/Testimonials')}}/stock_testimonial_2.jpg" alt="logo images">
                            </div>
                            <small>Derek Moore</small>
                            <p>CEO of Coffee & TV Group</p>
                        </div>
                      </div>
                      <div class="swiper-slide">
                        <div class="testimonials-card">
                            <p>Thanks for being my personal trainer and making me do my reps. I felt amazing in delivering in the end…and learned to
                            relax. I had lots of positive feedback from different levels of understanding – so pitch was perfect!</p>
                            <div class="testimonials-img">
                                <img src="{{asset('images/Testimonials')}}/stock_testimonial_3.jpg" alt="logo images">
                            </div>
                            <small>Harsha Patel</small>
                            <p>Senior Investment Manager - Railpen Investments</p>
                        </div>
                      </div>
                    </div>

                  </div>
                



            </div>
        <!-- <div class="reviews">
            <div class="review">
                <div class="client">
                    <img src="./images/r1.png" alt="">
                    <h3>Smantha James, CEO at Rivago</h3>
                </div>
                <p>“ Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.“</p>
            </div>

            <div class="review">
                <div class="client">
                    <img src="./images/r2.png" alt="">
                    <h3>Smantha James, CEO at Rivago</h3>
                </div>
                <p>“ Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.“</p>
            </div>
        </div> -->
    </div>
</div>


<div class="happy-client">
    <div class="container">
        <h2 class="mb-5">Trusted by</h2>
        <div class="trusted-by">
                <div class="container position-relative">
                    <div class="trusted-by-slp">
                        <div id="trusted-next" class="swiper-button-next"></div>
                        <div id="trusted-prev" class="swiper-button-prev"></div>
                    </div>
                    <div class="swiper trusted-by-swiper">
                        <div class="swiper-wrapper">
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/trustedby/Black')}}/Lancashire.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/trustedby/Black')}}/Lloyds.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/trustedby/Black')}}/Rolls Royce.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class=" "  >
                                <img src="{{url('images/trustedby/Black')}}/Walt Disney.png" alt="logo images"
                                    class="carousal_img ">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/trustedby')}}/Coca Cola.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class=" "  >
                                <img src="{{url('images/trustedby')}}/Debretts.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>           <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/trustedby')}}/Generali.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/trustedby')}}/NATO OTAN.png" alt="logo images"
                                    class="carousal_img ">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/trustedby')}}/Royal Bank of Scotland.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/trustedby')}}/S_P Global.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/trustedby')}}/Santander-Logo.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          <div class="swiper-slide">
                            <div class="">
                                <img src="{{url('images/trustedby')}}/The Wine Society 1874.png" alt="logo images"
                                    class="carousal_img">
                            </div>
                          </div>
                          
                        </div>
                        
                      </div>

                </div>
            </div>
    </div>
</div>
<section class="membership">
    <h1 class="mt-5 mb-5"
        style="display: flex; justify-content: center; color: #1C1C1C; font-weight: 500; font-size: 40px;text-align:center;"> Membership
        Plans</h1>
    <div class="container">
        <div class="row">
            @if(isset($data) && !empty($data))
            <?php $i=1;
                          $divclass = 'membership1';
                          $saave = 'saave';
                          $divheading = 'heading';
                          $style = "border-radius: 6px; min-width: 246px;";
                          $checkimage = url('images/check.png');
                          
                        ?>
            @foreach($data as $key=>$record)
            <?php 

                            if($i>1 && $i%2 == 0){
                            $divclass = 'membership2';
                            $saave = 'saave2';
                            $divheading = 'heading2';
                            $style = "background-color: #1C1C1C; color: #ffffc8; border: 1px solid #1c1c1c; border-radius: 6px; min-width: 246px";
                            $checkimage = url('images/check_black.png');

                          }
                        ?>
            <div class="col-lg-6 mb-60px" style="padding-right: 25px; padding-left: 25px;">
                <div class="{{$divclass}}">
                    <div class="mem-btn">
                        <button class="membership-btn" style="{{$style}}">{{ isset($record['plan_name']) ? $record['plan_name'] : 'N/A' }}</button>
                    </div>
                    <h3 class="price">£{{$record['price']}} per year <span style="font-size: 16px;">+VAT</span></h3>

                    <p class="{{$saave}}" style="height: 24px;">
                        @if($key === 1) (Get “The King’s Speech” treatment)@endif</p>

                    <div class="d-flex align-items-center plan-body-txt">
                        @if($loop->iteration == 1)
                            <div>
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
                            <div>
                                <div class="d-flex fw-bolder"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">All features of Impact</p></div>
                                <div class="d-flex"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">A monthly 30-minute live coaching session with a coach of your choice. Worth over £ 2100</p></div>
                                <div class="d-flex"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">Trained actors with years of experience in public speaking will transform you into a communication rockstar</p></div>
                                <div class="d-flex"><p style="margin-right: 12px;"><img src="{{$checkimage}}"></p><p class="{{$divheading}}" style="margin-bottom: 12px;">A bespoke approach for professionals who want a guided learning experience tailored to their needs</p></div>
                            </div>
                        @endif
                        {{-- <p class="{{$divheading}}"><span><img src="{{$checkimage}}"></span></p><p class="{{$divheading}}"><span><img src="{{$checkimage}}"></span></p> --}}
                    {{-- @if($record['is_access_cource'] == 1)
                    <p class="{{$divheading}}"><span><img src="{{$checkimage}}"></span>Access to all courses</p>
                    @endif
                    <p class="{{$divheading}}"><span><img src="{{$checkimage}}"></span>{{$record['duration']}} mins of
                        1-to-1 with a coach per month</p>
                    <p class="{{$divheading}}"><span><img
                                src="{{$checkimage}}"></span>{{$record['discount_percentage']}}% discount on further
                        1-to-1 coaching sessions</p>
                    <p class="{{$divheading}}"><span><img src="{{$checkimage}}"></span>Coach feedback on
                        {{$record['feedback_video_count']}} videos on Yoodli per month</p>
                    @if($record['webinar_access'] == '1')
                    <p class="{{$divheading}}"><span><img src="{{$checkimage}}"></span>Access to webinars and other
                        pre-recorded content</p>
                    @endif

                    @if($record['yoodli_access'] == '1')
                    <p class="{{$divheading}}"><span><img src="{{$checkimage}}"></span>Access to Yoodli</p>
                    @endif --}}
                    </div>
                    @if(auth()->check())
                    <?php 

                                        $route = route('paymentDetails',['user_id'=>(Crypt::encrypt(auth()->user()->id)),'subscription_id'=>(Crypt::encrypt($record['id']))]);
                                        $label = "Start membership";
                                ?>
                    @else
                    <?php
                                        $route = route('register');
                                        $label = "Start membership";
                                        ?>


                    @endif
                    <button class="start-membership" route="{{$route}}" style="{{$style}}">{{$label}} </button>
                </div>
            </div>
            <?php $i++;  ?>
            @endforeach
            @endif


        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="padding-right: 25px; padding-left: 25px;">
                <div class="align-items-center justify-content-center">
                    <div class="Sign " style="border: 1px solid;">
                        <h5 style="color: #1C1C1C; font-size:24px; font-weight:500; margin-bottom: 4%; margin-top: 0%;">Sign up for Free</h5>
                        <p class="heading2" style="margin-bottom: 12px;">
                            <img src="{{ asset('/images/check.svg') }}" alt="" style="margin-right: 1%;">
                            <?= isset($setting->free_sign_up)?$setting->free_sign_up:'Access to webinars and other pre-recorded content'?>
                            {{-- <span><img src="{{url('images/')}}/free-white.png"></span> --}}
                        </p>
                        <p class="heading2" style="margin-bottom: 24px;">
                            <img src="{{ asset('/images/check.svg') }}" alt="" style="margin-right: 1%;">
                            <?= isset($setting->free_sign_up)?$setting->free_sign_up:'Access to Yoodli, the AI speech coaching technology'?>
                            {{-- <span><img src="{{url('images/')}}/free-white.png"></span> --}}
                        </p>
                        <button class="start-membershiIp" style="background-color:  #1C1C1C; color: #fff;"><a style="text-decoration: none; color: #FFF" href="{{url('register')}}">Sign up for Free</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<script type="text/javascript">
    $('button.start-membership').on('click',function(){
        location.replace($(this).attr('route'));
    })
    var swiper = new Swiper(".mySwiper", {
          slidesPerView: 4,
          spaceBetween: 10,
          autoplay: {
        delay: 3000,
      },
      loop: true,
          pagination: {
            el: ".swiper-pagination",
            clickable: true,
          },
          // Responsive breakpoints
    breakpoints: {
        320: {
slidesPerView: 1,

},
375: {
slidesPerView: 1,

},
550: {
slidesPerView: 2,

},
768: {
slidesPerView: 2,

},
1000: {
slidesPerView: 3,

},
1200: {
slidesPerView: 4,

},
    },
    navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
    },
    });

    //Trusted By Swiper
    var trusted_by_swiper = new Swiper(".trusted-by-swiper", {
          slidesPerView: 4,
          spaceBetween: 10,
          autoplay: {
        delay: 3000,
      },
      loop: true,
          pagination: {
            el: ".swiper-pagination",
            clickable: true,
          },
          // Responsive breakpoints
    breakpoints: {
        320: {
slidesPerView: 1,

},
375: {
slidesPerView: 1,

},
550: {
slidesPerView: 2,

},
768: {
slidesPerView: 3,

},
1000: {
slidesPerView: 3,

},
1200: {
slidesPerView: 4,

},
    },
    navigation: {
    nextEl: "#trusted-next",
    prevEl: "#trusted-prev",
    },
    });
    var testimonials_swiper = new Swiper(".mySwiper-1", {
      slidesPerView: 1,
      spaceBetween: 10,
      autoplay: {
    delay: 3000,
  },
  loop: true,
      pagination: {
        el: ".swiper-pagination-2",
        clickable: true,
      },
      // Responsive breakpoints
breakpoints: {

    320: {
slidesPerView: 1,

},
375: {
slidesPerView: 1,

},
550: {
slidesPerView: 1,

},
768: {
slidesPerView: 1,

},
1000: {
slidesPerView: 1,

},
1200: {
slidesPerView: 1,

},
},
navigation: {
nextEl: ".testimonials-swiper-button-next.swiper-button-next",
prevEl: ".testimonials-swiper-button-prev.swiper-button-prev",
},
});
</script>

@endsection('content')