<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HayokHMS') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery.js') }}" ></script>
   

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('lineawesome/css/line-awesome.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/w3.css') }}" rel="stylesheet">

</head>
<body>


<style>
    *{
        padding: 0;
        margin: 0;
       
    }
.body{
    height:100%;
    width:100%;
}    
.bg-grey{
    background-color:rgb(226, 226, 226);
}
a{
    color:black;
}
a:hover{
    color:black;
    text-decoration: none;
}
.h-500{
    height: 1000px;
}
.font-18{
   font-size:16.5px;
}
</style>


<div class="bg-light p-0">

<div class="row">

<!--vertical menu bar-->
<div class="col-2 h-500">

<h4 class="p-3 font-weight-bolder">Hayok Medicare</h4>
<nav class="navbar">

  <!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
     <a class="nav-link font-18" href="{{ route('patient') }}"> <span class="la la-home mr-2"></span>My profile</a>
    </li>
    <br>

    <li class="nav-item">
        <a class="nav-link font-18" href="{{ route('patient-chat') }}"> <span class="la la-phone mr-2"></span> Chat</a>
    </li>
    <br>
    <li class="nav-item">
        <a class="btn btn-outline-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <span class="la la-sign-out"></span><span> Logout</span>
                                    </a>

                                      
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
    </li> 
    <hr>
    <br><br>
    <li class="nav-item">
    <span class="la la-user bg-primary p-1 text-white rounded-circle font-18"></span>
    <span class="font-18 ml-2">{{Auth::user()->name}} {{Auth::user()->surname}}</span>
    </li>
  </ul>

</nav>
</div>

<div class="col-10" style="background-color: white;">


<main class="">
        @include('alerts.messages')
        @yield('content')
        </main>
</div>
</div>
</div>

    </div>
</body>
</html>
