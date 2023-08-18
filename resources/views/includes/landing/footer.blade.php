@php
    $settings = \App\Models\GeneralSetting::all()->toArray();
    foreach($settings as $val){
        $setting[$val['key']] = $val['value'];
    }
@endphp
<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;700&display=swap" rel="stylesheet">    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .contact-us-txt:hover {
        color: #faf8bf !important;
        text-decoration: none !important;
    }
    /* New Design */
    /* Footer Start */
#footer-div {
  font-family: 'Inter';
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: justify;
      -ms-flex-pack: justify;
          justify-content: space-between;
  margin-top: 3rem;
  background-color: #1c1c1c;
  color: #fff;
  padding: 2rem 6.4rem 2rem 5rem;
  place-items: flex-start;
}
#logo img{
  height: 80px;
}
#email > h2,
#follow-us > h2 {
  font-family: 'Inter';
  text-align: center;
  font-size: 28px;
  color: #fcf7be;
  margin-bottom: 1rem;
}

.footer-email {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  font-size: 20px;
}
a.mail-link{
    color: #fff;
}
a.mail-link:hover , #footer-div a:hover{
opacity: 0.7;
color: white;
}
.footer-envelope {
  margin-right: 8px;
  font-size: 35px;
  color: #ffff97;
}
.footer-follow{
    display: flex;
}
.footer-follow a{
    margin-inline: auto;
}
.follow-icon {
  font-size: 35px;
  margin: 5px 10px;
  color: #ffff97;
}

footer {
  font-family: 'Inter';
  -webkit-box-pack: justify;
      -ms-flex-pack: justify;
          justify-content: space-between;
  padding: 0.3rem 5rem 0.3rem 5rem;
  height: 100px;
  place-items: center;
  border-top: 1px solid #FCF7BE;
}

a {
  text-decoration: none;
}
.copyright-bigger-text{
  font-size: 1rem;
  font-weight: 800;
}
.inline-grid-display{
  display: -ms-inline-grid;
  display: -moz-inline-grid;
  display: inline-grid;
  margin-right: 0;
}
.love-text a{
  font-size: 0.8rem;
  font-weight: 300;
  text-align: center;
}
.love-text b{
color: red;
}
footer ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
}

footer li , footer li a{
  display: -webkit-inline-box;
  display: -ms-inline-flexbox;
  display: inline-flex;
  margin: 2px 10px;
  font-size: 20px;
  font-weight: 600;
  line-height: 120%;
  color: #fcf7be;
}
footer li a:hover{
  color: #fcf7be;
  opacity: 0.7;
}
footer p {
  color: #fcf7be;
  font-size: 11px !important;
  margin-bottom: 0;
}
@media only screen and (min-width:769px) and (max-width:992px) {
    footer{
    padding: 0.3rem 4rem 0.3rem 4rem !important;
  }
  footer p{
    text-align: left;
  }
  footer li{
    font-size: 0.8rem;
    margin: 2px 3px;
  }
 footer li a{
    font-size: 1rem !important;
    margin: 2px 0 !important;
  }
  .love-text a{
    font-size: 0.6rem !important; 
  }

}
@media only screen and (max-width: 768px){
    #email {
    padding: 0rem 0rem 0rem 0rem;
  }
hr{
  margin-bottom: 1rem !important;
}
  footer {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
        -ms-flex-pack: justify;
            justify-content: space-between;
    padding: 0.3rem 0.2rem;
  }
