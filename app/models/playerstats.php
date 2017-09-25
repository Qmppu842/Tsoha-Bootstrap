<?php

/**
 * Description of playerstats
 *
 * @author olindqvi
 */
class playerstats extends BaseModel {

    public $player_id, $won, $lost, $tie, $best_streak, $avg_streak, $curr_streak, $nemesis, $fav_card, $elo;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Playerstats WHERE player_id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $game = new playerstats(array(
                'player_id' => $row['player_id'],
                'won' => $row['won'],
                'lost' => $row['lost'],
                'tie' => $row['tie'],
                'best_streak' => $row['best_streak'],
                'avg_streak' => $row['avg_streak'],
                'curr_streak' => $row['curr_streak'],
                'nemesis' => $row['nemesis'],
                'fav_card' => $row['fav_card'],
                'elo' => $row['elo']
            ));
        }
        return $game;
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Playerstats');
        $query->execute();

        $rows = $query->fetchAll();
        $games = array();

        foreach ($rows as $row) {
            $games[] = new playerstats(array(
                'player_id' => $row['player_id'],
                'won' => $row['won'],
                'lost' => $row['lost'],
                'tie' => $row['tie'],
                'best_streak' => $row['best_streak'],
                'avg_streak' => $row['avg_streak'],
                'curr_streak' => $row['curr_streak'],
                'nemesis' => $row['nemesis'],
                'fav_card' => $row['fav_card'],
                'elo' => $row['elo']
            ));
        }
        return $games;
    }
    
    
    public function getNemesis() {
        return $this->nemesis;
    }
    

}
