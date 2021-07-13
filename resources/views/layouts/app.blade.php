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
.h-500{
    height: 1000px;
}
.font-18{
   font-size:18px;
}
</style>


<div class="bg-light p-0">

<div class="row">

<!--vertical menu bar-->
<div class="col-2 bg-grey h-500">

<h3 class="p-3 font-weight-bolder">Hayok</h3>
<nav class="navbar">

  <!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
     <a class="nav-link font-18" href="{{ route('healthworker') }}"> <span class="la la-home"></span> Dashboard</a>
    </li>
    <br>
    <li class="nav-item">
        <a class="nav-link font-18" href="{{ route('hw_patients') }}"> <span class="la la-users"></span> Patients</a>
    </li>
    <br>
    <li class="nav-item">
        <a class="nav-link font-18" href="{{ route('hw_encounter') }}"> <span class="la la-user-edit"></span> Encounter</a>
    </li>
    <br>
    <li class="nav-item">
        <a class="nav-link font-18" href="{{ route('hw_chat') }}"> <span class="la la-phone"></span> Chat</a>
    </li>
  </ul>

</nav>
</div>

<div class="col-10">


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
