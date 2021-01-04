@extends('layouts.app')
@section('content')

<script>
    var currentPlayerLevel = "<?= $gamedata['playerLevel']['player_level'] ?>";

    function showLevel(currentPlayerLevel) {
        var divLevel = document.getElementById("divLevel");
        divLevel.classList.add("friendPlayerLevel");

        if (currentPlayerLevel < 100) {
            var level_1 = Math.floor(currentPlayerLevel / 10) * 10; //level 35 becomes 30
            divLevel.classList.add("lvl_" + level_1);
        } else {
            var level_1 = Math.floor(currentPlayerLevel % 100 / 10) * 10; // level 235 becomes 30
            var level_2 = Math.floor(currentPlayerLevel / 100) * 100; // level 235 becomes 200
            divLevel.classList.add("lvl_" + level_2);
            divLevel.classList.add("lvl_plus_" + level_1);
        }

    }
</script>
<!-- <button onclick="showLevel(currentPlayerLevel)">kkr mooie button</button> -->

<?php
$lastLogoff = $gamedata['data']['lastlogoff'] ?? '';
$timeCreated = $gamedata['data']['timecreated'] ?? '';
$gameInfo = $gamedata['data']['gameextrainfo'] ?? '';
$gameID = $gamedata['data']['gameid'] ?? '';
//dd($gamedata['ownedGames']);
?>

@if(session('error_user'))
    <div class="alert alert-danger text-center" role="alert">
        {{session('error_user')}}
    </div>
@endif


@if(!empty($gamedata['profileBackground']['image_large']))
    <img src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/{{$gamedata['profileBackground']['image_large']}}" style="position: absolute;top:0;width: 100%;height: 100%;z-index: -1; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));mask-image: linear-gradient(to bottom, rgba(0,0,0,1), rgba(0,0,0,0));">
