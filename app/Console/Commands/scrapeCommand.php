<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;


class scrapeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scraper:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $client = new Client();

        $crawler = $client->request('GET', 'https://store.steampowered.com/stats/');
        $data['allCurrentOnline'] = $crawler->filter('td > .statsTopHi')->each(function ($node) {
            return $node->text();
        });

        $crawler = $client->request('GET', 'https://store.steampowered.com/stats/');
        $data['topGamesStats'] = $crawler->filter('tr > td > .currentServers')->each(function ($node) {
            return $node->text();
        });

        $crawler = $client->request('GET', 'https://store.steampowered.com/stats/');
        $data['topGamesNames'] = $crawler->filter('tr > td > .gameLink')->each(function ($node) {
            return $node->text();
        });

        return $data;

    }
}
