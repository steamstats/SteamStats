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
    public $appid;
    /**
     * @var mixed
     */


    /**
     * @return mixed
     */
    public function getProfileSummary($id){
        $this->steamid = $id;
        return Http::get('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamids='. $this->steamid)->json();
    }

    /**
     * @return array|mixed
     */
    public function getBanInfo($id){
        $this->steamid = $id;
        return Http::get('http://api.steampowered.com/ISteamUser/GetPlayerBans/v1/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamids='. $this->steamid)->json();
    }

    /**
     * @return array|mixed
     */
    public function getRecentlyPlayedGames($id){
        $this->steamid = $id;
        return Http::get('http://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamid='. $this->steamid .'&count=5')->json();
    }

    /**
     * @param $id
     * @return array|mixed
     */
    public function getPlayerLevel($id){
        $this->steamid = $id;
        return Http::get("https://api.steampowered.com/IPlayerService/GetBadges/v1/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamid=".$this->steamid)->json();
    }

    /**
     * @param $id
     * @return array|mixed
     */
    public function getProfileBackground($id){
        $this->steamid = $id;
        return Http::get("https://api.steampowered.com/IPlayerService/GetProfileBackground/v1/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamid=".$this->steamid)->json();
    }

    /**
     * @param $id
     * @return array|mixed
     */
    public function getAvatarFrame($id){
        $this->steamid = $id;
        return Http::get("https://api.steampowered.com/IPlayerService/GetAvatarFrame/v1/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamid=".$this->steamid)->json();
    }

    /**
     * @param $id
     * @return array|mixed
     */
    public function getOwnedGames($id) {
        $this->steamid = $id;
        return Http::get('https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamid='.$this->steamid)->json();
    }

    /**
     * @param $id
     * @return array|mixed
     */
    public function resolveCustomURL($id){
        $this->steamid = $id;
        return Http::get("https://api.steampowered.com/ISteamUser/ResolveVanityURL/v1/?key=3FE725B04637FA6637A3BA1684CFEEF9&vanityurl=".$this->steamid)->json();
    }

    /**
     * @param $id
     * @return array|mixed
     */
    public function getBadges($id){
        $this->steamid = $id;
        return Http::get('https://api.steampowered.com/IPlayerService/GetBadges/v1/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamid='.$this->steamid)->json();
    }

    public function getFriendList($id){
        $this->steamid = $id;
        return Http::get('https://api.steampowered.com/ISteamUser/GetFriendList/v1/?key=3FE725B04637FA6637A3BA1684CFEEF9&steamid='.$this->steamid)->json();
    }

    public function getAchievementProgress($id, $apps){
        $this->steamid = $id;
        $this->appid = $apps;
        return Http::get('http://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v0001/?appid='.$this->appid.'&key=3FE725B04637FA6637A3BA1684CFEEF9&steamid='.$this->steamid)->json();
    }
}
