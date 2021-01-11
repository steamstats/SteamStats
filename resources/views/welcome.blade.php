@extends('layouts.app')
@section('content')

    <img src="{{ asset('img/homepage/csgo.jpg') }}" style="position: absolute;width:100%;top:0;height: 120%;z-index: -1; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));mask-image: linear-gradient(to bottom, rgba(0,0,0,1), rgba(0,0,0,0));">

<div class="container mt-3">
    <div class="row">
        <div class="col-lg-12" style="margin-top: 75px;">

            <div class="my-3">
                <img src="{{ asset('img/logo.png') }}" alt="logo" class="mx-auto d-block">
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
    <div class="col-md-8">
        <table class="table table-hover table-bordered table-dark " style="background-color: #282e39; opacity: 0.9">
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
</div>








@endsection
