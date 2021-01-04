<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

use App\Console\Commands\scrapeCommand as Scraper;

class Stat extends Model
{
    use HasFactory;

     public function getMostPlayedGames(){

        $data = [];
        $data = new Scraper;
        $data = $data->handle();

        return $data;
     }


































}
