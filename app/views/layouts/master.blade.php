
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

  <body role="document" onload="">

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><div class="logo"></div></a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <?php if(!Auth::check()) { ?>
            <li><a href="{{ url('/sign-in') }}">Sign in</a></li>
            <?php } else { ?>
            <!--<li><a href="{{ url('/profile') }}">{{Auth::user()->name}}</a></li>-->
              @if(Auth::user()->name != 'Admin')
                <li><a href="{{ url('/profile') }}">Edit Profile</a></li>
              @endif
            <li><a href="{{ url('/sign-out') }}">Sign out</a></li>
                <?php } ?>
        </ul>
        <!--<div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>-->
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class=""><a href="/">Overview</a></li>
            <li class="{{ Request::is('reports') ? 'active' : '' }}"><a href="{{ url('/notfinished') }}">Reports</a></li>
            <li class="{{ Request::is('reps') ? 'active' : '' }}"><a href="{{ url('/reps') }}">Representatives</a></li>
            <li class="{{ Request::is('customers') ? 'active' : '' }}"><a href="{{ url('/customers') }}">Customers</a></li>
            <li class="{{ Request::is('companies') ? 'active' : '' }}"><a href="{{ url('/companies') }}">Companies</a></li>
            <li class="{{ Request::is('quotes') ? 'active' : '' }}"><a href="{{ url('/quotes') }}">Quotes</a></li>
            <li class="{{ Request::is('parts') ? 'active' : '' }}"><a href="{{ url('/parts') }}">Parts</a></li>
            <li class="{{ Request::is('cables') ? 'active' : '' }}"><a href="{{ url('/cables') }}">Cables</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li class="{{ Request::is('powertrak') ? 'active' : '' }}"><a href="{{ url('/trak') }}">Powertrak</a></li>
            <li class="{{ Request::is('festoon') ? 'active' : '' }}"><a href="{{ url('/fest') }}">Festoon</a></li>
            <li class="{{ Request::is('reel') ? 'active' : '' }}"><a href="{{ url('/reel') }}">Reel</a></li>
              <li class="{{ Request::is('priceChk') ? 'active' : '' }}"><a href="{{ url('/checkPrice') }}">Price Check</a></li>
            <li class="{{ Request::is('prices') ? 'active' : '' }}"><a href="{{ url('/prices') }}">Price Update</a></li>
            <li class="{{ Request::is('spare') ? 'active' : '' }}"><a href="{{ url('/spare') }}">Spare Parts</a></li>
            <li class="{{ Request::is('manual') ? 'active' : '' }}"><a href="{{ url('/manual') }}">Manual</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

          @if($errors->has())
            @foreach ($errors->all() as $error)
              <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
          @endif

          @if(Session::has('success_message'))
              <div class="alert alert-success">{{ Session::get('success_message') }}</div>
          @endif


          <h2 class="sub-header">@yield('page-title')</h2>

          @yield('content')

        </div>
      </div>
    </div>
    <?php if(Auth::check()) { ?>

    <?php } ?>


    <footer>
      <script src="{{ asset('/js/jquery.keyfilter-1.7.min.js') }}"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <script src="{{ url('/js/bootstrap.min.js') }}"></script>

      @yield('scripts')
    </footer>
  </body>
</html>