@endif
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 mb-3 p-3 profileBackground rounded">
                <h4 class="text-center">Search player</h4>
                <form action="/user" method="get" class="form-row">
                    <input class="form-control btn-outline-primary bg-transparent mb-2 text-white" type="text" name="id" placeholder="Enter your steam id or VanityUrl">
                    <input type="submit" class="form-control btn-outline-primary bg-transparent">
                </form>
            </div>
            <div class="col-lg-8">

                {{--        Main page       --}}
                <div class="row h-100 mr-1 pt-3 profileBackground rounded">
                    {{--        Profile image            --}}
                    <div class="col-md-3 p-2">
                        @if(!empty($gamedata['customAvatarFrame']['image_small']))
                            <img class="img-fluid avatarBorder" src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/{{$gamedata['customAvatarFrame']['image_small']}}">
                        @endif
                        <img class="img-fluid avatar" src="{{$gamedata['data']['avatarfull']}}">
                    </div>
                    {{--        Name & status            --}}
                    <div class="col-md-5 pt-lg-4">
                        <a href="{{$gamedata['data']['profileurl']}}" class="text-white" target="_blank"><h3 id="profilelink" class="m-0">{{$gamedata['data']['personaname']}}</h3></a>
                        @if(!empty($gamedata['data']['loccountrycode']))
                            <p class="m-0 text-white">Country: <img src="https://steamcommunity-a.akamaihd.net/public/images/countryflags/{{strtolower($gamedata['data']['loccountrycode'])}}.gif"><span class="text-light"> {{ $gamedata['data']['loccountrycode']}}</span></p>
                            <p class="m-0 text-white pb-4">Status: {{$gamedata['data']['personastate']  == 1 ? "Online" : "Offline"  }}</p>
                        @else
                            <p class="m-0 text-white pb-4">Status: {{$gamedata['data']['personastate']  == 1 ? "Online" : "Offline"  }}</p>
                            <p class="m-0 text-white"><h3></h3></p>
                        @endif
                             <p class="m-0 text-white">Steamid: {{$gamedata['data']['steamid']}}</p>
                        @if(!empty($gameInfo))
                            <p class="m-0 text-white">Currently playing: <a href="/game/{{$gamedata['data']['gameid']}}" class="text-white">{{$gamedata['data']['gameextrainfo']}}</a> <i class="fab fa-steam-symbol"></i></p>
                            <p class="m-0 text-white" hidden>Game id: {{$gamedata['data']['gameid']}}</p>
                        @else
                            <p class="m-0 text-white">Currently not ingame</p>
                        @endif
                    </div>
                    <br>

                    {{--        Recently played games            --}}
                    @if(!empty($gamedata['recentlyPlayedGames']))
                    <table class="table borderless text-white mt-5 w-100">
                        <thead>
                            <th class="border-bottom-0 mx-1">Recently played games</th>
                        </thead>
                        <tbody>
                        @foreach ($gamedata['recentlyPlayedGames'] as $recentlyPlayedGame)
                            <tr>
                                @if(!empty($recentlyPlayedGame['img_logo_url']))
                                    <td class="py-1 w-25"><img class="card-img-top"
                                                          src="https://steamcdn-a.akamaihd.net/steam/apps/{{$recentlyPlayedGame['appid'] }}/header.jpg">
                                    </td>
                                @else
                                    <img class="card-img-top noImageFound"
                                         src="https://piotrkowalski.pw/assets/camaleon_cms/image-not-found-4a963b95bf081c3ea02923dceaeb3f8085e1a654fc54840aac61a57a60903fef.png" class="p-0">
                                @endif
                                <th  class="px-0 align-middle" style="width: 150px">
                                    <a href="/game/{{ $recentlyPlayedGame['appid']}}" class="text-white">{{ !empty($recentlyPlayedGame['name']) ? $recentlyPlayedGame['name'] : "No name found" }}</a>
                                </th>
                                <td class="align-middle">
                                    Last 2 weeks: {{ round($recentlyPlayedGame['playtime_2weeks'] / 60, 1) . " Hours" }}
                                </td>
                                <td class="align-middle">
                                    Overall playtime: {{ round($recentlyPlayedGame['playtime_forever'] / 60, 1) . " Hours" }}
                                </td>
                            </tr>
                        @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{--      Right bar      --}}
            <div class="col-lg-4 pt-3 profileBackground rounded">
                {{--        Level        --}}
                <div class="pl-3 py-5" style="background-color: #1b1e21">
                    <h4 class=text-white">Level: <span id="divLevel" class="">{{ $gamedata['playerLevel']['player_level'] }}</span></h4>
                    <p class="text-white mr-3 p-3" style="background-color: #15191a"><span data-toggle="tooltip" data-placement="right" title="Member since {{ gmdate('m-d-Y', $timeCreated) }}">{{ date('y') - gmdate('y', $timeCreated) }} years of service</span></p>
                    <a class="btn btn-dark" href="https://store.steampowered.com/wishlist/profiles/{{$gamedata['data']['steamid']}}/wishlistdata/?p=0">View wishlist</a> <!-- Make into wishlist -->
                </div>

                {{--        Game stats        --}}
                <div class="py-3 px-3 mt-3" style="background-color: #1b1e21">
                    <h4>Game stats:</h4>
                    <div class="p-3" style="background-color: #15191a">
                        <p class="p-0 m-0">Owned games: @if(isset($gamedata['ownedGames']['game_count'])) {{$gamedata['ownedGames']['game_count']}} @else No games @endif</p>
                        <p class="p-0 m-0">Hours on record: @if(isset($gamedata['ownedGames']['game_count'])) {{$gamedata['hoursOnRecord']}}h @else N/A @endif</p>
                        <p class="p-0 m-0">Average playtime: @if(isset($gamedata['ownedGames']['game_count'])) {{$gamedata['averagePlaytime']}}h @else N/A @endif</p>
                    </div>
                </div>
                {{--        Ban information        --}}
                <div class="py-3 px-3 mt-3" style="background-color: #1b1e21">
                    <h4>Ban information:</h4>
                    <div class="p-3" style="background-color: #15191a">
                        <p class="p-0 m-0">Vac ban: @if($gamedata['banInfo']['VACBanned'] == false) None @else {{$gamedata['banInfo']['NumberOfVACBans']}} Ban(s) ({{ $gamedata['banInfo']['DaysSinceLastBan'] }} Days ago) @endif</p>
                        <p class="p-0 m-0">Community ban: @if($gamedata['banInfo']['CommunityBanned'] == false) None @else Banned @endif</p><br>
                        <p class="p-0 m-0">Game bans: @if($gamedata['banInfo']['NumberOfGameBans'] == false) None @else {{$gamedata['banInfo']['NumberOfGameBans']}} @endif</p>
                        <p class="p-0 m-0">Trade ban: @if($gamedata['banInfo']['EconomyBan'] == 'none') None @else {{$gamedata['banInfo']['EconomyBan']}} @endif</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 pl-0 pr-3">
                <div class="">
                </div>
            </div>
            <div class="col-lg-4 p-5 ">
            </div>
        </div>
    </div>


















