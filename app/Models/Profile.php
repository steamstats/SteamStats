<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Profile extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [

    ];

    public $steamid;
    public $customid;

    /**
     * @return mixed
     */
    public function getProfileSummary($id){

        $this->steamid = $id;
        $data = Http::get('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamids='. $this->steamid)->json();

        return $data;
    }

    /**
     * @return array|mixed
     */
    public function getBanInfo($id){
        $this->steamid = $id;
        $banInfo = Http::get('http://api.steampowered.com/ISteamUser/GetPlayerBans/v1/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamids='. $this->steamid)->json();

        return $banInfo;
    }

    /**
     * @return array|mixed
     */
    public function getRecentlyPlayedGames($id){
        $this->steamid = $id;
        $recentlyPlayedGames = Http::get('http://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamid='. $this->steamid .'&count=5')->json();

        return $recentlyPlayedGames;
    }

    public function getPlayerLevel($id){
        $this->steamid = $id;
        $playerLevel = Http::get("https://api.steampowered.com/IPlayerService/GetBadges/v1/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamid=".$this->steamid)->json();

        return $playerLevel;
    }

    public function getProfileBackground($id){
        $this->steamid = $id;
        $profileBackground = Http::get("https://api.steampowered.com/IPlayerService/GetProfileBackground/v1/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamid=".$this->steamid)->json();

        return $profileBackground;

    }

    public function getAvatarFrame($id){
        $this->steamid = $id;
        $customFrame = Http::get("https://api.steampowered.com/IPlayerService/GetAvatarFrame/v1/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamid=".$this->steamid)->json();

        return $customFrame;
    }

    public function getOwnedGames($id) {
        $this->steamid = $id;
        $ownedGames = Http::get('https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamid='.$this->steamid)->json();

        return $ownedGames;
    }

    public function resolveCustomURL($id){
        $this->customid = $id;
        $resolvedurl = Http::get("https://api.steampowered.com/ISteamUser/ResolveVanityURL/v1/?key=3FE725B04637FA6637A3BA1684CFEEF9&vanityurl=".$this->customid)->json();

        return $resolvedurl;
    }

//     WISHLIST API CALL   https://store.steampowered.com/wishlist/profiles/76561198088141566/wishlistdata/?p=0

}
