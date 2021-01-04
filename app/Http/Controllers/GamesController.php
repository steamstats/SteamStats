<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Models\Game as gameModel;
use App\Models\Genre as genreModel;
use App\Models\Review as reviewModel;
use App\Models\User as userModel;

use Illuminate\Pagination\LengthAwarePaginator;


use App\Helper\Helper;
use Symfony\Component\Console\Input\Input;

class GamesController extends Controller
{

    private $categories;
    private $genres;

    public function __construct()
    {
        $genre = DB::table('genres')
        ->select('*')
        ->get();

        $getCategories = new gameModel();
        $getCategories = $getCategories->getFeaturedCategories();

        $category = array();
        $category['new_releases'] = $getCategories['new_releases'];
        $category['top_sellers']  = $getCategories['top_sellers'];
        $category['coming_soon']  = $getCategories['coming_soon'];
        $category['specials']     = $getCategories['specials'];

        $this->genres = $genre;
        $this->categories = $category;

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {

        $games = gameModel::select('appid','name', 'price', 'price_formatted', 'image')
            ->whereNotNull('price')
            ->sortable()
            ->paginate(15);

        $genres = $this->genres;
        $categories = $this->categories;

        return view('games.games')
            ->with('games', $games)
            ->with('genres', $genres)
            ->with('categories', $categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Application|Factory|View|Response
     */
    public function sortGenre(Request $request){

        $inputs = $request->input();

        $games = gameModel::select('games.*')
            ->join('game_genre', 'games.id', '=', 'game_genre.game_id')
            ->join('genres', 'game_genre.genre_id', '=', 'genres.id')
            ->Where(function ($query) use($inputs) {
                foreach($inputs as $key => $input){
                    if($key != 'page'){
                        $query->orwhere('genres.id', $input);
                    }
                }
            })
            ->distinct('games.id')
            ->sortable()
            ->paginate(15);

            $genres = $this->genres;
            $categories = $this->categories;

        return view('games.games')
            ->with('games', $games)
            ->with('genres', $genres)
            ->with('categories', $categories);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function search(Request $request)
    {
        $search =  $request->input('q');
        if($search!=""){
            $games = gameModel::where(function ($query) use ($search){
                $query->where('appid', 'like', $search)
                    ->orWhere('name', 'like', '%'.$search.'%');
            })
                ->orderBy('name')
                ->paginate(15);
            $games->appends(['q' => $search]);
        }
        else{
            $games = gameModel::paginate(15);
        }

        $genres = $this->genres;
        $categories = $this->categories;

        return view('games.games')
            ->with('games', $games)
            ->with('genres', $genres)
            ->with('categories', $categories);
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


    /**
     * @param Request $id
     * @param $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function show(Request $request){

        $game = new gameModel();
        $game->id = $request->id;
        $game = $game->getGame($game['id']);

        if(!empty($game['data'])) {
            $reviews = reviewModel::where('appid', $game['data']['steam_appid'])->orderBy('id', 'DESC')->get();

            $stars = array();
            $stars['5'] = 0;
            $stars['4'] = 0;
            $stars['3'] = 0;
            $stars['2'] = 0;
            $stars['1'] = 0;

            foreach ($reviews as $review) {
                if ($review['stars'] == 5) {
                    $stars['5']++;
                } elseif ($review['stars'] == 4) {
                    $stars['4']++;
                } elseif ($review['stars'] == 3) {
                    $stars['3']++;
                } elseif ($review['stars'] == 2) {
                    $stars['2']++;
                } elseif ($review['stars'] == 1) {
                    $stars['1']++;
                }

                if(Reply::where('review_id', $review['id'])->exists()){
                    $review['replies'] = Reply::where('review_id', $review['id'])->get();
                }

                $review['steam'] = userModel::where('steamid', $review['steamid'])->get();
                unset($review['steamid']);
                if (date('d/m/Y') == $review['created_at']->format('d/m/Y')) {
                    $review['ago'] = Helper::time_elapsed_string($review['created_at']);
                }

                if ($review['created_at'] != $review['updated_at']) {
                    $review['reviewAgo'] = Helper::time_elapsed_string($review['updated_at']);
                }

                if (isset($review['replies'])){
                    foreach ($review['replies'] as $reply){
                        $reply['steam'] = userModel::where('steamid', $reply['steamid'])->get();
                        unset($reply['steamid']);
                        if (date('d/m/Y') == $reply['created_at']->format('d/m/Y')) {
                            $reply['ago'] = Helper::time_elapsed_string($reply['created_at']);
                        }
                        if ($reply['created_at'] != $reply['updated_at']) {
                            $reply['replyAgo'] = Helper::time_elapsed_string($reply['updated_at']);
                        }
                    }
                }
            }



            if (!$reviews->isEmpty()) {
                $stars['total'] = $stars['5'] + $stars['4'] + $stars['3'] + $stars['2'] + $stars['1'];
                $stars['average'] = Helper::calculateAverageStars($stars);
                $stars['starPercentage'] = Helper::calculateStarsPercentage($stars);
                return view('games.game_page')->with('game', $game['data'])->with('reviews', $reviews)->with('stars', $stars);
            } else {
                return view('games.game_page')->with('game', $game['data'])->with('reviews', $reviews);
            }
        }
        else
            return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return Response
     */
    public function destroy()
    {
        //
    }
}
