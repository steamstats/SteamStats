@extends('layouts.app')

@section('content')

<div class="container mt-5" >
    <div class="row">
        <div class="col-9 offset-3 ">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#all_games" role="tab" aria-controls="all_games" aria-selected="true">All</a>
                  </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#new_releases" role="tab" aria-controls="new_releases" aria-selected="true">New Releases</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#top_sellers" role="tab" aria-controls="top_sellers" aria-selected="true">Top Sellers</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#coming_soon" role="tab" aria-controls="coming_soon" aria-selected="true">Coming Soon</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#specials" role="tab" aria-controls="specials" aria-selected="true">Specials</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-3">

        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="container">
                    <form action="/search" method="get" role="search">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" class="form-control" name="q"
                                placeholder="Search games">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-3 h-100" >
            <div class="p-3" style="background-color: #21262f">
                <label for="genres"><h4 class="p-0 m-0">Genres:</h4></label>
                <form action="/sort_genre" method="get" role="sortGenre">
                    @foreach ($genres as $genre)
                        <input type="checkbox" name="genre_{{$genre->id}}" value="{{$genre->id}}">
                        <label for="{{$genre->name}}">{{$genre->name}}</label><br>
                    @endforeach
                    <button type="submit" value="submit" class="btn btn-dark">submit</button>
                </form>
            </div>  
        </div>
        <div class="col-md-9">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="all_games" role="tabpanel">
                    <table class="table" style="color: rgb(255, 255, 255)">
                        <thead>
                            <tr>
                            <th></th>
                                <th>@sortablelink('appid', 'Appid')</th>
                                <th>@sortablelink('name', 'Name')</th>
                                <th>@sortablelink('price', 'Price')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($games as $game)
                                <tr>
                                    <td><img src="{{$game->image}}" alt="{{$game->name}}" style="width: 100px"></td>
                                    <td>{{$game->appid}}</td>
                                    <td><a href="{{route('game', ['id' => $game->appid])}}">{{$game->name}}</a></td>
                                    <td>{{$game->price_formatted}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-md-12 d-flex justify-content-center">
                        {{$games->appends(Request::except('page'))->links('vendor.pagination.bootstrap-4')}}  
                    </div>
                </div>

                @foreach ($categories as $key => $category)
                    <div class="tab-pane fade" id="{{$key}}" role="tabpanel">
                        <table class="table" style="color: rgb(255, 255, 255)">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Appid</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($category['items'] as $items)
                                    <tr>
                                        <td><img src="{{$items['header_image']}}" alt="{{$items['name']}}" style="width: 100px"></td>
                                        <td>{{$items['id']}}</td>
                                        <td><a href="{{route('game', ['id' => $items['id']])}}">{{$items['name']}}</a></td>
                                        @if ($items['original_price'] == null)
                                            @if ($key == "coming_soon")
                                                <td>Coming Soon</td>
                                            @else
                                                <td>Free to Play</td>
                                            @endif
                                        @else
                                            <td>{{$items['final_price'] / 100}}€</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>     
        </div>
        
    </div>
</div>

@endsection
