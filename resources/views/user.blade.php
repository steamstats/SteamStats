@extends('layouts.app')

@section('content')


    @if(session('error_user'))
        <div class="alert alert-danger text-center" role="alert">
            {{session('error_user')}}
        </div>
    @endif

    <div class="container vh-100">
        <div class="col-md-12 mt-5">
            <h1 class="text-center">Search player</h1>
            <h3 class="text-center text-muted mb-5">Search steam information from any player</h3>
            <h5 class="text-secondary">Enter a valid Steamid or VanityUrl:</h5>
            <a class="text-secondary">Examples:</a><br>
            <ol class="text-secondary">
                <li>Steamid: 76561198088141566</li>
                <li>VanityUrl: Pwinga</li>
            </ol>
            <form action="/user" method="get" class="form-row">
                <input class="form-control btn-outline-primary bg-transparent mb-2 text-white" type="text" name="id" placeholder="Enter your steam id or VanityUrl">
                <input type="submit" class="form-control btn-outline-primary bg-transparent">
            </form>
        </div>
        <br>
    @auth
        <b class="text-secondary">You are signed in with Steamid: {{ Auth::user()->steamid }}. To see your profile click </b><a href="{{ url('/user/'.Auth::user()->steamid) }}">here </a><b class="text-secondary">or your avatar in the navbar to view your profile.</b>
        @else
           <b class="text-secondary">If you want to access your own profile sign in with steam </b><a href='{{ url('/auth/steam') }}'>here.</a>
        @endif
    </div>

@endsection