.copyright-div{
  text-align: center !important;
  padding: 1rem !important;
}
  footer p {
    color: #fcf7be;
    font-size: 1rem !important;
    margin-bottom: 0;

  }

  #footer-div {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: row;
            flex-direction: row;
    -webkit-box-pack: justify;
        -ms-flex-pack: justify;
            justify-content: space-between;
    text-align: center;
    place-items: center;
    padding: 1rem;
  }
  #logo img{
  height: 60px;
}
footer{
  display: contents !important;
}
  footer ul{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    justify-content: center;
  }
  footer li {
    float: right !important;
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    margin: 2px 16px !important;
    font-size: 12px !important;
    color: #fcf7be;
  }
  footer li, footer li a{
    float: right !important;
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    margin: 2px 8px !important;
    font-size: 12px !important;
    color: #fcf7be;
  }
  .love-text a{
    font-size: 0.6rem !important;
  }
  .footer-email {
    display: block;
  }

  #email > h2,
  #follow-us > h2 {
    font-size: 1rem;
    color: #fff;
  }
}
@media only screen and (max-width:576px){
    .copyright-div{
    text-align: center;
    padding: 1rem;    
  }
  #footer-div{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: column;
            flex-direction: column;
    -webkit-box-pack: justify;
        -ms-flex-pack: justify;
            justify-content: space-between;
    text-align: center;
    place-items: center;

  }
  footer li{
    font-size: 9px !important;
  }
  footer{
  display: contents !important;
}
footer > .row:first-child {
  margin-inline: auto;
  background: #1c1c1c !important;
}
footer ul{
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
          padding-bottom: 1rem !important;
}
footer li, footer li a{
  margin: 2px 4px !important;
  font-size: 13px !important;
}
.love-text a{
  font-size: 0.5rem !important;
  font-weight: 300;
}

}
</style>
<div id="footer-div">
        <div id="logo">
          <a href="{{ Auth::check() ? '/home' : '/' }}"><img class="css-class cursor-pointer" src="{{url('logo/footer-yellow-logo.svg')}}" alt="logo" /></a>
        </div>
        <div id="email">
            <h2>Contact Us</h2>
            <div class="footer-email">
            <i class="far fa-envelope footer-envelope"></i>
                <p> <a class="mail-link" href="mailto:info@speaktoimpact.com">academy@susieashfield.com</a></p>
            </div>
        </div>
        <div id="follow-us">
            <h2>Follow Us</h2>
            <div class="footer-follow">
                <a href="<?=isset($setting['linkedin_link'])?$setting['linkedin_link']:'https://www.linkedin.com/in/susannahashfield/' ?>" target="_blank"><i class="fab fa-linkedin follow-icon"></i></a>
                <a href="<?=isset($setting['instagram_link'])?$setting['instagram_link']:'https://www.instagram.com/speak2impact/' ?>" target="_blank"><i class="fab fa-instagram follow-icon"></i></a>
                <a href="<?=isset($setting['tiktok_link'])?$setting['tiktok_link']:'https://www.tiktok.com/@smashfield89' ?>" target="_blank"><i class="fab fa-tiktok follow-icon"></i></a>
            </div>
            <br/>
        </div>
    </div>
    <footer>
        <div class="row w-100" style="background: #1c1c1c; margin-inline:auto;">
            <div class="col-12 col-sm-12 col-md-5 col-lg-4 pr-0 copyright-div">
              <p class=""><span class="copyright-bigger-text">&copy; 2023 Speak2Impact Limited.</span><br>All rights reserved Registered in England | Company Reg.No.09470705</p>
            </div>

        <div class="col-12 col-sm-12 col-md-7 col-lg-8 pl-0 pr-0 text-right text-end">
            <ul>
                <li><a href="{{url('cookiepolicy')}}" target="_blank">Cookie Policy</a></li>
                <li><a href="{{url('privacypolicy')}}" target="_blank">Privacy Policy</a></li>
                <li class="inline-grid-display"><a href="{{url('termofservice')}}" target="_blank">Terms of Service</a><span class="love-text"><a href="https://www.firstloop.se" target="_blank">Made with<b>&nbsp;❤️&nbsp;</b>by First Loop</a></span></li>
            </ul>
        </div>
    </footer>
