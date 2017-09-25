<?php

/**
 * Description of game_controller
 *
 * @author olindqvi
 */
class game_controller extends BaseController {

    public static function GameLog() {
        $games = Game::all(); //array(Game::all());
        View::make('gamelog.html', array('games' => $games));
    }

    public static function detailedGameInfo($game_id) {
        $game = Game::find($game_id);
//        View::make('gamelog.html', array('games' => $games));
        View::make('detailedGameInformation.html', array('game' => $game));
    }

//      public static function detailedGameInfo() {
////        $game = Game::find(1);
////        View::make('gamelog.html', array('games' => $games));
//        View::make('detailedGameInformation.html');
////                , $game);
//    }
//  public static function detailedGameInfo() {
//        View::make('detailedGameInformation.html');
//    }



    public static function joinGame() {
        $openGames = playergame::findAllGamesWithSpace();
        Kint::dump($openGames);
        View::make('joinGame.html', array('openGames' => $openGames));
    }

}
