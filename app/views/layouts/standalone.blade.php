
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.ico">

    <title>@yield('title', 'Gleason')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ url('/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>

    <!-- Bootstrap theme -->
    <link href="{{ url('/css/bootstrap-theme.min.css') }}" rel="stylesheet">
    <link href="{{ url('/css/main.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ url('/js/functions.js') }}"></script>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>

<body role="document" onload="" style="background-image:url({{url('/images/bground-text-gleason.png')}});  ">




            @if($errors->has())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            @endif

            @if(Session::has('success_message'))
                <div class="alert alert-success">{{ Session::get('success_message') }}</div>
            @endif



    <div class="col-sm-9 col-sm-offset-1 col-md-9 standalone">

            @yield('content')
    </div>

<script src="{{ asset('/js/jquery.keyfilter-1.7.min.js') }}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="{{ url('/js/bootstrap.min.js') }}"></script>
@yield('scripts')
</body>
</html>
