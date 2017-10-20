<?php

/**
 * Description of playergame is:
 * This is point between playergame table in database and rest of the program.
 *
 * @author olindqvi
 */
class playergame extends BaseModel {

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
    
     public static function findIfPlayerIsInGame($game_id, $player_id) {
        $query = DB::connection()->prepare('SELECT * FROM Playergame WHERE player_id = :player_id AND game_id = :game_id LIMIT 1');
        $query->execute(array('player_id' => $player_id, 'game_id' => $game_id));
        $row = $query->fetch();
//        if ($row) {
//            $game = new playergame(array(
//                'player_id' => $row['player_id'],
//                'game_id' => $row['game_id'],
//                'picked' => $row['picked']
//            ));
//        }
//        Kint::dump($row);
        if (sizeof($row) == 0) {
            return true;
        }
        return false;
    }

    public static function addPlayerToGame($player_id, $game_id, $picked) {
        $playersInGame = self::findAllPlayersInGame($game_id);
        settype($playersInGame, "int");
        if ($playersInGame < 3 || Game::find($game_id)->is_over_yet) {
            $tietokantalause = 'INSERT INTO Playergame (player_id, game_id, picked) VALUES (  :player_id , :game_id, :picked );';
            settype($tietokantalause, "string");
            $query = DB::connection()->prepare($tietokantalause);
            $query->execute(array('player_id' => $player_id, 'game_id' => $game_id, 'picked' => $picked));
            $row = $query->fetch();

            
            $ssd = self::playerCountInGame($game_id);
            if ($ssd >= 3){
                Game::endGame($game_id);                
            }
            Kint::dump($row);
            Kint::dump($ssd);

//            Kint::trace();
        } else {
            trigger_error("Peli täynnä");
            echo 'lisäämis errori  playergame addplayerstogame';
        }
    }

    /**
     * Ottaaa game_id:n jonka perusteella paluttaa 
     * pelaajat pelissä.
     * 
     * @param type $id
     * @return \playergame
     */
    public static function findGamePlayers($id) {
        $query = DB::connection()->prepare('SELECT * FROM Playergame WHERE game_id = :id');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        //TODO: ei vaikuta toimivalta tarkista tämä.
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

    /**
     * Hakee game_id:n perustaalla pelaaja määrän.
     * 
     * @param type $game_id
     * @return int
     */
    public static function playerCountInGame($game_id) {
        $query = DB::connection()->prepare('SELECT COUNT(*) AS moi FROM Playergame WHERE game_id = :game_id;');
        $query->execute(array('game_id' => $game_id));

        $rows = $query->fetchAll();
//        $playersInGame = array();
//
//        foreach ($rows as $row) {
//            $playersInGame[] = new playergame(array(
//                'player_id' => $row['player_id'],
//                'game_id' => $row['game_id'],
//                'picked' => $row['picked']
//            ));
//        }
//        var_dump($rows);
        
//        Kint::dump($rows);
//        Kint::dump($rows[0][0]);
        echo 'Jos näet tämän niin mene playergameen playerCountInGame metodiin';
        //TODO: muuta palautus arvo vastaamaan countin tulosta
        return $rows[0][0];
    }

    /**
     * Tämä palauttaa kaikki pelit missä on tilaa
     * 
     * @return type
     */
    public static function findAllGamesWithSpace() {
        $query = DB::connection()->
                prepare('SELECT id, name, COUNT(*) FROM Game g FULL OUTER JOIN Playergame pg ON g.id = pg.game_id GROUP BY g.id HAVING (COUNT(*)) < 3;');
        $query->execute();

        $rows = $query->fetchAll();
        $games = array();
//
        foreach ($rows as $row) {
            $games[] = new playergame(array(
//                'player_id' => $row['player_id'],
                'id' => $row['id'],
                'name' => $row['name']
            ));
        }
//        $uniqRows = array_unique($rows);
//        $d = 3;
//        for ($a = 0; $a < $d; $a++) {
//            for ($b = 0; $b < $d; $b++) {
//                echo $rows[$a][$b];
//                echo '  a:';
//                echo $a;
//                echo $b;
//                echo '  ';
//            }
//            echo '<br>';
//        }
//        echo $rows[3][2];
        $games = $rows;
//        Kint::dump($rows);
//        Kint::dump($games);
//        die();
        //TODO: Selvitä tämä käyttäytimeninen ja miksi ohjelma ei toimi tietyillä arvoilla vaikka kint sanoo arvoja olevan paljon enemmän
//        Mitä ihmettä tässä tapahtuu.....
//        katso kint joingame sivulta lisä infoksi.
        return $games;
    }

    /**
     * Etsii kaikki pelit missä on tilaa
     * ja palauttaa ne.
     * 
     * @return \playergame
     */
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

    /**
     * Päivittää pelaajan valinnan kyseisessä pelissä
     * 
     * @param type $id
     */
    public function update($id) {
        //TODO: tämän on pakko tarvita game_id, player_id ja picked
        //ilman niitä on luvatonta käyttää tätä metodia
//        $query = DB::connection()->prepare('UPDATE Playergame SET picked = :picked WHERE player_id = :player_id AND game_id = :game_id');
//        $query->execute(array('picked' => $this->picked, 'player_id' => $this->player_id, 'game_id' => $this->game_id));
//        $row = $query->fetch();
//
//        Kint::dump($row);

        error_log('Playergame ei pitäisi tarvita updatea...');
        error_log('^Korjaus kyllä tätä voi käyttää mutta ei vielä toiminta kunnossa.');
        //TODO: tosin voisi kyllä tehdä mahdollisuuden vaihtaa omaa valintaansa ennen kun peli on päättynyt.
    }

    /**
     * Tuhoaa kaiken peleihin liittymistiedot pelaaja kohtaisesti
     * 
     * 
     * Tosin todellisuudessa jottei muiden peli ilo mene hukaan niin pelien poiston
     * sijasta vaihdetaan pelissä ollut pelaaja aina oikeassa olevaan ja aina pelaamaan
     * halukkaaseen ONETRUEBOTGOD käyttäjään.
     * 
     * @param type $id
     */
    public static function destroyByPlayerId($id) {
        $query = DB::connection()->prepare('UPDATE Playergame SET player_id = 165 WHERE player_id = :id ');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        Kint::dump($row);
//        error_log('Tätä ei pidä käyttää missään tilanteessa');
        //TODO: Aina kun pelaaja poistetaan niin pelien invalidoinnin välttämiseksi tee dummy account joka korvaa sen jälkeen pelaajan ja sitten dummy account saa voitot ja häviöt
    }

    /**
     * Tuhoaa peliin osallistumiset. 
     * 
     * @param type $id
     */
    public function destroyByGameId($id) {
        $query = DB::connection()->prepare('DELETE FROM Playergame WHERE game_id = :id ');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        Kint::dump($row);
    }

}
