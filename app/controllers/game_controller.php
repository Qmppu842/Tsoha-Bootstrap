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
        for ($index = 0; $index < sizeof($fullPlayers); $index++) {
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
//        if (self::check_logged_in() == null) {
//            Redirect::to('/', array('message' => 'Kirjatumis pakko...'));
//        }
        self::check_logged_in();
        $openGames = playergame::findAllGamesWithSpace();
//        Kint::dump($openGames);
        View::make('joinGame.html', array('openGames' => $openGames));
    }

    public static function joinGamePost() {
        self::check_logged_in();
        $params = $_POST;
        $openGames = playergame::findAllGamesWithSpace();
        Kint::dump($params);
//        Kint::trace();
//         Redirect::to('/joingame', array('message' => 'onnistuit!'));
//        self::joinGame();
//        die();
        $usableThings = array(
            'card' => $params['KortinValitsin'],
            'game' => $params['GameSelector']
        );
        //TODO: implement some fun method to make invalid cards to choose losing card
        if ($usableThings['card'] < 0 || $usableThings['card'] > 4) {
            $usableThings['card'] = rand(0, 4);
        }
        $arrayOfIds = array();
        foreach ($openGames as $keyKaiketi => $oneOpenGameInOneRow) {
            //jotain = 1 row.
//            kint::dump($oneOpenGameInOneRow);
            $arrayOfIds[] = $oneOpenGameInOneRow[0];

//            foreach ( $jotain  as $toka => $mika){
//            kint::dump($eka);
//            kint::dump($toka);
//            kint::dump($mika);    
//                
//            }
        }
        $player_id = $_SESSION['user'];
        $arrayOfLegalGames = array();
        foreach ($arrayOfIds as $jotain => $value) {
            if (playergame::findIfPlayerIsInGame($value, $player_id)) {
                $arrayOfLegalGames[] = $value;
            }
        }

        if (sizeof($arrayOfLegalGames) < 1) {
            $ran = rand(0, 9999999);
            $nimi;
            settype($nimi, 'String');
            $nimi = 'New and Epic Gaem '.$ran;
            $gaem = new Game(array('name' => $nimi));
            Kint::dump($gaem);
            $arrayOfLegalGames[] = $gaem->save3();
        }

        if (!in_array($usableThings['game'], $arrayOfLegalGames)) {
            if (!$usableThings['game'] == "-20") {
                $usableThings['game'] = "-20";
            }
            $random = rand(1, sizeof($arrayOfLegalGames));
            $usableThings['game'] = $random;
        }

//       $joining = new playergame(array(
//                'player_id' => $_SESSION['user'],
//                'game_id' => $usableThings['game'],
//                'picked' => $usableThings['card']
//            ));
//       $joining->save();

        playergame::addPlayerToGame($_SESSION['user'], $usableThings['game'], $usableThings['card']);
        kint::dump($arrayOfLegalGames);
        kint::dump($arrayOfIds);
        kint::dump($openGames);
        View::make('joinGame.html', array('openGames' => $openGames, 'message' => 'onnistuit kaiketi'));
    }

}
