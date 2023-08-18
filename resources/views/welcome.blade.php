<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Speak2Impact</title>
        <!-- css link  -->
        <link rel="stylesheet" href="{{url('css/landing.css')}}">
    </head>
    <body>
        <header>
            <div class="container">
                <div class="header">
                    <div class="logo"><h1>Speak2Impact Academy</h1></div>
                    <div class="login-action">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit"> Logout</button>
                            {{-- <a class="dropdown-item" href="{{route('admin-logout')}}"><i class="ft-power"></i> Logout</a> --}}
                        </form>
                        <a href="{{url('login')}}"><button class="login">login</button></a>
                        <button class="start-learning">start learning</button>
                    </div>
                </div>

            </div>
        </header>

        <div class="hero">
            <div class="container">
                <div class="hero-top">
                    <div class="hero-heading">
                        <img src="{{url('images/')}}/heading-bg2.svg" alt="" class="h-patteren">
                        <h1>The Art of </br>Public Speaking </h1>
                        <span>by<img src="{{url('images/')}}/r1.png" alt="">Susie Ashfield</span>
                    </div>
                    <ul class="features">
                        <li>✦ Learn at your pace</li>
                        <li>✦ Free webinars</li>
                        <li>✦ Schedule meeting with a Coach</li>
                    </ul>
                    <button>start learning<img src="{{url('images/')}}/ar.svg" alt=""></button>
                </div>
            </div>
        </div>

        <div class="happy-client">
            <div class="container">
                <h2>Trusted by</h2>
                <ul>
                    <li><img src="{{url('images/')}}/c1.png" alt=""></li>
                    <li><img src="{{url('images/')}}/c2.png" alt=""></li>
                    <li><img src="{{url('images/')}}c3.png" alt=""></li>
                    <li><img src="{{url('images/')}}c4.png" alt=""></li>
                    <li><img src="{{url('images/')}}c5.png" alt=""></li>
                </ul>
            </div>
        </div>


        <div class="fun-facts">
            <div class="container">
                <video width="800" height="500" controls>
                    <source src="movie.mp4" type="video/mp4">
                    <source src="movie.ogg" type="video/ogg">
                    Your browser does not support the video tag.
                </video>
                <div class="fun-stats">
                    <h2><span>Learn the art of public speaking</span> with Susie Ashfield</h2>
                    <p>Join with yearly or monthly membership and get access to a our free webinars and schedule a meeting with coach</p>
                    <div class="facts">
                        <span><b>9</b>Chapters</span>
                        <span><b>62</b>Lessons</span>
                        <span><b>80</b>Hours of videos</span>
                    </div>
                    <ul class="checks">
                        <li><img src="{{url('images/')}}/check.svg" alt="">Learn at your own pace</li>
                        <li><img src="{{url('images/')}}/check.svg" alt="">Practice your pitch and get feedbacks</li>
                        <li><img src="{{url('images/')}}/check.svg" alt="">Free Webinars</li>
                        <li><img src="{{url('publicimages/')}}/check.svg" alt="">Schedule meeting with a Coach</li>
                    </ul>
                </div>
            </div>
        </div>



        <div class="testimonial">
            <div class="container">
                <h2><span>Some professionals</span> talking about us </h2>
                <div class="reviews">
                    <div class="review">
                        <div class="client">
                            <img src="{{url('images/')}}/r1.png" alt="">
                            <h3>Smantha James, CEO at Rivago</h3>
                        </div>
                        <p>“ Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.“</p>
                    </div>
                    <div class="review">
                        <div class="client">
                            <img src="{{url('images/')}}/r2.png" alt="">
                            <h3>Smantha James, CEO at Rivago</h3>
                        </div>
                        <p>“ Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.“</p>
                    </div>
                </div>
            </div>
        </div>





        <div class="membership-plan">
            <div class="container">
                <h2>Membership Plans</h2>
                <div class="plans">
                    <div class="plan-a">
                        <h3><span>monthly</span>$299.00</h3>
                        <p>Get monthly membership for the whole course</p>
                        <button>sign up</button>
                    </div>
                    <div class="plan-b">
                        <label>Save 12%</label>
                        <h3><span>yearly</span>$1299.00</h3>
                        <p>Get yearly membership for the whole course</p>
                        <button>sign up</button>
                    </div>
                </div>
            </div>
        </div>




        <footer>
            <div class="container">
                <div class="footer">
                    <div class="footer-top">
                        <div class="footer-logo"><span>Speak2Impact Academy</span></div>
                        <div class="footer-link">
                            <a href="#">Contact US</a>
                            <a href="#">Speak2impact</a>
                            <a href="{{route('register')}}">Sign up</a>
                            <a href="{{route('login')}}">Login</a>
                        </div>
                    </div>
                    <div class="social-icon">
                        <a href="#"><img src="{{url('images/')}}/icons8-instagram.svg" alt=""></a>
                        <a href="#"><img src="{{url('images/')}}/icons8-facebook.svg" alt=""></a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
