<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('home.html');
//        echo 'Tämä on etusivu!';
    }

    public static function sandbox() {
        // Testaa koodiasi täällä
//        echo 'Hello World!';
        //Player kint
        $player = player::find(1);
        $players = player::all();

        Kint::dump($player);
        Kint::dump($players);

        //Game kint
        $game = Game::find(1);
        $games = Game::all();

        Kint::dump($game);
        Kint::dump($games);

        //Playergame kint
        $pgame = playergame::find(1);
        $pgames = playergame::all();
        $playersIngame = playergame::findAllPlayersInGame(1);

        Kint::dump($pgame);
        Kint::dump($pgames);
        Kint::dump($playersIngame);

        //Playerstats kint
        $pstats = playerstats::find(1);
        $allPstats = playerstats::all();

        Kint::dump($pstats);
        Kint::dump($allPstats);
    }

    public static function register() {
        View::make('registerpage.html');
    }

    public static function login() {
        View::make('login.html');
    }

    public static function ladder() {
//        echo 'MOIOIOI';
        View::make('ladder.html');
    }

//    public static function joinGame() {
//        View::make('joinGame.html');
//    }

    public static function gameLog() {
        View::make('gamelog.html');
    }
//
//    public static function personalInfo() {
//        View::make('personalinfo.html');
//    }

    public static function detailedGameInfo() {
        View::make('detailedGameInformation.html');
    }

}
