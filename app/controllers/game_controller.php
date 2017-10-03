<?php

/**
 * Description of game_controller
 *
 * @author olindqvi
 */
class game_controller extends BaseController {

    public static function GameLog() {
        $games = Game::all(); //array(Game::all());
        Kint::dump($games);
        View::make('gamelog.html', array('games' => $games));
    }

    public static function detailedGameInfo($game_id) {
        $game = Game::find($game_id);
        $playerIdsInGame = playergame::findAllPlayersInGame($game_id);
        $fullPlayers = array();
        $listOfPickings = array();
        for ($index = 0; $index < sizeof($playerIdsInGame); $index++) {
            $fullPlayers[] = player::find($playerIdsInGame[$index]->player_id);
            $listOfPickings[] = $playerIdsInGame[$index]->picked;
        }
        $listOfNames = array();
        for ($index = 0; $index < sizeof($fullPlayers); $index++){
            $listOfNames[] = $fullPlayers[$index]->name;
            
            
        }
        

//        View::make('gamelog.html', array('games' => $games));
        View::make('detailedGameInformation.html', array('game' => $game, 'players' => $listOfNames, 'picked' => $listOfPickings));
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
