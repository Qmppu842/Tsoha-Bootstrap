<?php

/**
 * Description of playergame
 *
 * @author olindqvi
 */
class playergame extends BaseModel {

    //put your code here

    public $player_id, $game_id, $picked;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Playergame WHERE player_id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $game = new playergame(array(
                'player_id' => $row['player_id'],
                'game_id' => $row['game_id'],
                'picked' => $row['picked']
            ));
        }
        return $game;
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Playergame');
        $query->execute();

        $rows = $query->fetchAll();
        $games = array();

        foreach ($rows as $row) {
            $games[] = new playergame(array(
                'player_id' => $row['player_id'],
                'game_id' => $row['game_id'],
                'picked' => $row['picked']
            ));
        }
        return $games;
    }

    public function addPlayerToGame($player_id, $game_id, $picked) {
        $playersInGame = self::findAllPlayersInGame($this->game_id);
        settype($playersInGame, "int");
        if ($playersInGame < 3) {
            $tietokantalause = 'INSERT INTO Playergame (player_id, game_id, picked) VALUES (' + $player_id + ', ' + $game_id + ', ' + $picked + ')';
            settype($tietokantalause, "string");
            $query = DB::connection()->prepare($tietokantalause);
            $query->execute(array('game_id' => $game_id, 'player_id' => $player_id, 'picked' => $picked));
            $row = $query->fetch();


            Kint::trace();
            Kint::dump($row);
        } else {
            trigger_error("Peli täynnä");
        }
    }

//      private function addPlayerToGame($player_id, $picked) {
//        if (count($this->players) < 3) {
//            $this->players[] = player::find($player_id);
//        } else {
//            trigger_error("Peli on jo täynnä");
//        }
//    }

    public static function findGamePlayers($id) {
        $query = DB::connection()->prepare('SELECT * FROM Playergame WHERE game_id = :id');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $game = new playergame(array(
                'player_id' => $row['player_id'],
                'game_id' => $row['game_id'],
                'picked' => $row['picked']
            ));
        }
        return $game;
    }

    public static function findAllPlayersInGame($game_id) {
        $query = DB::connection()->prepare('SELECT * FROM Playergame WHERE game_id = :game_id');
        $query->execute(array('game_id' => $game_id));

        $rows = $query->fetchAll();
        $playersInGame = array();

        foreach ($rows as $row) {
            $playersInGame[] = new playergame(array(
                'player_id' => $row['player_id'],
                'game_id' => $row['game_id'],
                'picked' => $row['picked']
            ));
        }
        return $playersInGame;
    }

//    public static function findAllGamesWithSpace() {
//        $query = DB::connection()->prepare('SELECT * FROM Playergame');
//        $query->execute();
//
//        $rows = $query->fetchAll();
//        $games = array();
//
//        foreach ($rows as $row) {
//            $games[] = new playergame(array(
//                'player_id' => $row['player_id'],
//                'game_id' => $row['game_id'],
//                'picked' => $row['picked']
//            ));
//        }
//        return $games;
//    }

    public static function findAllGamesWithSpace() {
        $query = DB::connection()->
                prepare('SELECT id, name, COUNT(*) FROM Game g FULL OUTER JOIN Playergame pg ON g.id = pg.game_id GROUP BY g.id HAVING (COUNT(*)) < 3;');
        $query->execute();

        $rows = $query->fetchAll();
//        $games = array();
//
//        foreach ($rows as $row) {
//            $games[] = new playergame(array(
////                'player_id' => $row['player_id'],
//                'id' => $row['id'],
//                'name' => $row['name']
//            ));
//        }
//        $uniqRows = array_unique($rows);
        $d = 3;
        for ($a = 0; $a < $d; $a++) {
            for ($b = 0; $b < $d; $b++) {
                echo $rows[$a][$b];
                echo '  a:';
                echo $a;
                echo $b;
                echo '  ';
            }
            echo '<br>';
        }
        echo $rows[3][2];
        $games = $rows;
        Kint::dump($rows);
        Kint::dump($games);
//        TODO: Selvitä tämä käyttäytimeninen ja miksi ohjelma ei toimi tietyillä arvoilla vaikka kint sanoo arvoja olevan paljon enemmän
//        Mitä ihmettä tässä tapahtuu.....
//        katso kint joingame sivulta lisä infoksi.
        return $games;
    }

    public static function findAllGamesWithNoSpace() {
        $query = DB::connection()->prepare('SELECT game_id, COUNT(*) FROM Playergame GROUP BY game_id HAVING (COUNT(*)) >= 3;');
        $query->execute();

        $rows = $query->fetchAll();
        $games = array();

        foreach ($rows as $row) {
            $games[] = new playergame(array(
                'player_id' => $row['player_id'],
                'game_id' => $row['game_id'],
                'picked' => $row['picked']
            ));
        }
        return $games;
    }

    
      public function save() {
        $query = DB::connection()->prepare('INSERT INTO Playergame (game_id, player_id, picked) VALUES (:game_id, :player_id, :picked);');
        $query->execute(array('game_id' => $this->game_id, 'player_id' => $this->player_id, 'picked' => $this->picked));
        $query->fetch();
    }
}