<!-- <footer style="margin-top: 15px;width: 100%;position: absolute; margin-bottom: 0px;">
    <div class="container">
        <div class="footer">
            <div class="row">
                <div class="col-md-2">
                    <div class="logo">
                        <a href="{{ Auth::check() ? '/home' : '/' }}"><img src="{{url('logo/footer-yellow-logo.svg')}}" height="80px" class="css-class cursor-pointer" alt="alt text"></a>
                    </div>
                </div>
                <div class="col-md-6 offset-sm-1">
                    <h3 style="color:#FFFFC8; text-align: center;">©️ {{env('APP_NAME')}} <?= date('Y');?></h3>
                    <div class="footer-link">
                        <a href="{{url('cookiepolicy')}}" class="px-4 ">Cookie Policy</a>
                        <a href="{{url('privacypolicy')}}" class="px-4">Privacy Policy</a>
                        <a href="{{url('termofservice')}}" class="px-4">Terms of Service</a>
                    </div>
                </div>
                <div class="col-md-2 offset-sm-1">
                    <div class="footer-links">
                        <a href="javascript:" class="contact-us-txt">Contact us</a>
                        <a href="javascript:" class="contact-us-txt"><?=isset($setting->contact_email)?$setting->contact_email:"academy@susieashfield.com"?></a>
                    </div>
                    <div class="social-icon">
                        <a href="<?=isset($setting['instagram_link'])?$setting['instagram_link']:'https://www.instagram.com/speak2impact/' ?>" target="_blank"><img src="{{url('images/')}}/instagram.svg" width="28px" height="28px" alt=""></a>
                        <a href="<?=isset($setting['tiktok_link'])?$setting['tiktok_link']:'https://www.tiktok.com/@smashfield89' ?>" target="_blank"><img src="{{url('images/')}}/Vector.svg" width="28px" height="28px" alt=""></a>
                        <a href="<?=isset($setting['linkedin_link'])?$setting['linkedin_link']:'https://www.linkedin.com/in/susannahashfield/' ?>" target="_blank"><img src="{{url('images/')}}/linkedin.svg" width="30px" height="30px" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer> -->

<style>
  button.ok-btn {
    border-radius: 8px;
    background: #1C1C1C;
    border: 1.5px solid #1C1C1C;
    color: #FFFFC8;
    text-transform: capitalize;
    max-width: inherit;
    padding: 8px 20px;
    box-shadow: 0px 4px 40px rgb(0 0 0 / 12%);
    font-family: 'Space Grotesk';
    font-style: normal;
    font-weight: 600;
    font-size: 18px;
    line-height: 150%;
    text-align: center;
    letter-spacing: 0.01em;
  }
  button.ok-btn:hover {
    background: #fff;
    border: 1px solid #000;
    color: #000;
    transition: 0.3s;
  }
</style>
  {{-- Cookie Section --}}
  <div id="cookieConsent" class="alert alert-info"
      style="display:none; position: fixed; bottom: 0; margin-bottom:7px; margin-right:11px; right: 0; width: 450px; padding: 15px; background-color: white; text-align: left; z-index: 1;border-color: black;">
      <p style="color: black; font-size: 18px !important; margin-bottom: 0.5rem;">
          The website uses only necessary cookies to function <a href="{{ route('cookiepolicy') }}" target="_blank"
              style="text-decoration: underline; color: black; text-decoration: underline;">Learn more</a>. By using the website you
          agree to it.
      </p>
      <div style="float: right;">
          <button id="btnAccept" class="btn btn-sm ok-btn">OK</button>
      </div>
      <div style="clear: both;"></div>
  </div>
  <script>
      $(document).ready(function() {
            if (localStorage.getItem('cookie_consent')) {
                $('#cookieConsent').addClass('d-none');
            } else {
                $('#cookieConsent').removeClass('d-none');
            }
            $('#btnAccept').click(function() {
                localStorage.setItem('cookie_consent', true);
                $('#cookieConsent').addClass('d-none');
            });
        });
  </script>
  {{-- End Cookie Section --}}