<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}"/>
    <script type="text/javascript" src="{{asset('js/jquery-3.4.1.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/sweetalert.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/sweetalert.css')}}">
    <style type="text/css">
        body {
            background-size: 100% auto;
        }

        header {
            opacity: 0.7;
        }

        footer {
            background-color: #fff;
            opacity: 0.9;
            text-align: center;
        }
        p > span {
            color: #ff0000;
        }
    </style>
</head>
<body>
<header class="jumbotron">
    <div class="container">
        <div class="col-md-10">
            <h1>Ava Rewase Scout!</h1>
            <p>
                Scout is my life <span>&hearts;</span>
            </p>
        </div>
        <div class="col-md-3 links">
            <h6><a href="/scout/public/categories" >Home</a></h6>
            <h6><a href="/scout/public/notifications">Notifications</a></h6>
            <h6><a href="/scout/public/add_category"
                   @if (Session::has('X'))
                   style="display: none"
                    @endif>Modify categories</a></h6>
            <h6><a href="/scout/public/home">Logout</a></h6>
            <br>
            Date :{{$date ?? ''}}
            <br/>
            Time :{{$time ?? ''}}
        </div>
        </div>
</header>
</body>

@if (Session::has('m'))
    <div class="container">
        <?php $a = []; $a = session()->pull('m'); ?>

        <div class="alert alert-{{$a[0]}}"> {{$a[1]}}
        </div>
    </div>

@endif
@yield('content')

<footer class="container">
    &copy; All Rights Reserved for Rewase El-Maraghy - 2020
</footer>

</html>
