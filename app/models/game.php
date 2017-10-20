<?php

/**
 * Description of game 
 *
 * @author olindqvi
 */
class Game extends BaseModel {

    public $id, $name, $max_players, $is_over_yet;

    public function __construct($attributes) {
        parent::__construct($attributes);
        settype($this->is_over_yet, 'boolean');
        $this->is_over_yet = false;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Game WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $game = new Game(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'max_players' => $row['max_players'],
                'is_over_yet' => $row['is_over_yet']
            ));
        }
        return $game;
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Game');
        $query->execute();

        $rows = $query->fetchAll();
        $games = array();

        foreach ($rows as $row) {
            $games[] = new Game(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'max_players' => $row['max_players'],
                'is_over_yet' => $row['is_over_yet']
            ));
        }

//        var_dump($games);
        Kint::dump($games);
        return $games;
    }

    public function save() {
        var_dump($this);
        Kint::trace();
//        die();
        $query = DB::connection()->prepare('INSERT INTO Game (name, max_players, is_over_yet) VALUES (:name, :max_players, :is_over_yet) RETURNING id;');
        $query->execute(array('name' => $this->name, 'max_players'
            => $this->max_players, 'is_over_yet' => $this->getIs_over_yet_for_db()));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function save2() {
        var_dump($this);
        Kint::trace();
        die();
        $query = DB::connection()->prepare('INSERT INTO Game (name, is_over_yet) VALUES (:name, :is_over_yet) RETURNING id;');
        $query->execute(array('name' => $this->name, 'is_over_yet' => $this->getIs_over_yet_for_db()));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function save3() {
//        var_dump($this);
//        Kint::trace();
//        die();
        $query = DB::connection()->prepare('INSERT INTO Game (name, is_over_yet) VALUES (:name, :is_over_yet) RETURNING id;');
        var_dump($this);
        echo '<br/>';
//        die();
        $query->execute(array('name' => $this->name,
            'is_over_yet' => $this->getIs_over_yet_for_db()));
        $query->debugDumpParams();

//        var_dump($this);
        $row = $query->fetch();
//        var_dump($this);
        $this->id = $row['id'];
//        var_dump($this);
    }

    function getIs_over_yet_for_db() {
        return $this->is_over_yet ? 'true' : 'false';
    }

    public function save4() {
//        var_dump($this);
//        Kint::trace();
//        die();
        $query = DB::connection()->prepare('INSERT INTO Game (name, is_over_yet) VALUES (:name, :is_over_yet) RETURNING id;');
//        var_dump($this);
        $query->execute(array('name' => $this->name, 'is_over_yet' => $this->getIs_over_yet_for_db()));
//        var_dump($this);
        $row = $query->fetch();
//        var_dump($this);
        $this->id = $row['id'];
//        var_dump($this);
    }

    public function update($id) {
//        echo '<pre>';
//        var_dump($this);
//        echo '</pre>';
//        Kint::trace();
//        die();
        $query = DB::connection()->prepare('UPDATE Game SET name = :name, is_over_yet = :is_over_yet WHERE id = :id ');
        $query->execute(array('name' => $this->name, 'is_over_yet' => $this->getIs_over_yet_for_db(), 'id' => $id));
        $row = $query->fetch();

        Kint::dump($row);
    }

    public function destroy($id) {
        $query = DB::connection()->prepare('DELETE FROM Game WHERE id = :id ');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        Kint::dump($row);
    }

    public static function endGame($game_id) {
        $game = self::find($game_id);
        $game->setIs_over_yet(true);
        $game->update($game_id);
    }

    function setIs_over_yet($is_over_yet) {
        $this->is_over_yet = $is_over_yet;
        return $this;
    }

}
