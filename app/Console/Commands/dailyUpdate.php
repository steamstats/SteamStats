<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use App\Models\Game as gameModel;
use App\Models\Genre as genreModel;

class dailyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add or update the games in the database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $games = new gameModel();
        $games = $games->getGames();

        set_time_limit(0);

        foreach($games as $game){

            sleep(0.1);

            $id = $game['appid'];

            $gameExists = gameModel::where('appid', $id)->first();

            if($gameExists === null){

                $gameInfo = new gameModel();
                $gameInfo = $gameInfo->getGame($id);

                if(!empty($gameInfo)){
                    if($gameInfo['data']['release_date']['coming_soon'] == true){
                        $priceFormatted = "Coming Soon";
                        $price = NULL;
                    }
                    elseif($gameInfo['data']['is_free'] == true){
                        $priceFormatted = "Free to Play";
                        $price = NULL;
                    }
                    elseif(!empty($gameInfo['data']['price_overview'])){
                        $priceFormatted = $gameInfo['data']['price_overview']['final_formatted'];
                        $price = $gameInfo['data']['price_overview']['final'];
                    }

                    if($gameInfo['success'] == true){
                        if($gameInfo['data']['type'] == 'game'){

                            $newGame = gameModel::updateOrCreate(['appid' => $game['appid']],['appid' => $game['appid'],'name' => $game['name'], 'price' => $price, 'price_formatted' => $priceFormatted, 'image' => $gameInfo['data']['header_image']]);

                            if(!empty($gameInfo['data']['genres'])){
                                foreach($gameInfo['data']['genres'] as $genre){

                                    genreModel::firstOrCreate(['id' => $genre['id']], ['name' => $genre['description']]);

                                    DB::table('game_genre')->insert(['game_id' => $newGame->id, 'genre_id' => $genre['id']]);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
