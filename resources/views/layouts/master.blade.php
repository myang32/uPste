<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ url('img/favicon.png') }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
    @yield('stylesheets')
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('index') }}">{{ env('DOMAIN') }}</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    @yield('nav-left')
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @yield('nav-right')
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="text-center">
            @if(Session::has('info'))
                <div class="alert alert-success">{{ Session::get('info') }}</div>
            @endif
            @if(Session::has('alert'))
                <div class="alert alert-danger">{{ Session::get('alert') }}</div>
            @endif
        </div>
        @yield('content')
        <hr>
    </div>
    <footer>
        <div class="footer text-center">
            @yield('footer')
            <p class="text-muted"><small>{{ env('IRC_CHANNEL') }} @ {{ env('IRC_SERVER') }}</small></p>
        </div>
    </footer>
    <script src="//code.jquery.com/jquery-1.11.3.min.js" type="application/javascript"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    @yield('javascript')
</body>
</html>