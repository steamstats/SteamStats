@extends('layouts.app')
@section('content')

<script type="text/javascript">

var links = ['https://store.steampowered.com/feeds/news/app/20/', 'https://store.steampowered.com/feeds/news/app/730/']


$(document).ready(function(){
    for(var i = 0; i<=links.length; i++){
$('#divRss'+i).FeedEk({
FeedUrl : links[i],
MaxCount : 5,
ShowDesc : false,
ShowPubDate : true
});} }); </script>

<div id="divRss0"> </div>


<div id="divRss1"> </div>
@endsection