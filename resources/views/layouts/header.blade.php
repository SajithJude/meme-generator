
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Speak2Impact</title>
  <!-- css link  -->

  <link rel="stylesheet" href="{{url('css/home.css')}}">
</head>

<body>
  <header class="main-site">
    <div class="container-main">
      <div class="main-header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">Speak2Impact Academy</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link {{ Request::segment(1) === 'home' ? 'active' : null }}" aria-current="page" href="{{url('home')}}">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Request::segment(1) === 'courses' ? 'active' : null }}" href="{{ route('view.all.courses') }}">Courses</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Request::segment(1) === 'meeting' ? 'active' : null }}" href="#">Schedule meeting with Coach</a>
              </li>
              <li class="nav-item">
                <a class="nav-link {{ Request::segment(1) === 'practice' ? 'active' : null }}"  href="{{url('practice')}}">Practice</a>
              </li>
              <li class="nav-item">
                <a class="nav-link  {{ Request::segment(1) === 'webinars' ? 'active' : null }}" href="{{url('webinars')}}">Webinars</a>
              </li>
            </ul>
          </div>
          <a href="#" class="user-option">
            <img src="./images/user1.png" alt="">
          </a>
        </nav>
      </div>
    </div>
  </header>


@yield('body')

<footer>
                                <div class="container">
                                    <div class="footer">
                                        <div class="footer-top">
                                            <div class="footer-logo"><span>Speak2Impact Academy</span></div>
                                            <div class="footer-link">
                                                <a href="#">Contact us</a>
                                                <a href="#">Speak2impact</a>
                                                <a href="{{route('register')}}">Sign up</a>
                                                <a href="{{route('login')}}">Login</a>
                                            </div>
                                        </div>
                                        <div class="social-icon mt-3">
                                            <a href="#"><img src="{{url('images/')}}/Instagram.svg" alt=""></a>
                                            <a href="#"><img src="{{url('images/')}}/facebook.svg" alt=""></a>
                                            <a href="#"><img src="{{url('images/')}}/Vector.svg" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>