{{--<!--    Profile information    -->--}}
{{--@if(!empty($gamedata['profileBackground']['image_large']))--}}
{{--    <img src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/{{$gamedata['profileBackground']['image_large']}}" style="position: absolute;top:0;width: 100%;height: 100%;z-index: -1; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));mask-image: linear-gradient(to bottom, rgba(0,0,0,1), rgba(0,0,0,0));">--}}
{{--@endif--}}
{{--    <div class="container pt-3">--}}
{{--        <div class="row profileBackground">--}}
{{--            <div class="col-md-3 py-3">--}}
{{--                @if(!empty($gamedata['customAvatarFrame']['image_small']))--}}
{{--                    <img class="img-fluid avatarBorder" src="https://steamcdn-a.akamaihd.net/steamcommunity/public/images/{{$gamedata['customAvatarFrame']['image_small']}}">--}}
{{--                @endif--}}
{{--                <img class="img-fluid avatar" src="{{$gamedata['data']['avatarfull']}}">--}}
{{--            </div>--}}
{{--            <div class="col-md-5">--}}
{{--                <a id="profilelink" href="{{$gamedata['data']['profileurl']}}">{{$gamedata['data']['personaname']}}</a><br>--}}
{{--                <span class="userPageInfoSpan m-0">Level: <div id="divLevel" class="friendPlayerLevelNum">{{ $gamedata['playerLevel']['player_level'] }}</div> | Country: {{$gamedata['data']['loccountrycode']}}</span>--}}
{{--                @if(!empty($gameInfo))--}}
{{--                <p class="userPageInfo">Currently playing: {{$gamedata['data']['gameextrainfo']}} <i class="fab fa-steam-symbol"></i></p>--}}
{{--                <p class="userPageInfo" hidden>Game id: {{$gamedata['data']['gameid']}}</p>--}}
{{--                @else--}}
{{--                <p class="userPageInfo">Currently not ingame</p>--}}
{{--                @endif--}}
{{--                <hr>--}}
{{--                <p class="userPageInfo">{{"Total XP: " .  $gamedata['playerLevel']['player_xp'] }}</p>--}}
{{--                <p class="userPageInfo">{{ $gamedata['playerLevel']['player_xp_needed_to_level_up'] . " / ".  $gamedata['playerLevel']['player_xp_needed_current_level'] . " XP to next level "}}</p>--}}
{{--            </div>--}}
{{--            <div class="col-md-4 pt-2">--}}
{{--                <p class="userPageInfo border border-dark p-1">Vac ban: @if($gamedata['banInfo']['VACBanned'] == false) None @else {{$gamedata['banInfo']['NumberOfVACBans']}} Ban(s) ({{ $gamedata['banInfo']['DaysSinceLastBan'] }} Days ago) @endif</p>--}}
{{--                <p class="userPageInfo border border-dark p-1">Community ban: @if($gamedata['banInfo']['CommunityBanned'] == false) None @else Banned @endif</p>--}}
{{--                <p class="userPageInfo border border-dark p-1">Game bans: @if($gamedata['banInfo']['NumberOfGameBans'] == false) None @else {{$gamedata['banInfo']['NumberOfGameBans']}} @endif</p>--}}
{{--                <p class="userPageInfo border border-dark p-1">Trade ban: @if($gamedata['banInfo']['EconomyBan'] == 'none') None @else {{$gamedata['banInfo']['EconomyBan']}} @endif</p>--}}
{{--                <p class="userPageInfo border border-dark p-1">Account age: {{ date('y') - gmdate('y', $timeCreated) }} years</p>--}}
{{--                <p class="userPageInfo border border-dark p-1">Steamid: {{$gamedata['data']['steamid']}}</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        @if(!empty($gamedata['recentlyPlayedGames']))--}}
{{--            <div class="card-group row mt-1">--}}
{{--                @foreach ($gamedata['recentlyPlayedGames'] as $recentlyPlayedGame)--}}
{{--                    <div class="card profileCards col-md-3 p-0 m-1">--}}
{{--                        @if(!empty($recentlyPlayedGame['img_logo_url']))--}}
{{--                            <img class="card-img-top"--}}
{{--                                 src="http://media.steampowered.com/steamcommunity/public/images/apps/{{ $recentlyPlayedGame['appid'] }}/{{ $recentlyPlayedGame['img_logo_url'] }}.jpg">--}}
{{--                        @else--}}
{{--                            <img class="card-img-top noImageFound"--}}
{{--                                 src="https://piotrkowalski.pw/assets/camaleon_cms/image-not-found-4a963b95bf081c3ea02923dceaeb3f8085e1a654fc54840aac61a57a60903fef.png">--}}
{{--                        @endif--}}
{{--                        <div class="card-body">--}}
{{--                            <h5 class="card-title">{{ !empty($recentlyPlayedGame['name']) ? $recentlyPlayedGame['name'] : "No name found" }}</h5>--}}
{{--                            <p>Appid: {{ $recentlyPlayedGame['appid'] }}</p>--}}
{{--                            <p>Last 2 weeks: {{ round($recentlyPlayedGame['playtime_2weeks'] / 60, 1) . " Hours" }}</p>--}}
{{--                            <p>Overall--}}
{{--                                playtime: {{ round($recentlyPlayedGame['playtime_forever'] / 60, 1) . " Hours" }}</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        @endif--}}
{{--    </div>--}}

<script>
    showLevel(currentPlayerLevel)
</script>

@endsection
