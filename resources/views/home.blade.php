@extends('layouts.app')

@section('content')
<div class="container">
                    @auth
                        <a href="{{ url('/') }}" class="text-sm text-gray-700 underline">Home</a>

                        <a class="" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <span class="la la-sign-out"></span><span> Logout</span>
                                    </a>

                                      
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif

                    @endauth    
</div>
@endsection
