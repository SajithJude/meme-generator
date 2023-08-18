<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>{{env('APP_NAME')}}</title>
    <!-- css link  -->.
    <link rel="stylesheet" href="{{url('css/')}}/signup.css">

    <link rel="stylesheet" href="{{url('css/')}}/login.css">
    <link rel="stylesheet" href="{{url('css/')}}/landing.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <style type="text/css">
                .loaderImage {
                       display: none;
                       position: fixed;
                       top: 0px;
                       right: 0px;
                       width: 100%;
                       height: 100%;
                       background-color: #000;
                       background-image: url({{ asset('images/loading.gif') }});
                       background-repeat: no-repeat;
                       background-position: center;
                       z-index: 10000000;
                       opacity: 0.4;
                       filter: alpha(opacity=40); /* For IE8 and earlier */
                   }
        </style>