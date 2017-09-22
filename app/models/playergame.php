<?php

/**
 * Description of playergame
 *
 * @author olindqvi
 */
class playergame  extends BaseModel{

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

}
