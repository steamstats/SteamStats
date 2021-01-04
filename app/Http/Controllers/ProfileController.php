<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Profile;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */


    public function index(Request $request)
    {

        $id = $request->id;
        $data = new Profile;
        $data = $data->getProfileSummary($id);


        $banInfo = new profile;
        $banInfo = $banInfo->getBanInfo($id);

        $recentlyPlayedGames = new profile;
        $recentlyPlayedGames = $recentlyPlayedGames->getRecentlyPlayedGames($id);

        $playerLevel = new profile;
        $playerLevel = $playerLevel->getPlayerLevel($id);

        $profileBackground = new profile;
        $profileBackground = $profileBackground->getProfileBackground($id);

        $resolvedurl = new profile;
        $resolvedurl = $resolvedurl->resolveCustomURL($id);

        $customFrame = new profile;
        $customFrame = $customFrame->getAvatarFrame($id);

        $ownedGames = new profile;
        $ownedGames = $ownedGames->getOwnedGames($id);

        $playtimeForever = 0;
        if(isset($ownedGames['response']['games'])) {
            foreach ($ownedGames['response']['games'] as $test) {
                $playtimeForever = $playtimeForever + $test['playtime_forever'];
            }
            $hoursOnRecord = round($playtimeForever / 60,1);
            $averagePlaytime = round($hoursOnRecord / $ownedGames['response']['game_count'],1);
        }


        $gamedata = [];

        if (!empty($data['response']['players'])) {
            $gamedata['data'] = $data['response']['players'][0];
        } else {
            return redirect()->back();
        }
        if (!empty($banInfo)) {
            $gamedata['banInfo'] = $banInfo['players'][0];
        } else {
            return redirect()->back();
        }
        if (!empty($recentlyPlayedGames['response']['games'])) {
            $gamedata['recentlyPlayedGames'] = $recentlyPlayedGames['response']['games'];
        }
        if (!empty($playerLevel['response'])) {
            $gamedata['playerLevel'] = $playerLevel['response'];
        } else {
            return redirect()->back();
        }
        if (!empty($profileBackground['response'])) {
            $gamedata['profileBackground'] = $profileBackground['response']['profile_background'];
        }
        if(!empty($customFrame['response'])) {
            $gamedata['customAvatarFrame'] = $customFrame['response']['avatar_frame'];
        }
        if(!empty(($ownedGames['response']))) {
            $gamedata['ownedGames'] = $ownedGames['response'];
            $gamedata['averagePlaytime'] = $averagePlaytime;
            $gamedata['hoursOnRecord'] = $hoursOnRecord;
        }

        return view('profile', ['gamedata'=>$gamedata]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function show(Request $request)
    {
        $id = $request->id;
        $resolvedurl = new profile;
        $resolvedurl = $resolvedurl->resolveCustomURL($id);

        if(isset($resolvedurl['response']['steamid'])) {
            $id = $resolvedurl['response']['steamid'];
        } elseif(isset($resolvedurl['response']['message'])){
            $id = $request->id;
        }

        $data = new Profile;
        $data = $data->getProfileSummary($id);

        $banInfo = new profile;
        $banInfo = $banInfo->getBanInfo($id);

        $recentlyPlayedGames = new profile;
        $recentlyPlayedGames = $recentlyPlayedGames->getRecentlyPlayedGames($id);

        $playerLevel = new profile;
        $playerLevel = $playerLevel->getPlayerLevel($id);

        $profileBackground = new profile;
        $profileBackground = $profileBackground->getProfileBackground($id);

        $customFrame = new profile;
        $customFrame = $customFrame->getAvatarFrame($id);

        $ownedGames = new profile;
        $ownedGames = $ownedGames->getOwnedGames($id);


// PROFILE NOT FOUND OR PRIVATE

        $gamedata = [];

        if (!empty($data['response']['players'])) {
            $gamedata['data'] = $data['response']['players'][0];
        } else {
            return redirect()->back();
        }
        if (!empty($banInfo)) {
            $gamedata['banInfo'] = $banInfo['players'][0];
        } else {
            return redirect()->back();
        }
        if (!empty($recentlyPlayedGames['response']['games'])) {
            $gamedata['recentlyPlayedGames'] = $recentlyPlayedGames['response']['games'];
        }
        if (!empty($playerLevel['response'])) {
            $gamedata['playerLevel'] = $playerLevel['response'];
        } else {
            return redirect()->back();
        }
        if (!empty($profileBackground['response'])) {
            $gamedata['profileBackground'] = $profileBackground['response']['profile_background'];
        }
        if(!empty($customFrame['response'])) {
            $gamedata['customAvatarFrame'] = $customFrame['response']['avatar_frame'];
        }
        if(!empty(($ownedGames['response']))) {
            $gamedata['ownedGames'] = $ownedGames['response'];
        }

        return Redirect::to('/user/'.$id);
//        return view('profile', ['gamedata'=>$gamedata]);
    }

    public function test(){

        return view('user');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
