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



<main class="">
        @include('alerts.messages')
        @yield('content')
        </main>

</div>

    </div>
</body>
</html>
