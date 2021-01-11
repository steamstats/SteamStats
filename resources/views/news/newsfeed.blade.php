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

<div class="container my-3">
    <div class="row">
        <div class="col-md-4 border border-dark">
        <h4 class="text-center">Counter-Strike:Global Offensive</h4>
            <div id="divRss0"> </div>
        </div>
        <div class="col-md-4 border border-dark">
        <h4 class="text-center">Dota 2</h4>
            <div id="divRss1"> </div>
        </div>
        <div class="col-md-4 border border-dark">
        <h4 class="text-center">Cyberpunk 2077</h4>
            <div id="divRss2"> </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 border border-dark">
        <h4 class="text-center">Player Unknown:Battlegrounds</h4>
            <div id="divRss3"> </div>
        </div>
        <div class="col-md-4 border border-dark">
        <h4 class="text-center">Grand Theft Auto V</h4>
            <div id="divRss4"> </div>
        </div>
        <div class="col-md-4 border border-dark">
        <h4 class="text-center">Rainbow six: Siege</h4>
            <div id="divRss5"> </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 border border-dark">
        <h4 class="text-center">Apex Legends</h4>
            <div id="divRss6"> </div>
        </div>
        <div class="col-md-4 border border-dark">
        <h4 class="text-center">Destiny 2</h4>
            <div id="divRss7"> </div>
        </div>
        <div class="col-md-4 border border-dark">
        <h4 class="text-center">Path of Exile</h4>
            <div id="divRss8"> </div>
        </div>
    </div>
</div>

@endsection