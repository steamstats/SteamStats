@extends('welcome')

@section('navigation')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a href="{{ url('/') }}"><img src="{{asset('img/SteamStats_Logo_Transparent.png')}}" alt="Logo" style="width: 200px"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li>
                </ul>
            </div>
    @if (Route::has('login'))

        <div class="hidden absolute top-0 right-0 px-5 py-2 sm:block">

            @auth

                <ul class="navbar-nav mr-auto">
                    <li class="dropdown">
                        <a href="#" class='dropdown-toggle' data-toggle='dropdown' style="color:white"><img class='img-rounded' src='{{ Auth::user()->avatar }}' style="border: 1px solid white;border-radius: 10%; width: 35px;  vertical-align: middle;">&nbsp;<b style="color: white">{{ Auth::user()->name }}</b><b class='caret'></b></a>
                        <span class="dropdown-arrow" style="color: white;text-decoration: none"></span>
                        <ul class="dropdown-menu" style="margin-top: 10px;z-index: 999">
                            <li><a href="{{ url('/profile') }}" style="padding:0">Profile</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" style="padding: 0">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                                this.closest('form').submit();" style="padding: 0">
                                        {{ __('Logout') }}
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>                    @else
                <a href='{{ url('/auth/steam') }}'><img src='https://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_02.png'></a>

                {{--                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>--}}


                {{--                    @if (Route::has('register'))--}}
                {{--                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>--}}
                {{--                    @endif--}}
            @endif
        </div>
          @endif
    </nav>

@endsection
