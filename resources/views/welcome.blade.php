@extends('layouts.app')
@section('content')
<script type="text/javascript">
    var links = [
    csgo = 'https://store.steampowered.com/feeds/news/app/730/',
    dota2 = 'https://store.steampowered.com/feeds/news/app/570/',
    cyberpunk2077 = 'https://store.steampowered.com/feeds/news/app/1091500/',
    pubg = 'https://store.steampowered.com/feeds/news/app/578080/',
    gta5 = 'https://store.steampowered.com/feeds/news/app/271590/',
    tcrss = 'https://store.steampowered.com/feeds/news/app/359550/',
    apex = 'https://store.steampowered.com/feeds/news/app/1172470/',
    destiny2 = 'https://store.steampowered.com/feeds/news/app/1085660/',
    poe = 'https://store.steampowered.com/feeds/news/app/238960/',
    ]

    $(document).ready(function(){
    for(var i = 0; i<=links.length; i++){
    $('#divRss'+i).FeedEk({
    FeedUrl : links[i],
    MaxCount : 5,
    ShowDesc : false,
    ShowPubDate : true
    });} }); </script>


    <img src="{{ asset('img/homepage/csgo.jpg') }}" style="position: absolute;width:100%;top:0;height: 120%;z-index: -1; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));mask-image: linear-gradient(to bottom, rgba(0,0,0,1), rgba(0,0,0,0));">
<div class="container mt-3">
    <div class="row">
        <div class="col-lg-12" style="margin-top: 75px;">

            <div class="my-3">
                <img src="{{ asset('img/logo.png') }}" alt="logo" class="mx-auto d-block w-75 img-fluid">
            </div>
        </div>

        <div class="col-md-6" style="margin-top: 75px;">
            <div class="alert alert-primary text-center" role="alert">
            <h5>Current online players:</h5>
            <?= $games['allCurrentOnline'][0]?>
            </div>
        </div>
        <div class="col-md-6" style="margin-top: 75px;">
            <div class="alert alert-primary text-center" role="alert">
            <h5>Peak Today:</h5>
            <?= $games['allCurrentOnline'][1]?>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-8 pl-md-0">
                <table class="table table-hover table-bordered table-dark " style="background-color: #21262f; opacity: 0.9">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Current Players</th>
                            <th scope="col">Peak Players Today</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($games['topGamesNames'] as $key => $value) {
                            echo '<tr>';
                            echo '<td>' . $value . '</td>';
                            echo '<td>' . $games['currentPlayers'][$key] . '</td>';
                            echo '<td>' . $games['peakPlayers'][$key] . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4 pr-md-0">
                <div class="card text-white mb-3" style="background-color: #21262f; opacity: 0.9">
                    <div class="card-header">Counter-Strike:Global Offensive</div>
                    <div class="card-body">
                        <div id="divRss0"></div>
                    </div>
                </div>
                <div class="card text-white mb-3" style="background-color: #21262f; opacity: 0.9">
                    <div class="card-header">Dota 2</div>
                    <div class="card-body">
                        <div id="divRss1"></div>
                    </div>
                </div>
                <div class="card text-white mb-3" style="background-color: #21262f; opacity: 0.9">
                    <div class="card-header">Cyberpunk 2077</div>
                    <div class="card-body">
                        <div id="divRss2"></div>
                    </div>
                </div>
                <div class="card text-white mb-3" style="background-color: #21262f; opacity: 0.9">
                    <div class="card-header">Player Unknown: Battlegrounds</div>
                    <div class="card-body">
                        <div id="divRss3"></div>
                    </div>
                </div>
                <div class="card text-white mb-3" style="background-color: #21262f; opacity: 0.9">
                    <div class="card-header">Grand Theft Auto V</div>
                    <div class="card-body">
                        <div id="divRss4"></div>
                    </div>
                </div>
                <div class="card text-white mb-3" style="background-color: #21262f; opacity: 0.9">
                    <div class="card-header">Rainbow six: Siege</div>
                    <div class="card-body">
                        <div id="divRss5"></div>
                    </div>
                </div>
                <div class="card text-white mb-3" style="background-color: #21262f; opacity: 0.9">
                    <div class="card-header">Apex Legends</div>
                    <div class="card-body">
                        <div id="divRss6"></div>
                    </div>
                </div>
                <div class="card text-white mb-3" style="background-color: #21262f; opacity: 0.9">
                    <div class="card-header">Destiny 2</div>
                    <div class="card-body">
                        <div id="divRss7"></div>
                    </div>
                </div>
                <div class="card text-white mb-3" style="background-color: #21262f; opacity: 0.9">
                    <div class="card-header">Path of Exile</div>
                    <div class="card-body">
                        <div id="divRss8"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php




?>
<canvas id="SteamChart"></canvas>

<script>
    var Onlinedatastats = [];
    Onlinedatastats.push("<?=$games['allCurrentOnline'][0]?>")


    var ctx = document.getElementById('SteamChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'My First dataset',
            borderColor: 'rgb(255, 99, 132)',
            data: Onlinedatastats
        }]
    },

    // Configuration options go here
    options: {}
});
console.log(Onlinedatastats);
</script>








@endsection
