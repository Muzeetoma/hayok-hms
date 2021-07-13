@extends('layouts.app')

@section('content')
<div class="container">

    <div class="container jumbotron">
     <h1>Error</h1>

     <div class="container bg-white">
     
     </div>
     @auth
                        <a href="{{ url('/') }}" class="btn btn-primary mr-4">Home</a>

                        <a class="" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <span class="la la-sign-out"></span><span> Logout</span>
                                    </a>

                                      
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary mr-4">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif

                    @endauth 

      </div>
                      
</div>
@endsection
